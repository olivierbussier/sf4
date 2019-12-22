/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)

require('../css/bootstrap.scss');
require('../css/global.scss');
require('../css/guc.scss');
require('../css/guc_frame.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.

const $ = require('jquery');
require('bootstrap');
require('util');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

require('./cookiebanner.min.js');
$(document).ready(function() {
    pb = require('./previewbox.js');
});

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

