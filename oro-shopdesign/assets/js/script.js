"use strict";

/* ===============================================
# メニュー操作とアニメーション処理
=============================================== */
document.addEventListener("DOMContentLoaded", () => {
  // スクロールバーの幅を計算してCSS変数に設定
  function setScrollbarWidth() {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
  }

  // 初期設定
  setScrollbarWidth();

  // リサイズ時に再計算
  window.addEventListener('resize', setScrollbarWidth);

  // 定数：クラス名
  const BODY_CLASS = "body-hidden";
  const OPEN_CLASS = "is-open";

  // 要素取得
  const hamburger = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".js-drawer");
  const mediaQuery = window.matchMedia("(min-width: 768px)");

  // 要素が存在しない場合は処理をスキップ
  if (!hamburger || !drawer) {
    console.warn("ハンバーガーメニューまたはドロワーメニューの要素が見つかりません");
  } else {
    // ドロワーメニューを閉じる
    function closeDrawer() {
      if (!document.body.classList.contains(BODY_CLASS)) return;
      document.body.classList.remove(BODY_CLASS);
      drawer.classList.remove(OPEN_CLASS);
      hamburger.classList.remove(OPEN_CLASS);
    }

    // ハンバーガークリックでメニューをトグル
    function toggleDrawer(event) {
      event.preventDefault();
      document.body.classList.toggle(BODY_CLASS);
      drawer.classList.toggle(OPEN_CLASS);
      hamburger.classList.toggle(OPEN_CLASS);
    }

    // ハンバーガーメニュークリックイベント登録
    hamburger.addEventListener("click", toggleDrawer);

    // メニュー内リンククリックでメニューを閉じる
    drawer.addEventListener("click", event => {
      if (event.target.matches("a[href]")) {
        closeDrawer();
      }
    });

    // リサイズ時：メニュー閉じる処理
    let resizeTimeout;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        closeDrawer();
      }, 150);
    });

    // ブレークポイント変更時にメニュー閉じる
    mediaQuery.addEventListener("change", () => {
      closeDrawer();
    });
  }

  /* ===============================================
  # トップへ移動
  =============================================== */

  var toTopButton = document.querySelector('.to-top');
  window.addEventListener('scroll', function () {
    var scrollPosition = window.scrollY || document.documentElement.scrollTop;
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

          // js-card-animationクラスの場合、アニメーション完了後にホバー用のクラスを追加
          if (entry.target.classList.contains('js-card-animation')) {
            setTimeout(() => {
              entry.target.classList.add('is-hover-ready');
            }, 800); // --duration-semi-longの時間に合わせて調整
          }

          if (!keepActive) {
            observer.unobserve(entry.target);
          }
        } else {
          if (!keepActive) {
            entry.target.classList.remove(activeClass);
            // js-card-animationクラスの場合、ホバー用のクラスも削除
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
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -5% 0px")
  });
  observeElements(".js-card-animation", "is-active", {
    rootMargin: getRootMargin("0px 0px -30% 0px", "0px 0px -20% 0px")
  });
  observeElements(".js-link-btn", "is-active", {
    rootMargin: getRootMargin("0px 0px -10% 0px", "0px 0px -10% 0px")
  });
});