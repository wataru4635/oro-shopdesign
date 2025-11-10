<?php
// ==========================================================================
// コメントの無効化・投稿非表示
// ==========================================================================
function comment_status_none( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'post' ) {
        return false;
    }
    if( $post->post_type == 'page' ) {
        return false;
    }
    if( $post->post_type == 'attachment' ) {
        return false;
    }
    return false;
}

add_filter( 'comments_open', 'comment_status_none', 10 , 2 );
function remove_menus() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
  }
  add_action( 'admin_menu', 'remove_menus', 999 );

// ==========================================================================
// 施工事例のタイトル文字数制限（24文字まで）
// ==========================================================================
function show_works_title_error() {
	$screen = get_current_screen();
	
	if (!$screen || $screen->post_type !== 'works') {
			return;
	}
	
	if (isset($_GET['title_error']) && $_GET['title_error'] == '1') {
			$title_length = isset($_GET['title_length']) ? intval($_GET['title_length']) : 0;
			?>
			<div class="notice notice-error is-dismissible">
					<p><strong>【エラー】タイトルは<?php echo WORKS_TITLE_MAX_LENGTH; ?>文字以内にしてください。</strong></p>
					<p>現在の文字数: <strong><?php echo $title_length; ?>文字</strong>（制限: <?php echo WORKS_TITLE_MAX_LENGTH; ?>文字）</p>
					<p>タイトルを短くしてから再度保存してください。</p>
			</div>
			<?php
	}
}
add_action('admin_notices', 'show_works_title_error');

function validate_works_title_on_save($post_id, $post, $update) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
	}
	
	if ($post->post_type !== 'works') {
			return;
	}
	
	if (!current_user_can('edit_post', $post_id)) {
			return;
	}
	
	$title = $post->post_title;
	$title_length = mb_strlen($title);
	
	if ($title_length > WORKS_TITLE_MAX_LENGTH) {
			remove_action('save_post', 'validate_works_title_on_save', 10);
			
			wp_update_post(array(
					'ID' => $post_id,
					'post_status' => 'draft'
			), true);
			
			add_action('save_post', 'validate_works_title_on_save', 10, 3);
			
			$redirect_url = add_query_arg(
					array(
							'post' => $post_id,
							'action' => 'edit',
							'title_error' => '1',
							'title_length' => $title_length
					),
					admin_url('post.php')
			);
			
			add_filter('redirect_post_location', function($location) use ($redirect_url) {
					return $redirect_url;
			});
	}
}
add_action('save_post', 'validate_works_title_on_save', 10, 3);

function add_works_title_validation_inline() {
	global $post;
	
	if (!$post || $post->post_type !== 'works') {
			return;
	}
	?>
	<style>
	.components-notice.is-error {
			background-color: #fef5f5 !important;
			border-left-color: #ff6b6b !important;
	}
	</style>
	<script type="text/javascript">
	(function() {
			var maxLength = <?php echo WORKS_TITLE_MAX_LENGTH; ?>;
			
			function initValidation() {
					if (typeof wp === 'undefined' || !wp.data) {
							setTimeout(initValidation, 100);
							return;
					}
					
					var select = wp.data.select;
					var dispatch = wp.data.dispatch;
					
					function showErrorNotice() {
							var existingError = document.querySelector('.works-title-error-notice');
							if (existingError) {
									existingError.remove();
							}
							
							var title = select('core/editor').getEditedPostAttribute('title') || '';
							var length = title.length;
							
							if (length > maxLength) {
									dispatch('core/notices').createErrorNotice(
											'【必須】タイトルは24文字以内にしてください。',
											{
													id: 'works-title-error',
													isDismissible: true
											}
									);
									
									dispatch('core/editor').lockPostSaving('title-too-long');
							} else {
									dispatch('core/notices').removeNotice('works-title-error');
									dispatch('core/editor').unlockPostSaving('title-too-long');
							}
					}
					
					var previousTitle = '';
					wp.data.subscribe(function() {
							var currentTitle = select('core/editor').getEditedPostAttribute('title') || '';
							if (currentTitle !== previousTitle) {
									previousTitle = currentTitle;
									showErrorNotice();
							}
					});
					
					setTimeout(showErrorNotice, 1000);
			}
			
			if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', initValidation);
			} else {
					initValidation();
			}
	})();
	</script>
	<?php
}
add_action('admin_head-post.php', 'add_works_title_validation_inline');
add_action('admin_head-post-new.php', 'add_works_title_validation_inline');

// ==========================================================================
// 1枚目に表示のチェックを1つだけに制限
// ==========================================================================
function ensure_single_first_mv_check($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
	}
	
	if (get_post_type($post_id) !== 'works') {
			return;
	}
	
	if (!current_user_can('edit_post', $post_id)) {
			return;
	}
	
	$show_first = get_field('show_first_mv', $post_id);
	
	if ($show_first) {
			global $wpdb;
			
			$meta_key = 'show_first_mv';
			
			$wpdb->query(
					$wpdb->prepare(
							"UPDATE {$wpdb->postmeta} pm
							INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
							SET pm.meta_value = '0'
							WHERE pm.meta_key = %s
							AND pm.meta_value = '1'
							AND p.post_type = 'works'
							AND pm.post_id != %d",
							$meta_key,
							$post_id
					)
			);
	}
}
add_action('acf/save_post', 'ensure_single_first_mv_check', 20);

// ==========================================================================
// 施工事例一覧にカスタムカラムを追加
// ==========================================================================
function add_works_custom_columns($columns) {
	$new_columns = array();
	
	foreach ($columns as $key => $value) {
			$new_columns[$key] = $value;
			
			if ($key === 'title') {
					$new_columns['show_on_top'] = 'トップ表示';
					$new_columns['show_first'] = 'トップ：1枚目表示';
			}
	}
	
	return $new_columns;
}
add_filter('manage_works_posts_columns', 'add_works_custom_columns');

function display_works_custom_columns($column, $post_id) {
	switch ($column) {
			case 'show_on_top':
					$show_on_top = get_field('show_on_top_mv', $post_id);
					if ($show_on_top) {
							echo '<span style="font-size: 18px; color: #4CAF50;">✅</span>';
					} else {
							echo '<span style="color: #ccc;">—</span>';
					}
					break;
					
			case 'show_first':
					$show_first = get_field('show_first_mv', $post_id);
					if ($show_first) {
							echo '<span style="font-size: 18px; color: #2196F3;">✅</span>';
					} else {
							echo '<span style="color: #ccc;">—</span>';
					}
					break;
	}
}
add_action('manage_works_posts_custom_column', 'display_works_custom_columns', 10, 2);

function make_works_columns_sortable($columns) {
	$columns['show_on_top'] = 'show_on_top_mv';
	$columns['show_first'] = 'show_first_mv';
	return $columns;
}
add_filter('manage_edit-works_sortable_columns', 'make_works_columns_sortable');

function works_custom_column_orderby($query) {
	if (!is_admin() || !$query->is_main_query()) {
			return;
	}
	
	$orderby = $query->get('orderby');
	
	if ('show_on_top_mv' === $orderby) {
			$query->set('meta_key', 'show_on_top_mv');
			$query->set('orderby', 'meta_value');
	}
	
	if ('show_first_mv' === $orderby) {
			$query->set('meta_key', 'show_first_mv');
			$query->set('orderby', 'meta_value');
	}
}
add_action('pre_get_posts', 'works_custom_column_orderby');