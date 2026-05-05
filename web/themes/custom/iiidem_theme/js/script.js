(function (Drupal, once) {

  Drupal.behaviors.iiidemTheme = {
    attach: function (context) {

      /* ===============================
         Font Size (Persisted)
      =============================== */
      once('fontSizeInit', context.querySelectorAll('html')).forEach(function () {
        let savedSize = localStorage.getItem('fontSize');
        if (savedSize) {
          document.documentElement.style.fontSize = savedSize + 'px';
        }
      });

      window.changeFontSize = function (action) {
        let currentSize = parseInt(localStorage.getItem('fontSize')) || 16;

        if (action === 'increase') currentSize += 2;
        else if (action === 'decrease') currentSize -= 2;
        else currentSize = 16;

        document.documentElement.style.fontSize = currentSize + 'px';
        localStorage.setItem('fontSize', currentSize);
      };


      /* ===============================
         Mobile Menu (No jQuery)
      =============================== */
      once('menuToggle', context.querySelectorAll('#mainMenu')).forEach(function (menu) {
        window.toggleMenu = function () {
          menu.classList.toggle('active');
        };
      });


      /* ===============================
         Tabs
      =============================== */
      window.openTab = function (evt, tabId) {

        let contents = document.querySelectorAll('.tab-content');
        let links = document.querySelectorAll('.tab-link');

        contents.forEach(el => el.classList.remove('active'));
        links.forEach(el => el.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
      };


      /* ===============================
         Auto Open Tab from URL
      =============================== */
      once('tabAutoOpen', context.querySelectorAll('body')).forEach(function () {

        let hash = window.location.hash.replace('#', '');

        if (hash) {
          let btn = document.querySelector('[onclick*="' + hash + '"]');
          if (btn) {
            btn.click();
            return;
          }
        }

        let firstTab = document.querySelector('.tab-link');
        if (firstTab) firstTab.click();

      });


      /* ===============================
         Chart Animation
      =============================== */
      once('chartAnimation', context.querySelectorAll('.chart-fill')).forEach(function () {

        document.querySelectorAll(".chart-fill").forEach(function (bar) {
          let width = bar.getAttribute("data-width");
          bar.style.width = width + "%";
        });

        document.querySelectorAll(".chart-value").forEach(function (el) {
          let target = parseInt(el.getAttribute("data-value"));
          let count = 0;
          let speed = target / 40;

          function updateCounter() {
            count += speed;
            if (count < target) {
              el.innerText = Math.floor(count);
              requestAnimationFrame(updateCounter);
            } else {
              el.innerText = target;
            }
          }
          updateCounter();
        });

      });


      /* ===============================
         Swiper Init (Safe)
      =============================== */
      once('swiperInit', context.querySelectorAll('.clientSwiper')).forEach(function (el) {

        new Swiper(el, {
          slidesPerView: 5,
          spaceBetween: 30,
          loop: true,
          autoplay: { delay: 2000 },
          breakpoints: {
            320: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 5 }
          }
        });

      });


      /* ===============================
         Gallery Load More
      =============================== */

      once('galleryLoadMore', context.querySelectorAll('#load-more, #load-more-video')).forEach(function (button) {
        let itemsToShow = 3;
        let pageLoader = document.getElementById('page-loader');
        button.addEventListener('click', function () {
          pageLoader.classList.remove('d-none');
          button.disabled = true;
          setTimeout(function () {
            // Find ONLY items inside same section
            let section = button.closest('section');
            let hiddenItems = section.querySelectorAll('.gallery-item.hidden');
            hiddenItems.forEach(function (el, index) {
              if (index < itemsToShow) {
                el.classList.remove('hidden');
              }
            });
            pageLoader.classList.add('d-none');
            button.disabled = false;
            if (section.querySelectorAll('.gallery-item.hidden').length === 0) {
              button.style.display = 'none';
            }
          }, 500);
        });
      });

     /* once('galleryLoadMore', context.querySelectorAll('#load-more')).forEach(function (button) {
        let itemsToShow = 3;
        let btnText = button.querySelector('.btn-text');
        let loader = button.querySelector('.loader');
        let pageLoader = document.getElementById('page-loader');
        button.addEventListener('click', function () {
          // Show full page loader
          pageLoader.classList.remove('d-none');
          button.disabled = true;
          setTimeout(function () {
            let hiddenItems = context.querySelectorAll('.gallery-item.hidden');
            hiddenItems.forEach(function (el, index) {
              if (index < itemsToShow) {
                el.classList.remove('hidden');
              }
            });
            // Hide loader
            pageLoader.classList.add('d-none');
            button.disabled = false;
            if (context.querySelectorAll('.gallery-item.hidden').length === 0) {
              button.style.display = 'none';
            }
          }, 500);
        });
      });*/

    } // end attach
  }; // end Drupal.behaviors
})(Drupal, once);