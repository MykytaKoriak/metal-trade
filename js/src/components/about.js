import $ from "jquery";

if ($('.about-image').length) {
    var parallax = $(".about-image");

    $(window).unbind("scroll").scroll(function () {
        var wS = $(window).scrollTop();
        if (wS > parallax.position().top - parallax.height()/2 && wS < (parallax.position().top + parallax.height())) {
            console.log((window.scrollY - parallax.position().top / 2) * -0.1 + "px");
            console.log((parallax.position().top - window.scrollY) * -0.1 );
            console.log(window.scrollY + " " + parallax.position().top);
            parallax.css("backgroundPosition", "50% " + (parallax.position().top - window.scrollY - 100) * -0.2 + "px");

        }
    });
}