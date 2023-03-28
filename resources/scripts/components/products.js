import $ from "jquery";
import "../slick/slick.js"


$('.products-container').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    centerMode: true,
    autoplay: false,
    focusOnSelect: true,
    autoplaySpeed: 2000,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: false,
                centerMode: false,
                arrows: true,
            }
        },
        {
            breakpoint: 500,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                centerMode: false,
                arrows: true,
            }
        }
    ]
});
