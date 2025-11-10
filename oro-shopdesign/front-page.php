<?php
/*
* Template Name: トップページ
*/
?>
<?php get_header(); ?>

<main>

<section class="mv">
  <div class="mv__inner">
    <nav class="mv__nav">
      <ul class="mv__list">
        <li class="mv__nav-item"><a href="<?php echo FLOW_URL; ?>" class="mv__nav-link">ご依頼の流れ</a></li>
        <li class="mv__nav-item"><a href="<?php echo WORKS_URL; ?>" class="mv__nav-link">施工事例</a></li>
        <li class="mv__nav-item"><a href="<?php echo ABOUT_URL; ?>" class="mv__nav-link">会社紹介</a></li>
        <li class="mv__nav-item"><a href="<?php echo BLOG_URL; ?>" class="mv__nav-link">読みもの</a></li>
        <li class="mv__nav-item"><a href="<?php echo CONTACT_URL; ?>" class="mv__nav-link">お問い合わせ</a></li>
      </ul>
    </nav>
    <h2 class="mv__text">お店のデザインと設計施工</h2>
    <div class="mv__swiper swiper js-mv-swiper">
      <div class="swiper-wrapper">
        <?php
        $cache_key = 'oro_mv_slides';
        $mv_slides = get_transient($cache_key);
        
        if (false === $mv_slides) {
          $mv_query = new WP_Query(array(
            'post_type' => 'works',
            'posts_per_page' => -1,
            'meta_query' => array(
              array(
                'key' => 'show_on_top_mv',
                'value' => '1',
                'compare' => '='
              )
            )
          ));
          
          $mv_slides = array();
          $first_slide = null;
          
          if ($mv_query->have_posts()) {
            while ($mv_query->have_posts()) {
              $mv_query->the_post();
              
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
              
              if ($image_url) {
                if (empty($alt_text)) {
                  $alt_text = get_the_title() . '画像';
                }
                
                $slide_data = array(
                  'url' => $image_url,
                  'alt' => $alt_text
                );
                
                $show_first = get_field('show_first_mv');
                if ($show_first) {
                  $first_slide = $slide_data;
                } else {
                  $mv_slides[] = $slide_data;
                }
              }
            }
            wp_reset_postdata();
          }
          
          if ($first_slide) {
            array_unshift($mv_slides, $first_slide);
          }
          
          $slide_count = count($mv_slides);
          
          if ($slide_count === 0) {
            $mv_slides = array(
              array('url' => IMAGEPATH . '/top/mv01.jpg', 'alt' => 'デザインした店舗画像'),
              array('url' => IMAGEPATH . '/top/mv02.jpg', 'alt' => 'デザインした店舗画像')
            );
          } elseif ($slide_count === 1) {
            if ($first_slide) {
              $mv_slides[] = array('url' => IMAGEPATH . '/top/mv01.jpg', 'alt' => 'デザインした店舗画像');
            } else {
              array_unshift($mv_slides, array('url' => IMAGEPATH . '/top/mv01.jpg', 'alt' => 'デザインした店舗画像'));
            }
          }
          
          set_transient($cache_key, $mv_slides, 12 * HOUR_IN_SECONDS);
        }
        
        foreach ($mv_slides as $index => $slide) :
          $loading = ($index === 0) ? 'eager' : 'lazy';
          $fetchpriority = ($index === 0) ? 'fetchpriority="high"' : '';
        ?>
          <div class="swiper-slide">
            <div class="swiper-img">
              <img src="<?php echo esc_url($slide['url']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" width="1211" height="690" loading="<?php echo $loading; ?>" decoding="async" <?php echo $fetchpriority; ?> class="mv__slide-img">
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<div class="arrow-down js-arrow-down">
  <span class="arrow-down__img"></span>
</div>

<section class="top-works">
  <div class="top-works__inner">
    <h2 class="top-works__title section-title">
      <img src="<?php echo IMAGEPATH; ?>/common/works-title.webp" alt="施工事例" width="118" height="29" loading="lazy" class="section-title__img">
    </h2>
    <?php
    $works_query = new WP_Query(array(
      'post_type' => 'works',
      'posts_per_page' => 4,
      'orderby' => 'date',
      'order' => 'DESC'
    ));
    
    if ($works_query->have_posts()) : ?>
      <ul class="top-works__list works-list">
        <?php while ($works_query->have_posts()) : $works_query->the_post();
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
      <p>施工事例がまだありません。</p>
    <?php endif;
    wp_reset_postdata();
    ?>
    <div class="top-works__btn-wrap js-link-btn">
      <a href="<?php echo WORKS_URL; ?>" class="link-btn link-btn--yellow">
        <span class="link-btn__text">施工事例一覧を見る</span>
      </a>
    </div>
  </div>
