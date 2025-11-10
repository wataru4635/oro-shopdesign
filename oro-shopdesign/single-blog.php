<?php get_header(); ?>

<main>

  <section class="sub-mv">
    <hgroup class="sub-mv__content sub-mv__content--blog">
      <p class="sub-mv__en-title">blog</p>
      <h1 class="sub-mv__title">
        <img src="<?php echo IMAGEPATH; ?>/common/blog-title.webp" alt="読みもの" width="98" height="24" class="sub-mv__title-img">
      </h1>
    </hgroup>
  </section>

  <section class="single-blog">
    <div class="single-blog__top">
      <div class="single-blog__top-inner">
        <?php if (has_post_thumbnail()) : ?>
        <?php
          $thumbnail_id = get_post_thumbnail_id();
          $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
          if (empty($alt_text)) {
            $alt_text = get_the_title() . '画像';
          }
          ?>
        <div class="single-blog__mv">
          <?php the_post_thumbnail('large', array(
              'class' => 'single-blog__mv-img',
              'alt' => esc_attr($alt_text)
            )); ?>
        </div>
        <?php endif; ?>
        <div class="single-blog__main">
          <h1 class="single-blog__title"><?php the_title(); ?></h1>
          <?php
          $blog_lead = get_field('blog_lead');
          ?>
          <?php if ($blog_lead) : ?>
          <div class="single-blog__lead"><?php echo wpautop(wp_kses_post($blog_lead)); ?></div>
          <?php endif; ?>
          <div class="single-blog__content">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="single-blog__bottom">
      <div class="single-blog__bottom-inner">
        <?php if (get_previous_post() || get_next_post()) : ?>
          <div class="single-blog__post-navigation post-navigation">
            <?php get_template_part('parts/post-navigation'); ?>
          </div>
        <?php endif; ?>
        <div class="single-blog__btn-links">
          <a href="<?php echo HOME_URL; ?>/blog/" class="link-btn-sub link-btn-sub--green">
            <span class="link-btn-sub__text">ブログトップ</span>
          </a>
          <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
            <span class="link-btn-sub__text">トップに戻る</span>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>