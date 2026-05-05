(function (Drupal) {

  Drupal.behaviors.slider = {
    attach: function (context) {

      const sliders = document.querySelectorAll('.slider');

      sliders.forEach(slider => {

        let index = 0;

        const slides = slider.querySelector('.slides');
        const next = slider.querySelector('.next');
        const prev = slider.querySelector('.prev');

        next.onclick = () => {
          index++;
          slides.style.transform =
            "translateX(-" + (400 * index) + "px)";
        };

        prev.onclick = () => {
          index--;
          slides.style.transform =
            "translateX(-" + (400 * index) + "px)";
        };

      });

    }
  };

})(Drupal);