</section>

<section class="top-link-section">
  <div class="top-link-section__inner">
    <ul class="top-link-section__list">
      <li class="top-link-section__item top-link-section__item--01">
        <div class="top-link-section__title section-title">
          <img src="<?php echo IMAGEPATH; ?>/common/blog-title.webp" alt="読みものの見出し画像" width="200" height="28" loading="lazy" class="section-title__img">
        </div>
        <a href="<?php echo BLOG_URL; ?>" class="top-link-section__card js-card-animation">
          <div class="top-link-section__img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/top-link-01.webp" alt="モダンなカウンターとスツールが配置された店舗内装" width="291" height="218" loading="lazy" class="top-link-section__img">
          </div>
          <p class="top-link-section__heading">日々の出来事と建築の解説</p>
          <p class="top-link-section__text">店舗デザインの裏側や<br>完成までの道のり</p>
          <span class="top-link-section__arrow"></span>
        </a>
      </li>

      <li class="top-link-section__item top-link-section__item--02">
        <div class="top-link-section__title section-title">
          <img src="<?php echo IMAGEPATH; ?>/common/flow-title.webp" alt="ご依頼の流れの見出し画像" width="200" height="28" loading="lazy" class="section-title__img">
        </div>
        <a href="<?php echo FLOW_URL; ?>" class="top-link-section__card js-card-animation">
          <div class="top-link-section__img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/top-link-02.webp" alt="オープンキッチンとカウンター席のあるカフェ店舗内装" width="291" height="218" loading="lazy" class="top-link-section__img">
          </div>
          <p class="top-link-section__heading">店舗デザインのはじめ方</p>
          <p class="top-link-section__text">はじめての方へ<br>ご依頼の流れをお伝えします</p>
          <span class="top-link-section__arrow"></span>
        </a>
      </li>

      <li class="top-link-section__item top-link-section__item--03">
        <div class="top-link-section__title section-title">
          <img src="<?php echo IMAGEPATH; ?>/common/about-title.webp" alt="会社紹介の見出し画像" width="200" height="28" loading="lazy" class="section-title__img">
        </div>
        <a href="<?php echo ABOUT_URL; ?>" class="top-link-section__card js-card-animation">
          <div class="top-link-section__img-wrap">
            <img src="<?php echo IMAGEPATH; ?>/top/top-link-03.webp" alt="木材を活用した温かみのあるオフィス空間" width="291" height="218" loading="lazy" class="top-link-section__img">
          </div>
          <p class="top-link-section__heading">oroショップデザイン</p>
          <p class="top-link-section__text">運営会社である<br>oro株式会社の会社紹介</p>
          <span class="top-link-section__arrow"></span>
        </a>
      </li>
    </ul>
  </div>
</section>

<section class="contact-section contact-section--top">
  <div class="contact-section__inner">
    <div class="contact-section__row">
      <h2 class="contact-section__title section-title">
        <img src="<?php echo IMAGEPATH; ?>/common/contact-title.webp" alt="お問い合わせ" width="178" height="29" loading="lazy" class="section-title__img">
      </h2>
      <div class="contact-section__link-btn js-link-btn">
        <a href="<?php echo CONTACT_URL; ?>" class="link-btn link-btn--blue">
          <span class="link-btn__text">contact</span>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="company-section">
  <div class="company-section__inner">
    <h2 class="company-section__title section-title">
      <img src="<?php echo IMAGEPATH; ?>/common/company-title.webp" alt="運営会社" width="119" height="29" loading="lazy" class="section-title__img">
    </h2>
    <div class="company-section__content">
      <p class="company-section__name">
        oro株式会社／<br>
        oro株式会社 一級建築士事務所
      </p>
      <p class="company-section__text">
        静岡県浜松市を中心に<br>
        住宅・店舗・公共建築などのデザインを<br>
        手がけている設計事務所です。
      </p>
      <a href="https://oro-sekkei.com/" class="company-section__logo" target="_blank" rel="noopener noreferrer">
        <img src="<?php echo IMAGEPATH; ?>/common/oro-logo.webp" alt="oro株式会社のロゴ" width="176.604" height="78" loading="lazy" class="company-section__logo-img">
      </a>
    </div>
  </div>
</section>

</main>

<?php get_footer(); ?>