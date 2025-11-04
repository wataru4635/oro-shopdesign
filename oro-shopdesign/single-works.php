<?php get_header(); ?>

<main>

  <section class="sub-mv">
    <div class="sub-mv__content sub-mv__content--works">
      <p class="sub-mv__en-title">works</p>
      <p class="sub-mv__title">
        <img src="<?php echo IMAGEPATH; ?>/common/works-title.webp" alt="施工事例" width="98" height="24"
          class="sub-mv__title-img">
      </p>
    </div>
  </section>

  <section class="single-works">
    <div class="single-works__top">
      <div class="single-works__top-inner">
        <?php if (has_post_thumbnail()) : ?>
        <?php
          $thumbnail_id = get_post_thumbnail_id();
          $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
          if (empty($alt_text)) {
            $alt_text = get_the_title() . '画像';
          }
          ?>
        <div class="single-works__mv">
          <?php the_post_thumbnail('large', array(
              'class' => 'single-works__mv-img',
              'alt' => esc_attr($alt_text)
            )); ?>
        </div>
        <?php endif; ?>
        <div class="single-works__main">
          <h1 class="single-works__title"><?php the_title(); ?></h1>
          <?php
          $en_title = get_field('works_en_title');
          $lead = get_field('works_lead');
          $description = get_field('works_description');
          ?>
          <?php if ($en_title) : ?>
          <p class="single-works__en-title"><?php echo esc_html($en_title); ?></p>
          <?php endif; ?>
          <?php if ($lead) : ?>
          <p class="single-works__lead"><?php echo esc_html($lead); ?></p>
          <?php endif; ?>
          <?php if ($description) : ?>
          <div class="single-works__description"><?php echo wpautop(wp_kses_post($description)); ?></div>
          <?php endif; ?>
          <div class="single-works__content">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="single-works__bottom">
      <div class="single-works__bottom-inner">
        <?php if (get_previous_post() || get_next_post()) : ?>
          <div class="single-works__post-navigation post-navigation">
            <?php get_template_part('parts/post-navigation'); ?>
          </div>
        <?php endif; ?>
        <div class="single-works__btn-links">
          <a href="<?php echo WORKS_URL; ?>" class="link-btn-sub link-btn-sub--blue">
            <span class="link-btn-sub__text">施工事例トップ</span>
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