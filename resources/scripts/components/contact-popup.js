import $ from "jquery";

$('.contact-page-mail-button').on('click', function (e) {
    $('.contact-page-mail-popup').addClass('active');

    if ($('.contact-page-mail-popup').hasClass('active')) {

        $(document).on('click', function (e) {
            if ($(e.target).hasClass('contact-page-mail-popup')) {
                $('.contact-page-mail-popup').removeClass('active')
            }
        })
    }
});

$('.contact-page-mail-popup-close').on('click', function (e) {
    $('.contact-page-mail-popup').removeClass('active')
});
