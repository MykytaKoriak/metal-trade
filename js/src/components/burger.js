import $ from "jquery";

$(document).ready(function () {
    var burger = $('.header-burger'),
        fixedBurger = $('.fixed-header-burger'),
        closeTopMenu = $('.top-menu-close'),
        topMenu = $('.top-menu');

    burger.on('click', function (e) {
        topMenu.addClass('top-menu-open');
        setTimeout(
            function () {
                $('body').addClass('menu-opened');
            }, 1000);
    })

    fixedBurger.on('click', function (e) {
        topMenu.addClass('top-menu-open');
        setTimeout(
            function () {
                $('body').addClass('menu-opened');
            }, 1000);
    })

    closeTopMenu.on('click', function (e) {
        $('body').removeClass('menu-opened');
        topMenu.removeClass('top-menu-open');
    })

});