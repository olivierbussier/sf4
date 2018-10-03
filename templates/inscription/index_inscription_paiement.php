<?php

namespace App\Inscription;

use App\Incl\Classes\Form;
use App\Incl\Classes\Globals;
use App\Incl\Classes\Session;

use App\Incl\Html\Header;

use App\Incl\Log\LogAppli;

session_start();

include_once __DIR__ . '/../bootstrap.php';

LogAppli::logAppli(LogAppli::LOGOK, "Inscription paiement");

$post = Session::get('POST');

Form::initialise(null, $post);

$cost = new Calculate();
$res = $cost->calcCotis($post);
$axa = $cost->calcAxa(Form::get('ASSURANCE'));

$totalCotis = $res['prixCotis'] + $res['prixLicence'] - ($res['prixReduc'] + $res['prixRemb']) + $axa['prixAxa'];

if (!Session::isOpen()) {
    //db_log_message("+ERR : fonction check_inscription.php - NOM et/ou PRENOM non initialisés");
    exit;
}

$html = new Header('..');
$html->start('Paiement', [
    "https://www.paypalobjects.com/api/checkout.js" => Header::EJS
]);
?>
<div class="container">
    <div class="col-xs-12">
        <h3>11 - Paiement</h3>
    <?php

    // Verifie si un paiement à déjà été effectué

    $db = Globals::getDb();
    $RefUsr = Session::get('REFUSR');

    $res = $db->query("select PaymentDate,PaymentID,PaymentAmount from @#@liste where Ref=$RefUsr");
    $tab = $db->nextrow($res);

    if ($tab['PaymentID'] != '' || $tab['PaymentDate'] != '') { ?>
        <div class="col-xs-12">
            <p>Votre paiement sous la référence <?= $tab['PaymentID'] ?> à déjà été enregistré pour cette pré-inscription</p>
            <?php Session::redirection('index_inscription_fin.php'); ?>
    <?php
    } else {
        if ((Globals::getConf())->paymentPaypal) {
            ?>
            <div class="col-xs-12">
                <p>Vous pouvez maintenant payer votre cotisation et votre assurance via paypal ou une carte de
                    crédit</p>
                <p>Le montant de la transaction à réaliser est de : <?= $totalCotis ?>€</p>
            </div>
            <div id="paypal-button-container"></div>
            <script>
                paypal.Button.render({
                    // Set your environment
                    env: 'sandbox', // sandbox | production
                    locale: 'fr_FR',
                    // Specify the style of the button
                    style: {
                        layout: 'vertical',  // horizontal | vertical
                        size: 'responsive',    // medium | large | responsive
                        shape: 'rect',      // pill | rect
                        color: 'gold'       // gold | blue | silver | black
                    },
                    // Specify allowed and disallowed funding sources
                    //
                    // Options:
                    // - paypal.FUNDING.CARD
                    // - paypal.FUNDING.CREDIT
                    // - paypal.FUNDING.ELV
                    funding: {
                        allowed: [paypal.FUNDING.CARD, paypal.FUNDING.CREDIT],
                        disallowed: []
                    },
                    // PayPal Client IDs - replace with your own
                    // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                    client: {
                        sandbox: 'AYj2oUoaiQQb_wfgQacdj73CVzdp_DS0Kak0ykumpUeALWwHnZnn2X5sidqAs5XkpB8lDhDhPtDbMjoI',
                        production: '<insert production client id>'
                    },
                    payment: function (data, actions) {
                        return paypal.request.post('../Incl/PayPal/Payment.php').then(function (data) {
                            return data.id
                        })
                    },
                    onAuthorize: function (data, actions) {
                        return paypal.request.post('../Incl/PayPal/Pay.php', {
                            paymentID: data.paymentID,
                            payerID: data.payerID
                        }).then(function (data) {
                            console.dir(data);
                            window.location.replace("index_inscription_fin.php");
                        }).catch(function (err) {
                            console.log('Erreur : ', err)
                        })
                    }
                }, '#paypal-button-container');
            </script>
            <div id="resultPaypal"></div>
            <?php
        }
    }
    Session::redirection('index_inscription_fin.php');
    ?>
    </div>
</div>
<?php $html->end();
