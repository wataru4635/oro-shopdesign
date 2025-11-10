<?php
// ==========================================================================
// 定義
// ==========================================================================
/* ---------- パスの短縮 ---------- */
define('IMAGEPATH',            get_template_directory_uri() . '/assets/images');

/* ---------- 各ページのリンク ---------- */
define('HOME_URL',             esc_url(home_url('/')));                          // トップページ
define('ABOUT_URL',            esc_url(home_url('/about/')));                    // 会社紹介
define('FLOW_URL',             esc_url(home_url('/flow/')));                     // ご依頼の流れ
define('WORKS_URL',            esc_url(home_url('/works/')));                    // 施工事例
define('BLOG_URL',             esc_url(home_url('/blog/')));                     // 読みもの
define('CONTACT_URL',          esc_url(home_url('/contact/')));                  // お問い合わせ
define('CONTACT_CONFIRM_URL',  esc_url(home_url('/contact-confirm/')));          // お問い合わせ確認
define('CONTACT_THANKS_URL',   esc_url(home_url('/contact-thanks/')));           // お問い合わせ完了

/* ---------- メール設定 ---------- */
define('ADMIN_CONTACT_EMAIL',  'contact@oro-sekkei.com');                        // 管理者受信用メールアドレス
define('REPLY_EMAIL',          'contact@oro-shopdesign.com');                    // 自動返信送信元メールアドレス
define('SITE_NAME',            'oroショップデザイン｜oro株式会社');                // サイト名

/* ---------- その他設定 ---------- */
define('WORKS_TITLE_MAX_LENGTH', 24);                                            // 施工事例のタイトル最大文字数
