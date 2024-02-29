document.addEventListener(
  "DOMContentLoaded",
  function () {
    "use strict";
    let savedScrollY = 0;
    // Function to save the current scroll position
    function saveScrollPosition() {
      savedScrollY = window.scrollY;
    }

    // Function to restore the saved scroll position
    function restoreScrollPosition() {
      window.scrollTo(0, savedScrollY);
    }
    let header = document.querySelector(".header");
    var link = document.querySelector("[data-toggle-menu]");
    var dropDown = document.querySelector(".dropDown");
    link.addEventListener(
      "click",
      function () {
        if (link.classList.contains("toggle-menu--clicked")) {
          link.classList.remove("toggle-menu--clicked");
          dropDown.style.top = "-1000px";
          header.classList.remove("stick");
          restoreScrollPosition();
        } else {
          link.classList.add("toggle-menu--clicked");
          dropDown.style.top = "0";
          header.classList.add("stick");
          saveScrollPosition();
        }
      },
      false
    );
  },
  false
);
