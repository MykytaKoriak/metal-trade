import $ from "jquery";

if ($('#banner').length) {
    $(window).scroll(function () {
        var fixedHeader = $('.fixed-header'),
            tagline_el = $('#banner'),
            hT = tagline_el.offset().top,
            elementHeight = tagline_el.height(),
            hB = hT + elementHeight,
            needPosition = hB - 120,
            wS = $(this).scrollTop();
        if (wS > needPosition) {
            if (fixedHeader.hasClass("fixed-header__hidden")) {
                fixedHeader.removeClass("fixed-header__hidden")
            }
        } else {
            if (!fixedHeader.hasClass("fixed-header__hidden")) {
                fixedHeader.addClass("fixed-header__hidden")
            }
        }
    });
}