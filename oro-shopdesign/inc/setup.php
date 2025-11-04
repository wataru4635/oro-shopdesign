<?php
// ==========================================================================
// WordPress テーマの基本設定
// ==========================================================================
function my_theme_setup() {
    // アイキャッチ画像を有効化
    add_theme_support('post-thumbnails');

    // タイトルタグ自動生成を有効化
    add_theme_support('title-tag');

    // RSSフィードリンクを自動生成
    add_theme_support('automatic-feed-links');

    // HTML5 マークアップのサポート（フォーム、コメント、ギャラリーなど）
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // ウィジェットの部分的なリフレッシュを有効化
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'my_theme_setup');

// ==========================================================================
// スクリプトとスタイルのエンキュー（共通 + 特定ページ）
// ==========================================================================
function enqueue_custom_scripts() {
    $theme_path = get_theme_file_path();
    $asset_uri  = get_theme_file_uri('/assets');

    // ファイルのバージョンを取得（存在すれば filemtime、なければテーマバージョン）
    $get_ver = function($file_path) {
        return file_exists($file_path) ? filemtime($file_path) : wp_get_theme()->get('Version');
    };

    // トップページ専用JS・CSS
    if (is_front_page()) {
        // Swiper JS
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
            [],
            '8.0.0',
            true
        );
        
        // Swiper CSS
        wp_enqueue_style(
            'swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css',
            [],
            '8.0.0'
        );
        
        // トップページ専用JS
        $script = '/js/top.js';
        wp_enqueue_script(
            'top-script',
            "{$asset_uri}{$script}",
            ['swiper-js'],
            $get_ver("{$theme_path}/assets{$script}"),
            true
        );
    }

    // お問い合わせページ専用JS
    if (is_page('contact') || is_page_template('page-contact.php')) {
        $script = '/js/form.js';
        wp_enqueue_script(
            'form-script',
            "{$asset_uri}{$script}",
            [],
            $get_ver("{$theme_path}/assets{$script}"),
            true
        );
    }

    // CSS（共通）- 最後に読み込む
    $style_file = '/css/style.css';
    wp_enqueue_style(
        'common-style',
        "{$asset_uri}{$style_file}",
        [],
        $get_ver("{$theme_path}/assets{$style_file}")
    );

    // JS（共通）- 最後に読み込む
    $script_file = '/js/script.js';
    wp_enqueue_script(
        'common-script',
        "{$asset_uri}{$script_file}",
        [],
        $get_ver("{$theme_path}/assets{$script_file}"),
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// ==========================================================================
// ヘッダーへのプリロード
// ==========================================================================
function enqueue_preload_headers() {
  ?>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;600;700&family=Noto+Sans:wght@500&family=Shippori+Mincho+B1:wght@400;500;600;700&family=Shippori+Mincho:wght@800&display=swap" rel="preload"
    as="style" fetchpriority="high">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;600;700&family=Noto+Sans:wght@500&family=Shippori+Mincho+B1:wght@400;500;600;700&family=Shippori+Mincho:wght@800&display=swap" rel="stylesheet"
    media="print" onload="this.media='all'">
<?php
}
add_action('wp_head', 'enqueue_preload_headers');

// ==========================================================================
// 不要な head内のタグやスクリプトを削除する関数
// ==========================================================================
function codeups_clean_up_head() {
    // WordPressのバージョン情報を削除（セキュリティ対策）
    remove_action('wp_head', 'wp_generator');

    // 絵文字関連のスクリプトとスタイルを削除（パフォーマンス向上）
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // 外部ツールとの連携用の不要なタグを削除（セキュリティ・軽量化）
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    // 追加フィードリンクを削除（必要な場合は残す）
    remove_action('wp_head', 'feed_links_extra', 3);
  }

  // テーマが読み込まれた後に実行
  add_action('after_setup_theme', 'codeups_clean_up_head');

// ==========================================================================
// SEOプラグイン使用しない場合
// ==========================================================================

// wp_head の <title> タグを削除
remove_action('wp_head', '_wp_render_title_tag', 1);

// ==========================================================================
// ブロックエディタのスタイルを追加
// ==========================================================================

function add_block_editor_styles() {
    wp_enqueue_style( 'editor-styles', get_stylesheet_directory_uri() . '/assets/css/editor.css' );
    
    // エディターにフォントファミリーを追加
    add_editor_style( array(
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap',
    ) );
    
    // インラインスタイルでフォントファミリーを設定
    wp_add_inline_style( 'editor-styles', '
        .editor-styles-wrapper {
            font-family: "Noto Sans JP", "Noto Sans", sans-serif !important;
        }
    ' );
}
add_action( 'enqueue_block_editor_assets', 'add_block_editor_styles' );

// ==========================================================================
// 投稿数の変更
// ==========================================================================
function modify_posts_per_page($query) {
    if ($query->is_main_query() && !is_admin()) {
        if (wp_is_mobile()) {
            $query->set('posts_per_page', 4);
        } else {
            $query->set('posts_per_page', 9);
        }
    }
}
add_action('pre_get_posts', 'modify_posts_per_page');

// ==========================================================================
// カスタム投稿タイプのパーマリンク設定
// ==========================================================================

add_filter('post_type_link', 'custom_post_type_permalink', 10, 2);
function custom_post_type_permalink($link, $post) {
    if ($post->post_type === 'column' || $post->post_type === 'works' || $post->post_type === 'video-gallery') {
        return home_url('/' . $post->post_type . '/' . $post->ID . '/');
    }
    return $link;
}

add_filter('rewrite_rules_array', 'custom_post_type_rewrite_rules');
function custom_post_type_rewrite_rules($rules) {
    $new_rules = array(
        'column/([0-9]+)/?$' => 'index.php?post_type=column&p=$matches[1]',
        'works/([0-9]+)/?$' => 'index.php?post_type=works&p=$matches[1]',
        'video-gallery/([0-9]+)/?$' => 'index.php?post_type=video-gallery&p=$matches[1]',
    );
    return $new_rules + $rules;
}

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
            <p><strong>【エラー】タイトルは24文字以内にしてください。</strong></p>
            <p>現在の文字数: <strong><?php echo $title_length; ?>文字</strong>（制限: 24文字）</p>
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
    
    if ($title_length > 24) {
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
        var maxLength = 24;
        
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
    // 自動保存の場合はスキップ
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // worksカスタム投稿タイプのみ
    if (get_post_type($post_id) !== 'works') {
        return;
    }
    
    // 権限チェック
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // 現在の投稿の「1枚目に表示」の値を取得
    $show_first = get_field('show_first_mv', $post_id);
    
    // チェックが入った場合のみ処理
    if ($show_first) {
        // 他のすべてのworks投稿の「1枚目に表示」をオフにする
        $args = array(
            'post_type' => 'works',
            'posts_per_page' => -1,
            'post__not_in' => array($post_id), // 現在の投稿を除外
            'meta_query' => array(
                array(
                    'key' => 'show_first_mv',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );
        
        $other_posts = get_posts($args);
        
        foreach ($other_posts as $other_post) {
            update_field('show_first_mv', false, $other_post->ID);
        }
    }
}
add_action('acf/save_post', 'ensure_single_first_mv_check', 20);

// ==========================================================================
// 施工事例一覧にカスタムカラムを追加
// ==========================================================================
// カラムを追加
function add_works_custom_columns($columns) {
    // タイトルの後に追加
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        // タイトルの後に新しいカラムを追加
        if ($key === 'title') {
            $new_columns['show_on_top'] = 'トップ表示';
            $new_columns['show_first'] = 'トップ：1枚目表示';
        }
    }
    
    return $new_columns;
}
add_filter('manage_works_posts_columns', 'add_works_custom_columns');

// カラムの内容を表示
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

// カラムをソート可能にする（オプション）
function make_works_columns_sortable($columns) {
    $columns['show_on_top'] = 'show_on_top_mv';
    $columns['show_first'] = 'show_first_mv';
    return $columns;
}
add_filter('manage_edit-works_sortable_columns', 'make_works_columns_sortable');

// ソート用のクエリ修正
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