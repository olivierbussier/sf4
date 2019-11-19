<?php

namespace App\Classes\Materiel;

use App\Classes\Config\Config;
use App\Entity\Adherent;
use App\Entity\LocRefs;
use App\Entity\MatCal;
use App\Entity\MatCarac;
use App\Repository\MatCalRepository;
use App\Repository\MatCaracRepository;
use DateTime;
use DateTimeZone;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Monolog\Logger;

/****************************************************************************************
Procédures de réservation matériel

 * libererResa($ref) : Liberer une réservation a partir de sa ref dans la base
 *
Tables utilisées :

Une table des caractéristiques matériel (nom, numéro, type, Compteur d'usage, ... )
Une table du calendrier de réservations pour les matériels qui contient
 - Une ligne pour chaque période continue ou un matériel est libre
 - Une ligne pour chaque période continue ou le matériel est indisponible
   (réservé, sorti, restitué, maintenance)

On lie les tables de caractéristiques matériel et calendrier de réservation
par la clé primaire de la table caractéristiques de matériel
(jointure des deux tables par 'Table Caracteristiques Materiel'.Ref = 'Table calendrier'.'Ref Materiel'

A la création de chaque matériel:
 - Une ligne de caractéristiques est créée
 - Une ligne 'matériel libre' est créée avec date début = '01/01/2000'
   et date de fin = '31/12/2099'

Pour trouver un matériel libre entre les dates 'deb' et 'fin', il suffit de faire une requete
 - select * from calendrier where status = 'libre' and ((datedeb >= deb) and (datefin <= fin))

On ordonne les lignes rendues par cette requette avec le compteur d'usage
 - order by usagecount asc

Les assets le moins utilisés sont classés au début

Ensuite on prends la 1ere Ref rendue et on splite la ligne en 3 pour créer la résa
Une ligne avant la résa, une ligne oendant la résa et une ligne après la résa

 - update mat set mat.datefin = datedeb where mat.Ref = Ref                      // before res
 - insert mat set mat.Det = Det, mat.datedeb =  datefin, mat.datefin = datefin   // after res
 - insert mat set mat.Det = Det, mat.datedeb = datedeb, mat.datefin = datefin, mat.user = user,
   status = "pris"  // During res
*****************************************************************************************/

class Resa
{
    public const LIBRE           = 'libre';             // Matériel non réservé
    public const PRERESERVE      = 'preReserve';        // Matériel préréservé pour une durée limitée
    public const RESERVE         = 'reserve';           // Matériel réservé
    public const ENCOURS         = 'encours';           // Le matériel est sorti du stock
    public const MAINTENANCE     = 'maintenance';       // Le matériel est en maintenance
    public const RESTITUE        = 'restitue';          // Le matériel à été restitué
    public const RESERVENONSORTI = 'reserve_non_sorti'; // Le matériel avait été réservé mais pas sorti sur la période

    /** @var EntityManager $em */
    private $em;

    /** @var MatCalRepository $matCal */
    private $matCal;

