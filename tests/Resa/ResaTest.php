<?php
namespace App\Tests\Resa;


use App\Classes\Materiel\Resa;
use App\Entity\MatCal;
use DateTime;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResaTest extends KernelTestCase
{
    /** @var EntityManagerInterface $em  */
    private $em;

    private $resa;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->resa = new Resa($this->em);
    }

    public function testCheckTypes()
    {
        $this->assertEquals(false, $this->resa->checkType('Détendeur'));
        $this->assertEquals(true, $this->resa->checkType('Détendeur mer'));
        $this->assertEquals(true, $this->resa->checkType('Détendeur lac'));

        $this->assertEquals(true, $this->resa->checkType(''));
        $this->assertEquals(false, $this->resa->checkType('', true));
        $this->assertEquals(false, $this->resa->checkType('Détendeur', true));
    }

    public function testStatus()
    {
        $this->assertEquals(true, $this->resa->checkStatus('preReserve'));
        $this->assertEquals(true, $this->resa->checkStatus('reserve'));
        $this->assertEquals(true, $this->resa->checkStatus('encours'));
        $this->assertEquals(false, $this->resa->checkStatus('encoures'));

        $this->assertEquals(true, $this->resa->checkType(''));
        $this->assertEquals(false, $this->resa->checkType('', true));
        $this->assertEquals(false, $this->resa->checkStatus('encoures', true));
    }

    /**
     * @throws Exception
     */
    public function testDates()
    {
        $this->assertEquals(false, $this->resa->checkDates('', '13/09/2019'));
        $this->assertEquals(false, $this->resa->checkDates('13/09/2019', ''));
        $this->assertEquals(false, $this->resa->checkDates('', ''));

        $this->assertEquals(false, $this->resa->checkDates('13/09/2019', '12/09/2019'));
        $this->assertEquals(false, $this->resa->checkDates('13/09/2019', '13/09/2019'));
        $this->assertEquals(true, $this->resa->checkDates('13/09/2019', '14/09/2019'));

        $this->assertEquals(true, $this->resa->checkDates('13-09-2019', '14-09-2019'));
        $this->assertEquals(true, $this->resa->checkDates('13-09-2019', '14-09-2019'));
    }

    /**
     * @throws Exception
     */
    public function testListeAvailable()
    {
        $tab = $this->resa->listeAvailable(
            '2045-10-01',
            '2045-10-08',
            'Détendeur mer'
        );

        $this->assertInternalType('array', $tab);
        $this->assertGreaterThan(5, count($tab));

    }

    /**
     * @throws ConnectionException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testReserver()
    {
        $res1 = $this->resa->reserveResa('2019-10-01','2019-10-05',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res1);
        $res2 = $this->resa->reserveResa('2019-10-05','2019-10-10',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res2);
        $res4 = $this->resa->reserveResa('2019-10-15','2019-10-20',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res4);
        $res3 = $this->resa->reserveResa('2019-10-10','2019-10-15',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res3);

        $this->assertEquals(true, $this->resa->libereResa($res3));
        $this->assertEquals(true, $this->resa->libereResa($res4));
        $this->assertEquals(true, $this->resa->libereResa($res1));
        $this->assertEquals(true, $this->resa->libereResa($res2));
    }

    /**
     * @throws ConnectionException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function testSortirRestituer()
    {
        $res1 = $this->resa->reserveResa('2019-10-01','2019-10-05',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res1);
        $res2 = $this->resa->reserveResa('2019-10-05','2019-10-10',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res2);
        $res3 = $this->resa->reserveResa('2019-10-10','2019-10-15',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res3);
        $res4 = $this->resa->reserveResa('2019-10-15','2019-10-20',410,'Détendeur mer','Niolon');
        $this->assertInstanceOf(MatCal::class,$res4);

        $this->assertEquals(true, $this->resa->sortirAsset($res1, '2019-10-01'));
        $this->assertEquals(true, $this->resa->sortirAsset($res2, '2019-10-06'));
        $this->assertEquals(true, $this->resa->sortirAsset($res3, '2019-10-15'));
        $this->assertEquals(false, $this->resa->sortirAsset($res4, '2019-10-21'));
        $this->assertEquals(true, $this->resa->sortirAsset($res4, '2019-10-15'));

        $this->assertEquals(true, $this->resa->restituerAsset($res1, new DateTime('2019-10-05')));
        $this->assertEquals(true, $this->resa->restituerAsset($res2, new DateTime('2019-10-07')));
        $this->assertEquals(false, $this->resa->restituerAsset($res3, new DateTime('2019-10-10')));
        $this->assertEquals(true, $this->resa->restituerAsset($res4, new DateTime('2019-10-20')));
    }
}
