var BMN = (function() {
  "use strict";

  var Constructor = function() {
    //****************
    // Variables
    //****************
    var publicAPIs = {};
    var settings;

    // the defaults
    var defaults = {
      toggler: ".navbar-toggler",
      slideFrom: "left",
      offCanvas: false,
      dropdown: {
        icon: "chevron" // add a chevron and a plus sign option
      },
      footer: {
        show: false,
        content: null
      }
    };

    //***************
    // Methods
    //***************
    publicAPIs.init = function(options) {
      // merge user options into defaults
      settings = Object.assign({}, defaults, options);

      var toggler = document.querySelector(settings.toggler);
      var bmnWrapper, bmnTop, bmnMiddle, bmnBottom;

      // build the ui
      function buildUI() {
        bmnWrapper = document.createElement("div");
        bmnTop = document.createElement("div");
        bmnMiddle = document.createElement("div");
        bmnWrapper.setAttribute("class", "bmn__wrapper");
        bmnTop.setAttribute("class", "bmn__top");
        bmnMiddle.setAttribute("class", "bmn__middle");
        let body = document.querySelector("body");
        body.append(bmnWrapper);
        if (settings.slideFrom === "left") {
          bmnWrapper.classList.add("bmn__wrapper--left");
        } else {
          bmnWrapper.classList.add("bmn__wrapper--right");
        }
        if (settings.footer.show && settings.footer.content.length > 0) {
          bmnBottom = document.createElement("div");
          bmnBottom.setAttribute("class", "bmn__bottom");
          bmnBottom.innerHTML = settings.footer.content;
          bmnWrapper.append(bmnTop, bmnMiddle, bmnBottom);
        } else {
          bmnWrapper.append(bmnTop, bmnMiddle);
        }
      }
      buildUI();

      // get the nav
      function getNav() {
        let nav = document.querySelector(".navbar-nav").cloneNode(true);
        bmnMiddle.innerHTML = nav.outerHTML;
      }

      getNav();

      // get the brand name and place it in the bmn__top
      function getBrand() {
        let brandName = document.querySelector(".navbar-brand").innerText;
        let brandLink = document.querySelector(".navbar-brand").href;
        let bmnBrand = `
      <div class="bmn__brand">
        <a href="${brandLink}">${brandName}</a>
      </div>
      `;

        bmnTop.innerHTML = bmnBrand;
      }

      getBrand();

      // replace class names to avoid conflict with Bootstrap's classes
      function replaceClassNames() {
        let navbar = document.querySelector(".bmn__wrapper .navbar-nav");
        let navItems = document.querySelectorAll(".bmn__wrapper .nav-item");
        let navLinks = document.querySelectorAll(".bmn__wrapper .nav-link");
        let dropdowns = document.querySelectorAll(".bmn__wrapper .dropdown");
        let dropdownMenus = document.querySelectorAll(
          ".bmn__wrapper .dropdown-menu"
        );
        let dropdownTogglers = document.querySelectorAll(
          ".bmn__wrapper .dropdown-toggle"
        );
        navItems.forEach(item => {
          item.classList.remove("nav-item");
          item.classList.add("bmn-item");
          navbar.classList = "bmn__nav";
        });
        navLinks.forEach(link => {
          link.classList.remove("nav-link");
          link.classList.add("bmn-link");
        });
        dropdowns.forEach(link => {
          link.classList.remove("dropdown");
          link.classList.add("bmn__dropdown");
        });
        dropdownTogglers.forEach(toggle => {
          toggle.removeAttribute("id");
          toggle.removeAttribute("data-toggle");
          toggle.removeAttribute("aria-haspopup");
          toggle.removeAttribute("aria-expanded");
        });
        dropdownMenus.forEach(toggle => {
          toggle.removeAttribute("aria-labelledby");
        });
      }

      replaceClassNames();

      toggler.addEventListener("click", toggleBMN);

      // toggle BMN depending on if offcanvas or not
      function toggleBMN() {
        var wrapper = document.getElementById("wrapper");
        var bmnWrapperLeft = document.querySelector(".bmn__wrapper--left");
        var bmnWrapperRight = document.querySelector(".bmn__wrapper--right");
        wrapper.classList.toggle("pushed");
        if (settings.slideFrom === "left" && settings.offCanvas) {
          wrapper.classList.toggle("pushed--left");
          bmnWrapperLeft.classList.toggle("show");
        } else if (settings.slideFrom === "right" && settings.offCanvas) {
          wrapper.classList.toggle("pushed--right");
          bmnWrapperRight.classList.toggle("show");
        } else if (settings.slideFrom === "left" && !settings.offCanvas) {
          bmnWrapperLeft.classList.toggle("show");
        } else if (settings.slideFrom === "right" && !settings.offCanvas) {
          bmnWrapperRight.classList.toggle("show");
        }
      }

      // dropdowns
      function bmnDropdowns() {
        let dropdownTogglers = bmnWrapper.querySelectorAll(".dropdown-toggle");
        for (let i = 0; i < dropdownTogglers.length; i++) {
          dropdownTogglers[i].addEventListener("click", showDropdown);
          if (settings.dropdown.icon === "chevron") {
            dropdownTogglers[i].innerHTML +=
              '<span class="bmn__chevron"></span>';
            dropdownTogglers[i].addEventListener("click", function() {
              dropdownTogglers[i]
                .querySelector("span")
                .classList.toggle("bmn__chevron--rotated");
            });
          } else if (settings.dropdown.icon === "plus") {
            dropdownTogglers[i].innerHTML += '<span class="bmn__plus"></span>';
            dropdownTogglers[i].addEventListener("click", function() {
              dropdownTogglers[i]
                .querySelector("span")
                .classList.toggle("bmn__plus--minus");
            });
          } else {
            dropdownTogglers[i].innerHTML += settings.icon;
          }
        }
        function showDropdown(e) {
          let parent = e.target.parentNode;
          parent.classList.toggle("show");
        }
      }
      bmnDropdowns();
    };
    return publicAPIs;
  };
  return Constructor;
})();
