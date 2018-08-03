// Fonctions pour le menu latéral/top
// ----------------------------------
$(document).ready(function($) {
    $('#menu-icon').click(function (e) {
        e.preventDefault();
        $('body').toggleClass('with--sidebar');
    });

    $('#site-cache').click(function (e) {
        $('body').removeClass('with--sidebar');
    });

    $('#menu').click(function (e) {
        $('body').removeClass('with--sidebar');
    });

    $(window).scroll(function () {
        var currentScroll = $(window).scrollTop()
        //var bandeauHeight = $('#bandeau').height()
        if (currentScroll >= $('#bandeau').height()) {
            $('#menu').addClass('menu fixed')
        } else {
            $('#menu').removeClass('fixed')
        }
    })
});
