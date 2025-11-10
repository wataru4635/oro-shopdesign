<?php
// ==========================================================================
// カスタム投稿：施工事例（タクソノミーあり）
// ==========================================================================
function create_post_type_works() {
	register_post_type(
		'works',
		array(
			'labels' => array(
				'name' => '施工事例',
				'singular_name' => '施工事例',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'works'),
			'supports' => array('title', 'editor', 'thumbnail'),
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-edit',
			'menu_position' => 7,
			'taxonomies' => array('works_category'),
		)
	);

	register_taxonomy(
		'works_category',
		'works',
		array(
			'label' => 'カテゴリー',
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'works-category'),
			'show_in_rest' => true,
		)
	);
}
add_action('init', 'create_post_type_works');

// ==========================================================================
// カスタム投稿タイプ "works" での表示件数を設定
// ==========================================================================
function custom_posts_per_page( $query ) {
  if ( ! is_admin() && $query->is_main_query() ) {
      if ( $query->is_post_type_archive( 'works' ) || $query->is_tax( 'works_category' ) ) {
          $query->set( 'posts_per_page', 4 );
      }
  }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );

// ==========================================================================
// カスタム投稿：読みもの（タクソノミーあり）
// ==========================================================================
function create_post_type_blog() {
	register_post_type(
		'blog',
		array(
			'labels' => array(
				'name' => '読みもの',
				'singular_name' => '読みもの',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'blog'),
			'supports' => array('title', 'editor', 'thumbnail'),
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-edit',
			'menu_position' => 5,
			'taxonomies' => array('blog_category'),
		)
	);

	register_taxonomy(
		'blog_category',
		'blog',
		array(
			'label' => 'カテゴリー',
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'blog-category'),
			'show_in_rest' => true,
		)
	);
}
add_action('init', 'create_post_type_blog');

// ==========================================================================
// カスタム投稿タイプ "blog" での表示件数を設定
// ==========================================================================
function custom_blog_posts_per_page( $query ) {
  if ( ! is_admin() && $query->is_main_query() ) {
      if ( $query->is_post_type_archive( 'blog' ) || $query->is_tax( 'blog_category' ) ) {
          if ( wp_is_mobile() ) {
              $query->set( 'posts_per_page', 4 );
          } else {
              $query->set( 'posts_per_page', 9 );
          }
      }
  }
}
add_action( 'pre_get_posts', 'custom_blog_posts_per_page' );

// ==========================================================================
// works投稿が更新されたらMVスライドのキャッシュを削除
// ==========================================================================
function clear_mv_slides_cache($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  
  if (get_post_type($post_id) !== 'works') {
    return;
  }
  
  delete_transient('oro_mv_slides');
}
add_action('save_post_works', 'clear_mv_slides_cache');
add_action('delete_post', 'clear_mv_slides_cache');

