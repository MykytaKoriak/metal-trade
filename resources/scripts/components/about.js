import $ from "jquery";

if ($('.about-image').length) {
  var parallax = $(".about-image");

  $(window).scroll(function () {
    var heightBlock = parallax.attr('data-height');
    var wS = $(window).scrollTop();
    if (wS > parallax.position().top - parallax.height() / 2 && wS < (parallax.position().top + parallax.height())) {
      console.log(heightBlock);
      parallax.css("backgroundPosition", "50% " + (((parallax.position().top - window.scrollY - 100) * -0.2) - (heightBlock / 2)) + "px");
    }
  });
}
