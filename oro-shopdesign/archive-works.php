<?php get_header(); ?>

<main>

  <section class="sub-mv">
    <hgroup class="sub-mv__content sub-mv__content--works">
      <p class="sub-mv__en-title">works</p>
      <h1 class="sub-mv__title">
        <img src="<?php echo IMAGEPATH; ?>/common/works-title.webp" alt="施工事例" width="98" height="24" class="sub-mv__title-img">
      </h1>
    </hgroup>
  </section>

  <section class="works">
    <div class="works__inner">
      <?php if (have_posts()) : ?>
        <ul class="works__list works-list">
          <?php while (have_posts()) : the_post();
            $image_url = '';
            $alt_text = '';
            
            if (has_post_thumbnail()) {
              $thumbnail_id = get_post_thumbnail_id();
              $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
              $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            } else {
              $content = get_the_content();
              preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches);
              if (!empty($matches[1])) {
                $image_url = $matches[1];
                $attachment_id = attachment_url_to_postid($image_url);
                if ($attachment_id) {
                  $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                }
              }
            }
            
            if (empty($alt_text)) {
              $alt_text = get_the_title() . '画像';
            }
            
            $lead = get_field('works_lead');
            $title = get_the_title();
            $title_display = mb_strlen($title) > WORKS_TITLE_MAX_LENGTH ? mb_substr($title, 0, WORKS_TITLE_MAX_LENGTH) . '...' : $title;
          ?>
            <li class="works-list__item works-item js-card-animation">
              <a href="<?php the_permalink(); ?>" class="works-item__link">
                <?php if ($image_url) : ?>
                  <div class="works-item__img-wrap">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" width="360" height="286" loading="lazy" class="works-item__img">
                  </div>
                <?php endif; ?>
                <div class="works-item__content">
                  <?php if ($lead) : ?>
                    <div class="works-item__lead-wrap">
                      <p class="works-item__lead"><?php echo esc_html($lead); ?></p>
                      <span class="works-item__arrow"></span>
                    </div>
                  <?php endif; ?>
                  <p class="works-item__title"><?php echo esc_html($title_display); ?></p>
                </div>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else : ?>
        <p class="no-posts">施工事例はありません。</p>
      <?php endif; ?>
      <div class="works__pagination">
      <?php get_template_part('parts/pagination'); ?>
      </div>
      <div class="works__btn-wrap">
        <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
          <span class="link-btn-sub__text">トップに戻る</span>
        </a>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>