/*
 * Fichier de dépendances Javascript et CSS utilisé par webpack encore
 * Ce fichier contient l'ensemble des dépendances nécessaires au chargement de toutes les pages
 * (inclus dans base.html.twig)
 */

// Fichiers CSS

require('../css/bootstrap.scss');
require('../css/global.scss');
require('../css/guc.scss');
require('../css/guc_frame.scss');

// jQuery

const $ = require('jquery');
global.$ = global.jQuery = $;

// Bootstrap

require('bootstrap');

// Preview (TODO : n'est utilisé que par l'édition de la page d'accueil, a déplacer)

$(document).ready(function() {
    pb = require('./components/previewbox.js');
});

// Affichare du message d'avertissement cookie RGPD

require('./components/cookiebanner.min.js');

var options = {
    'position':     "top",
    'fg':           "#ffffff",
    'bg':           "#3b5269",
    'link':         "#dddddd",
    'moreinfo':     "http://www.cnil.fr/vos-obligations/sites-web-cookies-et-autres-traceurs/que-dit-la-loi/",
    'message':      "Les cookies assurent le bon fonctionnement de notre site Internet En utilisant ce dernier, vous acceptez leur utilisation.",
    'linkmsg':      "En savoir plus",
    'effect':       "fade",
    'expires':      30 * 24 * 60 * 60,
    'zindex':       "11000",
    'height':       "64px",
    'font-size':    "22px"
};

var cb = new Cookiebanner(options); cb.run();

