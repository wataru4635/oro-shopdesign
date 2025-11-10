<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php if(is_page('contact')): ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <?php else: ?>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <?php endif; ?>
  <meta name="format-detection" content="telephone=no" />
  <!-- meta情報 -->
  <title>
    <?php
    if (is_front_page()) {
        echo esc_html('【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_home()) {
        $blog_page_title = get_the_title(get_option('page_for_posts'));
        echo esc_html($blog_page_title . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_singular('post') || is_singular('blog') || is_singular('works')) {
        echo esc_html(get_the_title() . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_page()) {
        echo esc_html(get_the_title() . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_post_type_archive('works')) {
        echo esc_html('施工事例｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_post_type_archive('blog')) {
        echo esc_html('読みもの｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_category()) {
        echo esc_html(single_cat_title('', false) . '一覧｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_archive()) {
        echo esc_html(single_cat_title('', false) . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_search()) {
        echo esc_html('検索結果: ' . get_search_query() . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_404()) {
        echo esc_html('ページが見つかりません｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } else {
        echo esc_html('【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    }
    ?>
  </title>

  <meta name="description" content="<?php
    $base_description = '浜松市・磐田市・豊橋市で店舗設計・オフィスデザインの実績多数。飲食店・エステサロン・パーソナルジムなど、プランから内装デザイン、施工までトータルでサポートいたします。';
    if (is_front_page()) {
        echo esc_attr($base_description);
    } elseif (is_home()) {
        echo esc_attr(get_the_title(get_option('page_for_posts')) . ' - ' . $base_description);
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . ' - ' . $base_description);
    } elseif (is_post_type_archive('works')) {
        echo esc_attr('施工事例 - ' . $base_description);
    } elseif (is_post_type_archive('blog')) {
        echo esc_attr('読みもの - ' . $base_description);
    } elseif (is_singular('post') || is_singular('blog') || is_singular('works')) {
        $excerpt = get_the_excerpt();
        echo esc_attr(get_the_title() . ' - ' . ($excerpt ? $excerpt : $base_description));
    } elseif (is_category()) {
        echo esc_attr(single_cat_title('', false) . '一覧 - ' . $base_description);
    } elseif (is_archive()) {
        echo esc_attr(single_cat_title('', false) . 'の記事一覧 - ' . $base_description);
    } elseif (is_search()) {
        echo esc_attr('検索結果: ' . get_search_query() . ' - ' . $base_description);
    } elseif (is_404()) {
        echo esc_attr('ページが見つかりません - ' . $base_description);
    } else {
        echo esc_attr($base_description);
    }
?>">
  <meta name="keywords" content="浜松市,磐田市,豊橋市,店舗デザイン,ショップデザイン,オフィスデザイン,内装デザイン,設計" />
  <!-- canonical -->
  <link rel="canonical" href="<?php
    if (is_front_page()) {
        echo esc_url(home_url('/'));
    } elseif (is_singular()) {
        echo esc_url(get_permalink());
    } elseif (is_category() || is_tag() || is_tax()) {
        echo esc_url(get_term_link(get_queried_object()));
    } elseif (is_post_type_archive()) {
        echo esc_url(get_post_type_archive_link(get_post_type()));
    } elseif (is_search()) {
        echo esc_url(home_url('/') . '?s=' . get_search_query());
    } else {
        echo esc_url(home_url('/'));
    }
  ?>" />
  <!-- ogp -->
  <meta property="og:title" content="<?php
    if (is_front_page()) {
        echo esc_attr('【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_singular('post') || is_singular('blog') || is_singular('works')) {
        echo esc_attr(get_the_title() . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . '｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_post_type_archive('works')) {
        echo esc_attr('施工事例｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } elseif (is_post_type_archive('blog')) {
        echo esc_attr('読みもの｜【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    } else {
        echo esc_attr('【公式】店舗デザインならoroショップデザイン｜静岡県浜松市');
    }
  ?>" />
  <meta property="og:type" content="<?php echo esc_attr((is_singular('post') || is_singular('blog') || is_singular('works')) ? 'article' : 'website'); ?>">
  <meta property="og:url" content="<?php
    if (is_front_page()) {
        echo esc_url(home_url('/'));
    } elseif (is_singular()) {
        echo esc_url(get_permalink());
    } elseif (is_category() || is_tag() || is_tax()) {
        echo esc_url(get_term_link(get_queried_object()));
    } elseif (is_post_type_archive()) {
        echo esc_url(get_post_type_archive_link(get_post_type()));
    } else {
        echo esc_url(home_url('/'));
    }
  ?>" />
  <meta property="og:image" content="<?php echo esc_url(home_url('/wp-content/themes/oro-shopdesign/assets/images/og_img.jpg')); ?>" />
  <meta property="og:site_name" content="【公式】店舗デザインならoroショップデザイン｜静岡県浜松市" />
  <meta property="og:description" content="<?php
    $base_description = '浜松市・磐田市・豊橋市で店舗設計・オフィスデザインの実績多数。飲食店・エステサロン・パーソナルジムなど、プランから内装デザイン、施工までトータルでサポートいたします。';
    if (is_front_page()) {
        echo esc_attr($base_description);
    } elseif (is_singular('post') || is_singular('blog') || is_singular('works')) {
        $excerpt = get_the_excerpt();
        echo esc_attr($excerpt ? $excerpt : $base_description);
    } elseif (is_page()) {
        echo esc_attr(get_the_title() . ' - ' . $base_description);
    } elseif (is_post_type_archive('works')) {
        echo esc_attr('施工事例 - ' . $base_description);
    } elseif (is_post_type_archive('blog')) {
        echo esc_attr('読みもの - ' . $base_description);
    } else {
        echo esc_attr($base_description);
    }
  ?>" />
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/body-bg-sp.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/body-bg.webp" media="(min-width: 768px)">
  <?php if (is_front_page() || is_post_type_archive('works')): ?>
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/works-bg_white.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/works-bg_blue.webp">
  <?php endif; ?>
  <?php if (is_front_page()): ?>
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/card-bg_green.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/card-bg_red.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/card-bg_orange.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/link-btn-bg_yellow.webp">
  <?php endif; ?>
  <?php if (is_home()): ?>
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/works-bg_white.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/common/card-bg_green.webp">
  <?php endif; ?>
  <?php if (is_singular('works')): ?>
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/works/single-works-bg-sp.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/works/single-works-bg.webp" media="(min-width: 768px)">
  <?php endif; ?>
  <?php if (is_singular('blog')): ?>
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/blog/single-blog-bg-sp.webp">
  <link rel="preload" as="image" href="<?php echo IMAGEPATH; ?>/blog/single-blog-bg.webp" media="(min-width: 768px)">
  <?php endif; ?>
  <?php wp_head(); ?>
</head>

<body class="bg-body <?php body_class(); ?>">

  <!---------  header  --------->

  <header class="header">
    <div class="header__inner">
    <a href="<?php echo HOME_URL; ?>" class="header__logo-link">
        <?php
          $logo_tag = (is_front_page() || is_home()) ? 'h1' : 'div';
        ?>
        <<?php echo esc_html($logo_tag); ?> class="header__logo">
          <img src="<?php echo IMAGEPATH; ?>/common/logo.webp" alt="oro shopdesignロゴ画像" width="103.477" height="30" class="header__logo-img">
        </<?php echo esc_html($logo_tag); ?>>
      </a>
    </div>
  </header>

  <div class="hamburger">
    <button class="hamburger__button js-hamburger" type="button" aria-label="メニューを開く">
          <span></span>
          <span></span>
          <span></span>
    </button>
  </div>

  <div class="drawer js-drawer">
    <div class="drawer__inner">
      <nav class="drawer__nav">
        <ul class="drawer__list">
          <li class="drawer__item">
            <a href="<?php echo FLOW_URL; ?>" class="drawer__link">
              <span class="drawer__link-text">ご依頼の流れ</span>
            </a>
          </li>
          <li class="drawer__item">
            <a href="<?php echo WORKS_URL; ?>" class="drawer__link">
              <span class="drawer__link-text">施工事例</span>
            </a>
          </li>
          <li class="drawer__item">
            <a href="<?php echo ABOUT_URL; ?>" class="drawer__link">
              <span class="drawer__link-text">会社紹介</span>
            </a>
          </li>
          <li class="drawer__item">
            <a href="<?php echo BLOG_URL; ?>" class="drawer__link">
              <span class="drawer__link-text">読みもの</span>
            </a>
          </li>
          <li class="drawer__item">
            <a href="<?php echo CONTACT_URL; ?>" class="drawer__link">
              <span class="drawer__link-text">お問い合わせ</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="drawer__instagram">
            <a href="https://www.instagram.com/oro_sekkei/" class="drawer__instagram-link" target="_blank" rel="noopener noreferrer">
              <span class="drawer__instagram-text">Instagram</span>
            </a>
      </div>
      <div class="drawer__logo">
        <a href="https://oro-sekkei.com/" class="drawer__logo-link" target="_blank" rel="noopener noreferrer"><img src="<?php echo IMAGEPATH; ?>/common/oro-logo.webp" alt="oro株式会社のロゴ" width="120" height="53" loading="lazy" class="drawer__logo-img"></a>
      </div>
    </div>
  </div>