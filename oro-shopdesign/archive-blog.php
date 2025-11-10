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

  <section class="blog">
    <div class="blog__inner">
      <?php if (have_posts()) : ?>
        <ul class="blog__list">
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
            
            $title = get_the_title();
          ?>
            <li class="blog__item">
              <a href="<?php the_permalink(); ?>" class="blog__card js-card-animation">
                <div class="blog__img-wrap">
                  <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" width="900" height="900" loading="lazy" class="blog__img">
                  <?php else : ?>
                    <span class="blog__img"></span>
                  <?php endif; ?>
                </div>
                <div class="blog__content">
                  <p class="blog__title"><?php echo esc_html($title); ?></p>
                  <time class="blog__time" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
                </div>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else : ?>
        <p class="no-posts">投稿はありません。</p>
      <?php endif; ?>
      <div class="blog__pagination">
        <?php get_template_part('parts/pagination'); ?>
      </div>
      <div class="blog__btn-wrap">
        <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
          <span class="link-btn-sub__text">トップに戻る</span>
        </a>
      </div>
    </div>
  </section>


</main>

<?php get_footer(); ?>