    /** @var MatCaracRepository $matCarac */
    private $matCarac;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->matCal = $em->getRepository(MatCal::class);
        $this->matCarac = $em->getRepository(MatCarac::class);
    }

    /**
     * @param string $assettype
     * @param bool $fNotEmpty
     * @return bool
     */
    public function checkType(string $assettype, bool $fNotEmpty = false): bool
    {
        if ($assettype == '' && $fNotEmpty == false) {
            return true;
        }

        $res = $this->matCarac->getDistinctTypes();

        foreach ($res as $type) {
            if ($assettype == $type['AssetType'])
                return true;
        }
        return false;
    }

    /**
     * @param $status
     * @param bool $fNotEmpty
     * @return bool
     */
    public function checkStatus(string $status, bool $fNotEmpty = false): bool
    {
        if ($status != self::PRERESERVE  &&     // Pré-réservation
            $status != self::RESERVE     &&     // Réservation
            $status != self::ENCOURS     &&     // Le matériel est sorti du stock
            $status != self::MAINTENANCE &&     // Le matériel est en maintenance
            $status != self::RESTITUE) {        // Le matériel à été restitué
            if ($status == '' && $fNotEmpty == false) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * @param string|DateTime $date
     * @return bool|DateTime
     */
    private function getDate($date)
    {
        if ($date == '') {
            return false;
        }
        $deb = DateTime::createFromFormat('d/m/Y', $date);
        if ($deb == false) {
            $deb = DateTime::createFromFormat('d-m-Y', $date);
            if ($deb == false) {
                $deb = DateTime::createFromFormat('Y-m-d', $date);
                if ($deb == false) {
                    $deb = DateTime::createFromFormat('Y/m/d', $date);
                    if ($deb == false) {
                        return false;
                    }
                }
            }
        }
        $deb->setTimezone(new DateTimeZone('Europe/Paris'));
        $deb->setTime(0,0,0);
        return $deb;
    }

    /**
     * @param string $datedeb
     * @param string $datefin
     * @return bool
     * @throws Exception
     */
    public function checkDates(string $datedeb, string $datefin): bool
    {
        if ($datedeb == '' || $datefin == '') {
           return false;
        }
        $deb = $this->getDate($datedeb);
        $fin = $this->getDate($datefin);

        if ($deb == false || $fin == false) {
            return false;
        }

        if ($deb >= $fin) {
            return false;
        }
        return true;
    }

    /**
     * Confirmer une pré-réservation
     *   - return true si OK
     *   - return false si KO
     * @param int $refElement
     * @return bool
     * @throws Exception
     */
    public function confirmerRef(int $refElement)
    {
        if (($element = $this->verifierRef($refElement)) != null) {
            $element->setStatus(self::RESERVE);
            $this->em->persist($element);
            $this->em->flush($element);
        }
        return $element != null;
    }

    /**
     * @param int $RefResa
     * @return MatCal
     * @throws Exception
     */
    public function verifierRef(int $RefResa) : ?MatCal
    {
        // Recherche si la résa spécifiée existe

        //$this->libereExpiredPreResa();

        /** @var MatCal[] $res */
        $res = $this->em->createQueryBuilder()
            ->select('mc')
            ->from(MatCal::class, 'mc')
            ->where("mc.status <> '" . self::LIBRE . "'")
            ->andWhere("mc.id = $RefResa")
            ->getQuery()
            ->getResult();

        if (count($res) == 0) { // Pas de résa trouvé
            return null;
        }

        if (count($res) == 1) { // 1 matériel trouvé
            return $res[0];
        } else {
            return null;
        }
    }

    /**
     * Ajustement des réservations de la base
     *  - Dates de sorties, dates de retour
     * @throws Exception
     */
    public function verifierReservations()
    {
        // Cas des pré-réservations expirées
        $this->libereExpiredPreResa();

        $today = (new DateTime("now",new DateTimeZone('Europe/Paris')))->format('Y-m-d');
        // Cas des sorties en retard

        $dql = $this->em->createQueryBuilder()
            ->select(['ml', 'mc'])
            ->from(MatCal::class,'ml')
            ->leftJoin('ml.MatCarac','mc')
            ->andWhere("'$today' >  ml.dateDebut")
            //->andWhere("'$today' <= ml.dateFin")
            ->andWhere("(ml.status = '" . self::RESERVE ."' or ml.status = '" . self::PRERESERVE ."' or ml.status = '" . self::ENCOURS ."')")
            ->orderBy('mc.UsageCount, mc.AssetNum', 'ASC')
            ->getQuery();
        $sql = $dql->getSQL(); echo $sql;
        $res = $dql->execute();

        if (count($res) == 0) { // Pas de résa trouvé
            return false;
        }

        /** @var MatCal[] $res */
        foreach ($res as $expr) {
            switch ($expr->getStatus()) {
                case self::RESERVE:
                    // Si la date est > datedeb alors
                    // On ajuste datedeb
                    // Si before est dans le status RESERVENONSORTI on ajuste la datefin de before
                    // Si before est dans un autre status on crée une MatCal RESERVENONSORTI entre ddeb et today
                case self::ENCOURS:
                    // Si today est > datefin de resa alors
                    // il faut lister toutes les MatCal (next) dont :
                    //      - datedeb de next > datefin de resa et datedeb < today
                    // Pour chacune des next :
                    //  - Si today next est LIBRE au moins jusqu'à today,
                    //     -> on ajuste datefin de resa
                    //     -> on modifie datedeb de next avec today
                    //  - Si today est après la datefin de next
                    //     -> on ajuste resa jusqu'a datefin de next
                    //     -> on supprime next

            }
        }
    }

    /**
     * @param MatCal|int $resa
     * @return void
     * @throws Exception
     */
    public function resetExpiredPreResa($resa)
    {
        if (is_int($resa)) {
            $mcr = $this->em->getRepository(MatCal::class);
            $resa = $mcr->find($resa);
        }
        $resa->setCreatedAt(new DateTime("now",new DateTimeZone('Europe/Paris')));
        $this->em->persist($resa);
        $this->em->flush();
    }

    /**
     * @return bool|int
     * @throws Exception
     */
    public function libereExpiredPreResa()
    {
        $qb = $this->em->createQueryBuilder();
        $res = $qb
            ->select("p, c")
            ->from(MatCal::class, 'p')
            ->leftJoin('p.MatCarac','c')
            ->where("p.status = '". self::PRERESERVE . "'")
            ->andWhere("current_timestamp() - p.createdAt > " . Config::validitePreResa)
            ->getQuery()
            ->execute();

        $cnt = count($res);
        if ($cnt == 0) { // Pas de matériel trouvé
            return false;
        }
        foreach ($res as $expr) { // matériel trouvé
            /** @var $expr MatCal */
            $this->libereResa($expr);
        }
        return $cnt;
    }

    /*****************************************************************************************
    Libération d'asset par dates , user et type de matériel
     Si $assettype et $assetnum ne sont pas spécifiés, alors la fonction libère tout les
        DONE matériels réservés pae cet $user a ces dates
     - return true si OK
     - return false si KO
    *****************************************************************************************/
    /**
     * @param MatCal|int $expr
     * @return bool
     * @throws ConnectionException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function libereResa($expr)
    {
        if (is_int($expr) || is_string($expr)) {
            $rp = $this->em->getRepository(MatCal::class);
            $expr = $rp->find($expr);
        }

        $assetref = $expr->getMatCarac()->getId();
        $datedeb  = $expr->getDateDebut();
        $datefin  = $expr->getDateFin();
        $status   = $expr->getStatus();

        // Verif du type de resa a libérer

        switch ($status) {
            case self::LIBRE:
                return false;
                break;
            case self::RESERVE:
            case self::PRERESERVE:
                // Le matériel n'est pas sorti, on décompte UsageCount
                //$matCarac = $expr->getMatCarac();
                //$matCarac->setUsageCount($matCarac->getUsageCount()-1);
                //$this->em->persist($matCarac);
                break;
            case self::ENCOURS:
                // Matériel sorti, on doit restituer, non libérer
                return false;
                break;
            case self::MAINTENANCE:
                // Matériel non reservable a priori
                return false;
                break;
        }
        $this->em->getConnection()->beginTransaction();

        // Recherche before

        $qb = $this->em->createQueryBuilder();
        $before = $qb
            ->select("p, c")
            ->from(MatCal::class, 'p')
            ->leftJoin('p.MatCarac','c')
            ->where("c.id = $assetref")
            ->andWhere("p.dateFin = '". $datedeb->format('Y-m-d') ."'")
            ->getQuery()
            ->execute();

        $qb = $this->em->createQueryBuilder();
        $after = $qb
            ->select("p, c")
            ->from(MatCal::class, 'p')
            ->leftJoin('p.MatCarac','c')
            ->where("c.id = $assetref")
            ->andWhere("p.dateDebut = '" . $datefin->format('Y-m-d') . "'")
            ->getQuery()
            ->execute();

        if (count($before) != 0) {
            // Il y a un before

            /** @var MatCal[] $before */
            if ($before[0]->getStatus() != 'libre') {
                // Si la ligne avant n'est pas libre alors on ne merge pas
                // On change le status en libre
                $before[0] = $expr;
                $expr->setStatus('libre');
                $expr->setRefResa(0);
                $this->em->persist($expr);
            } else {
                // Before est libre, on y ajoute la range de dates de la résa a annuler
                // puis on supprime la resa
                $before[0]->setDateFin($datefin);
                $this->em->persist($before[0]);

                $this->em->remove($expr);
            }
        } else {
            // Il n'y a pas de before
            $before[0] = $expr;
            $expr->setStatus('libre')
                 ->setRefResa(null);
            $this->em->persist($expr);
        }
        // Arrivé ici, $before est a merger avec after si after est libre
        // RechercheAfter

        if (count($after) != 0) {
            // Il y a un after
            /** @var MatCal[] $after */
            if ($after[0]->getStatus() == 'libre') {
                // After est libre, on y ajoute la range de dates de la ligne refbefore
                // puis on supprime after

                $before[0]->setDateFin($after[0]->getDateFin());
                $this->em->persist($before[0]);

                $this->em->remove($after[0]);
            } // Sinon on ne fait rien
        }
        $this->em->flush();

        $this->em->getConnection()->commit();
        return true;
    }

    /**
     * Liste des caractéristiques d'asset disponibles
     *
     * @param string $datedeb Date d'emprunt
     * @param string $datefin Date de retour
     * @param string $assettype Type de matériel à réserver
     * @return array|bool
     * @throws \Exception
     */
    public function listeAvailableCaract(
        string $datedeb,
        string $datefin,
        string $assettype = ''
    ) {
        $this->libereExpiredPreResa();

        if (($this->checkDates($datedeb, $datefin) == false) ||
            ($this->checkType($assettype) == false)) {
            return false;
        }

        $qb = $this->em->createQueryBuilder()
            ->select("c.Caracteristique")
            ->from(MatCal::class, 'l')
            ->leftJoin('l.MatCarac','c')
            ->where("l.status = '" . self::LIBRE ."'")
            ->andWhere("l.dateDebut <= '" . $datedeb . "'")
            ->andWhere("l.dateFin >= '" . $datefin . "'")
            ->orderBy('c.AssetType, c.UsageCount', 'asc');

        if ($assettype != '') {
            $qb->andWhere("c.AssetType = '$assettype'");
        }

        $res = $qb->getQuery()
                  ->execute();

        if (count($res) == 0) {
            return false;
        }

        $ret = [];
        foreach ($res as $r) {
            $caract = $r['Caracteristique'];
            if (!isset($ret[$caract])) {
                $ret[$caract] = 1;
            } else {
                $ret[$caract]++;
            }
        }
        return $ret;
    }

    /*****************************************************************************************
    Liste d'asset dispo a des dates données
    Si $assetnum n'est pas spécifié, alors la fonction liste tous les matériels dispo
    - return tableau de 1 a n matériel si OK, sous la forme :
    $tab[0..n-1]['Ref'] = Référence de l'asset
    $tab[0..n-1]['UsageCount'] = Nombre d'utilisations de l'asset
    $tab[0..n-1]['AssetType']
    $tab[0..n-1]['AssetNum']
    $tab[0..n-1]['Caracteristique']
    - return false si KO
     *****************************************************************************************
     * @param string $datedeb Date d'emprunt
     * @param string $datefin Date de retour
     * @param string $assettype Type de matériel à réserver
     * @param string $assetnum Matériel en particulier
     * @param string $caract Caractéristique du matériel (15L,DIN, ...)
     * @return array|bool
     * @throws Exception
     */
    public function listeAvailable(
        string $datedeb,
        string $datefin,
        string $assettype = '',
        string $assetnum = '',
        string $caract = ''
    ) {
        $this->libereExpiredPreResa();

        if (($this->checkDates($datedeb, $datefin) == false) ||
            ($this->checkType($assettype) == false)) {
            return false;
        }

        $em = $this->em;
        $pr = $em->createQueryBuilder()
            ->select(['ml', 'mc'])
            ->from(MatCal::class,'ml')
            ->leftJoin('ml.MatCarac','mc')
            ->where("ml.status = 'libre'")
            ->andWhere("ml.dateDebut <= '$datedeb'")
            ->andWhere("ml.dateFin >= '$datefin'")
            ->orderBy('mc.AssetType, mc.UsageCount', 'ASC');

        if ($assettype != '') {
            $pr->andWhere("mc.AssetType = '$assettype'");
        }
        if ($assetnum  != '') {
            $pr->andWhere("mc.AssetNum  = '$assetnum'");
        }
        if ($caract    != '') {
            $pr->andWhere("mc.Caracteristique = '$caract'");
        }
        $sql = $pr->getQuery();
        $res = $sql->execute();

        if (count($res) == 0) { // Pas de résa en conflit
            return false;
        }
        return $res;
    }

    /*****************************************************************************************
    Liste les résa en conflit pour un matériel donnée sur une période donnée
    - return tableau de 1 ou 2 résa si OK, sous la forme :
    $tab[0..1]['Ref']  = Référence de la résa
    $tab[0..1]['User'] = Utilisateur
    DONE    $tab[0..1]['ddeb'] = Date de début
    $tab[0..1]['dfin'] = Date de fin
    $tab[0..1]['status'] = Status de la résa
    - return false si pas de conflit
     *****************************************************************************************/
    /**
     * @param string $datedeb Date d'emprunt (Démarre le mercredi)
     * @param string $datefin Date de retour
     * @param string $assettype Type de matériel à réserver
     * @param string $assetnum Matériel en particulier
     * @return array|bool
     * @throws Exception
     */
    public function getConflit(
        string $datedeb,
        string $datefin,
        string $assettype,
        string $assetnum
    ) {

        $this->libereExpiredPreResa();

        if ($this->checkDates($datedeb, $datefin) == false ||
            $this->checkType($assettype, true) == false) {
            return false;
        }

        $em = $this->em;
        $r = $em->createQueryBuilder()
            ->select('mc')
            ->from(MatCarac::class,"mc")
            ->where("mc.AssetType = '$assettype'")
            ->getQuery()
            ->execute();

        $tabres =[];

        /** @var MatCarac $v */
        foreach ($r as $v) {
                $tabres[$v->getAssetNum()] = [
                    'status' => 'libre',
                    'carac'  => $v->getCaracteristique()
                ];
        }

        $pr = $em->createQueryBuilder()
            ->select(['ml', 'mc', 'adh'])
            ->from(MatCal::class,'ml')
            ->join('ml.MatCarac','mc')
            ->join('ml.RefUser', 'adh')
            ->where("mc.AssetType = '$assettype'")
            //->andWhere("mc.AssetNum = '$assetnum'")
            ->andWhere("ml.status <> 'libre'")
            ->andWhere("((ml.dateDebut >= '$datedeb' and ml.dateDebut <= '$datefin') or (ml.dateFin >= '$datedeb' and ml.dateFin <= '$datefin'))")
            ->orderBy('ml.dateDebut, adh.Nom', 'ASC');

        $dql = $pr->getQuery();
        $sql = $dql->getSQL();
        $res = $dql->execute();

/*
        $sql =  "select @#@loc_matcal.Ref, @#@loc_matcarac.AssetNum, AssetRef,ddeb,dfin,@#@loc_matcal.status, nom, prenom ".
            "from @#@loc_matcal ".
            "join @#@loc_matcarac on @#@loc_matcal.AssetRef = @#@loc_matcarac.Ref ".
            "join @#@liste on @#@loc_matcal.RefUser = @#@liste.Ref ".
            "where (AssetType = '$assettype') ".
            "and (AssetNum = '$assetnum') ".
            "and (@#@loc_matcal.status <> 'libre') ".
            "and (((ddeb >='$datedeb') and (ddeb <= '$datefin')) ".
            "or   ((dfin >='$datedeb') and (dfin <= '$datefin')))".
            "order by ddeb";
*/

        /** @var MatCal $r */
        foreach($res as $r) {
            $num = $r->getMatCarac()->getAssetNum();
            $usr = $r->getRefUser();
            $tabres[$num] = [
                'status' => $r->getStatus(),
                'nom'    => $r->getRefUser()->getUsername(),
                'id'     => $r->getRefUser()->getId(),
                'ddeb'   => $r->getDateDebut(),
                'dfin'   => $r->getDateFin(),
                'carac'  => $r->getMatCarac()->getCaracteristique()
            ];
        }
        return $tabres;
    }

    /*****************************************************************************************
    Réserver une asset à des dates données
        Si $assetnum n'est pas spécifié, alors la fonction réserve le moins utilisé des dispo
     - return Ref matériel si OK
     - return false si KO
    *****************************************************************************************/
    /**
     * @param string $datedeb Date d'emprunt
     * @param string $datefin Date de retour
     * @param string $refUser
     * @param string $assettype Type de matériel à réserver
     * @param string $typeSortie
     * @param int $refResa
     * @param string $caract Caractéristique du matériel (15L,DIN, ...)
     * @param string $assetnum Matériel en particulier
     * @param string $status Type de résa : preReserve, reserve, maintenance
     * @return mixed
     * @throws Exception
     */
    public function reserveResa(
        string $datedeb,
        string $datefin,
        string $refUser,
        string $assettype,
        string $typeSortie,
        int    $refResa,
        string $caract = '',
        string $assetnum = '',
        string $status = "reserve"

    ) {

        $this->libereExpiredPreResa();

        /**
         * todo : Ajouter un champ flag 'fSorti' dans matcarac pour signaler qu'une asset est sortie.
             Ce champ sera positionné a true lorsque le matériel est sorti réellement, et remis
             a false uniquement lors de la restitution.
             Ensuite, dans la fonction ReserverAsset, on ne liste que les matériels ayant le flag a false
        */

        // $datedeb < $datefin
        // $datefin - $datedeb > 1

        if (($this->checkDates($datedeb, $datefin) == false) ||
            ($this->checkType($assettype, true) == false) ||
            ($this->checkStatus($status) == false)) {
            return false;
        }

        // On peut tenter une caractéristique particulière:
        //  - 15L, Etrier, DIN, ...

        // Section critique

        $this->em->getConnection()->beginTransaction();

        $em = $this->em;
        $pr = $em->createQueryBuilder()
            ->select(['ml', 'mc'])
            ->from(MatCal::class,'ml')
            ->leftJoin('ml.MatCarac','mc')
            ->where("mc.AssetType = '$assettype'")
            ->andWhere("ml.status = 'libre'")
            ->andWhere("ml.dateDebut <= '$datedeb'")
            ->andWhere("ml.dateFin >= '$datefin'")
            ->orderBy('mc.UsageCount, mc.AssetNum', 'ASC');

        if ($assetnum  != '') {
            $pr->andWhere("mc.AssetNum  = '$assetnum'");
        }
        if ($caract    != '') {
            $pr->andWhere("mc.Caracteristique = '$caract'");
        }
        $sql = $pr->getQuery();
        $res = $sql->execute();

        // Le matériel est trié par compteur d'usage, les premiers de liste sont les matériels
        // dispos à ces dates et ayant été le moins utilisés

        if (count($res) == 0) {
            // Pas de matériel dispo au dates demandées
            // Fin de section critique

            $this->em->getConnection()->commit();

            // Et retour en erreur

            return false;
        }

        // Ensuite on prends la 1ere Ref dispo (la moins utilisée des dispo)
        // et on splite la ligne en 3 pour créer la résa

        /** @var MatCal $matcal */
        $matcal = $res[0];

        $MatCarac = $matcal->getMatCarac();
        $ddeb     = $matcal->getDateDebut();
        $dfin     = $matcal->getDateFin();

        // Mise à jour de la ligne pour la période avant résa


        if ($ddeb != new DateTime($datedeb, new DateTimeZone('Europe/Paris'))) {
            $matcal->setDateFin(new DateTime($datedeb, new DateTimeZone('Europe/Paris')));
            $em->persist($matcal);
            //$db->query("update @#@loc_matcal set dfin = '$datedeb' where Ref = $Ref"); // before res
        } else {
            $em->remove($matcal);
        }
        // Création de la ligne spécifique pour la résa

        $adhRepo = $em->getRepository(Adherent::class);
        /** @var Adherent $adherent */
        $adherent = $adhRepo->find($refUser);
        $matcal = new MatCal();
        $matcal
            ->setCreatedAt(new DateTime("now", new DateTimeZone('Europe/Paris')))
            ->setMatCarac($MatCarac)
            ->setDateDebut(new DateTime($datedeb, new DateTimeZone('Europe/Paris')))
            ->setDateFin(new DateTime($datefin, new DateTimeZone('Europe/Paris')))
            ->setTypeSortie($typeSortie)
            ->setRefUser($adherent)
            ->setStatus($status)
            ->setAssetText('')
            ->setRefResa($refResa);

        $em->persist($matcal);
        $em->flush($matcal);


        // Création de la ligne après résa

        if ($dfin != new DateTime($datefin, new DateTimeZone('Europe/Paris'))) {
            $after = new MatCal();
            $after
                ->setCreatedAt(new DateTime("now", new DateTimeZone('Europe/Paris')))
                ->setMatCarac($MatCarac)
                ->setDateDebut(new DateTime($datefin, new DateTimeZone('Europe/Paris')))
                ->setDateFin($dfin)
                ->setTypeSortie('')
                ->setStatus('libre')
                ->setAssetText('')
                ->setRefResa(0);

            $em->persist($after);
        }

        $em->persist($MatCarac);
        $em->flush();

        // Fin de la transaction

        $this->em->getConnection()->commit();

        return $matcal;
    }

    /**
     * Recherche si une ou plusieurs resa existe a ces dates pour cet adhérent
     * @param MatCal $ref
     * @return bool
     * @throws Exception
     */
    public function sortirAsset(MatCal $ref, $dateSortie = null): bool
    {
        $this->libereExpiredPreResa();

        $res = $this->verifierRef($ref);

        if (!$res) { // Pas de matériel trouvé
            return false;
        }

        if ($dateSortie == null) {
            $dateSortie = (new DateTime("now", new DateTimeZone('Europe/Paris')));
        } elseif (is_string($dateSortie)) {
            $dateSortie = $this->getDate($dateSortie);
        }

        $this->em->getConnection()->beginTransaction();

        $ddeb = $ref->getDateDebut();
        $dfin = $ref->getDateFin();

        if ($dateSortie >= $dfin) {
            // Passer la MatCal en RESERVENONSORTI
            $ref->setStatus(self::RESERVENONSORTI);
            $this->em->persist($ref);
            $this->em->flush();
            $this->em->getConnection()->commit();
            return false;
        } elseif ($dateSortie > $ddeb and $dateSortie < $dfin) {
            // Ajuster la date de sortie réelle et créér une MatCal 'RESERVENONSORTI
            $ref->setDateDebut($dateSortie);
            $ref->setStatus(self::ENCOURS);
            $this->em->persist($ref);

            $before = new MatCal();
            $before->setStatus(self::RESERVENONSORTI)
                ->setDateDebut($ddeb)
                ->setDateFin($dateSortie)
                ->setRefUser($ref->getRefUser())
                ->setMatCarac($ref->getMatCarac())
                ->setRefResa(0)
                ->setCreatedAt(new DateTime("now", new DateTimeZone('Europe/Paris')))
                ->setAssetText($ref->getAssetText())
                ->setTypeSortie($ref->getTypeSortie())
                ->setCommentaire($ref->getCommentaire());
            $this->em->persist($before);
        }
        // if datesortie = ddeb -> Cas nominal
        // Mise à jour du champ 'usage matériel'

        $mc = $ref->getMatCarac();
        $mc->setUsageCount($mc->getUsageCount()+1);
        $this->em->persist($mc);

        $ref->setStatus(self::ENCOURS);

        $this->em->persist($ref);
        $this->em->flush();

        return true;
    }

    /**
     * @param MatCal $ref
     * @param string|DateTime|null $dateRestit
     * @return bool
     * @throws Exception
     */
    public function restituerAsset(MatCal $ref, $dateRestit = null): bool
    {
        if ($dateRestit == null) {
            $dateRestit = (new DateTime("now", new DateTimeZone('Europe/Paris')));
        } elseif (is_string($dateRestit)) {
            $dateRestit = $this->getDate($dateRestit);
        }

        $this->libereExpiredPreResa();

        $res = $this->verifierRef($ref);

        if (!$res) { // Pas de matériel trouvé
            return false;
        }

        $this->em->getConnection()->beginTransaction();

        $ddeb = $ref->getDateDebut();
        $dfin = $ref->getDateFin();
        $assetref = $ref->getMatCarac()->getId();

        if ($dateRestit > $ddeb and $dateRestit < $dfin) {
            // Restitué avant la fin : Splitter la résa en deux
            // ddeb -> today : Mettre status restitué
            // today -> dfin : mettre status libre et merger avec after si libre également

            $ref->setDateFin($dateRestit)
                ->setStatus(self::RESTITUE);
            $this->em->persist($ref);

            // Recherche de after

            /** @var MatCal[] $after */
            $after = $this->em->createQueryBuilder()
                ->select("p, c")
                ->from(MatCal::class, 'p')
                ->leftJoin('p.MatCarac', 'c')
                ->where("c.id = $assetref")
                ->andWhere("p.dateDebut = '" . $dfin->format('Y-m-d') . "'")
                ->andWhere("p.status = '" . self::LIBRE . "'")
                ->getQuery()
                ->execute();

            if (count($after) != 0) {
                // Il y a un after libre
                // mise a jour de la date début de cet after
                $after[0]->setDateDebut($dfin);
                $this->em->persist($ref);

            } else {
                // Pas d'after ou pas d'after libre
                // On en créée un
                $after = new MatCal();
                $after->setDateDebut($dateRestit);
                $after->setDateFin($dfin);
                $after->setStatus(self::LIBRE);
                $after->setCreatedAt(new DateTime("now", new DateTimeZone('Europe/Paris')));
                $after->setRefResa(null);
                $after->setMatCarac($ref->getMatCarac());
                $after->setRefUser(null);
                $this->em->persist($after);
            }
        } elseif($dateRestit == $dfin) {
            $ref->setStatus(self::RESTITUE);
            $this->em->persist($ref);
        }
        $this->em->flush($ref);
        $this->em->getConnection()->commit();
        return true;
    }

    /**
     * @param int|MatCal $ref
     * @return null|MatCal
     * @throws Exception
     */
    public function rechercheDetailsResa($ref)
    {
        $this->libereExpiredPreResa();

        if (is_int($ref)) {
            $mcRepo = $this->em->getRepository(MatCal::class);
            return $mcRepo->find($ref);
        }
        return $ref;
    }
}

