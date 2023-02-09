import $ from "jquery";

if ($('.about-image').length) {
    var parallax = $(".about-image"),
        speed = 0.5;

    $(window).scroll(function(){
        parallax.each(function(el,i){

            var windowYOffset = $(window).scrollTop();
            $(this).css("backgroundPosition", "50% " + (windowYOffset * speed) + "px");

        });
    });
}