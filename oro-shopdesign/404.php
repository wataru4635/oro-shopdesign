<?php get_header(); ?>

<main>

<section class="sub-mv">
    <hgroup class="sub-mv__content sub-mv__content--not-found">
      <p class="sub-mv__en-title">not found</p>
      <h1 class="sub-mv__title">
        404
      </h1>
    </hgroup>
  </section>

  <section class="not-found">
    <div class="not-found__inner inner">
      <h2 class="not-found__title">お探しのページは見つかりませんでした。</h2>
      <p class="not-found__text">
      申し訳ありませんが、アクセスしようとしたページは削除されたか、<br class="u-desktop">
      URLが間違っている可能性があります。
      </p>
      <div class="not-found__top-link-wrap">
        <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
          <span class="link-btn-sub__text">トップに戻る</span>
        </a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>