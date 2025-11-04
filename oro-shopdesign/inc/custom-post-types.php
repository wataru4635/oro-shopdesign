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
			'menu_position' => 5,
			'taxonomies' => array('works_category'),
		)
	);

	register_taxonomy(
		'works_category',
		'works',
		array(
			'label' => '施工事例カテゴリー',
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
          if ( wp_is_mobile() ) {
              $query->set( 'posts_per_page', 4 );
          } else {
              $query->set( 'posts_per_page', 4 );
          }
      }
  }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );