"use strict";

/* ===============================================
# メニュー操作とアニメーション処理
=============================================== */
document.addEventListener("DOMContentLoaded", () => {
  function setScrollbarWidth() {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
  }
  setScrollbarWidth();
  window.addEventListener('resize', setScrollbarWidth);
  const BODY_CLASS = "body-hidden";
  const OPEN_CLASS = "is-open";
  const hamburger = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".js-drawer");
  const mediaQuery = window.matchMedia("(min-width: 768px)");
  if (!hamburger || !drawer) {
    console.warn("ハンバーガーメニューまたはドロワーメニューの要素が見つかりません");
  } else {
    function closeDrawer() {
      if (!document.body.classList.contains(BODY_CLASS)) return;
      document.body.classList.remove(BODY_CLASS);
      drawer.classList.remove(OPEN_CLASS);
      hamburger.classList.remove(OPEN_CLASS);
    }
    function toggleDrawer(event) {
      event.preventDefault();
      document.body.classList.toggle(BODY_CLASS);
      drawer.classList.toggle(OPEN_CLASS);
      hamburger.classList.toggle(OPEN_CLASS);
    }
    hamburger.addEventListener("click", toggleDrawer);
    drawer.addEventListener("click", event => {
      if (event.target.matches("a[href]")) {
        closeDrawer();
      }
    });
    let resizeTimeout;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        closeDrawer();
      }, 150);
    });
    mediaQuery.addEventListener("change", () => {
      closeDrawer();
    });
  }

  /* ===============================================
  # トップへ移動
  =============================================== */

  const toTopButton = document.querySelector('.to-top');
  window.addEventListener('scroll', function () {
    const scrollPosition = window.scrollY || document.documentElement.scrollTop;
    if (scrollPosition > 300) {
      toTopButton.classList.add("js-active");
    } else {
      toTopButton.classList.remove("js-active");
    }
  });
  toTopButton.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  /* ===============================================
  # アニメーション
  =============================================== */
  function observeElements(selector) {
    let activeClass = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "is-active";
    let options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    let keepActive = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
    const elements = document.querySelectorAll(selector);
    function handleIntersect(entries, observer) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add(activeClass);
          if (entry.target.classList.contains('js-card-animation')) {
            setTimeout(() => {
              entry.target.classList.add('is-hover-ready');
            }, 800);
          }
          if (!keepActive) {
            observer.unobserve(entry.target);
          }
        } else {
          if (!keepActive) {
            entry.target.classList.remove(activeClass);
            if (entry.target.classList.contains('js-card-animation')) {
              entry.target.classList.remove('is-hover-ready');
            }
          }
        }
      });
    }
    const observer = new IntersectionObserver(handleIntersect, options);
    elements.forEach(element => observer.observe(element));
  }
  function getRootMargin(pcMargin, spMargin) {
    return window.matchMedia("(min-width: 768px)").matches ? pcMargin : spMargin;
  }
  observeElements(".js-fade-in", "is-active", {
    rootMargin: getRootMargin("0px 0px -20% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-fade-up", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-scaleImg", "is-active", {
    rootMargin: getRootMargin("0px 0px -30% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-card-animation", "is-active", {
    rootMargin: getRootMargin("0px 0px -30% 0px", "0px 0px -20% 0px")
  });
  observeElements(".js-link-btn", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
  observeElements(".js-flow-animation", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
});