<button class="to-top" aria-label="トップに戻るボタン">
  <img src="<?php echo IMAGEPATH; ?>/common/to-top.svg" class="to-top__img" alt="トップに戻るボタン" width="44" height="44">
</button>

<footer class="footer">
  <div class="footer__inner">
    <a href="<?php echo HOME_URL; ?>" class="footer__logo">
      <img src="<?php echo IMAGEPATH; ?>/common/logo-white.webp" alt="oro Shop Design" width="264" height="46" loading="lazy" class="footer__logo-img">
    </a>

    <div class="footer__sns">
      <a href="https://www.instagram.com/oro_sekkei/" target="_blank" rel="noopener noreferrer" class="footer__sns-link">
        <span class="footer__sns-label">Instagram</span>
      </a>
    </div>

    <ul class="footer__nav">
      <li class="footer__nav-item"><a href="<?php echo FLOW_URL; ?>" class="footer__nav-link">ご依頼の流れ</a></li>
      <li class="footer__nav-item"><a href="<?php echo WORKS_URL; ?>" class="footer__nav-link">施工事例</a></li>
      <li class="footer__nav-item"><a href="<?php echo ABOUT_URL; ?>" class="footer__nav-link">会社紹介</a></li>
      <li class="footer__nav-item"><a href="<?php echo BLOG_URL; ?>" class="footer__nav-link">読みもの</a></li>
      <li class="footer__nav-item"><a href="<?php echo CONTACT_URL; ?>" class="footer__nav-link">お問い合わせ</a></li>
    </ul>

    <address class="footer__address">
      〒432-8023 <br class="u-mobile">静岡県浜松市中央区鴨江1丁目7-19<br>
      TEL <a href="tel:053-570-8742">053-570-8742</a><br>
      OPEN 9:30〜18:30
    </address>

    <small class="footer__copyright">&copy;orosekkei all rights reserved.</small>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>