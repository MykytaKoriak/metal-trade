import $ from "jquery";
import "../slick/slick.js"


$('.products-container').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    centerMode: true,
    autoplay: true,
    focusOnSelect: true,
    autoplaySpeed: 2000
});
