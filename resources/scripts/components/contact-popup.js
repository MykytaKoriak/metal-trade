import $ from "jquery";

$('.contact-page-mail-button').on('click', function (e){
    $('.contact-page-mail-popup').addClass('active')
})

$('.contact-page-mail-popup-close').on('click', function (e){
    $('.contact-page-mail-popup').removeClass('active')
})