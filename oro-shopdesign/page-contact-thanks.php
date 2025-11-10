<?php
/*
Template Name: お問い合わせ完了画面
*/
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['contact_confirm_nonce']) || !wp_verify_nonce($_POST['contact_confirm_nonce'], 'contact_form_confirm'))) {
  wp_redirect(home_url('/contact'));
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['contact_form'])) {
  $form_data = $_SESSION['contact_form'];

  $required_fields = array('お名前', 'ふりがな', '郵便番号', '都道府県', '市区町村', 'メールアドレス', 'メールアドレス確認用', 'お電話番号', 'お問い合わせ内容');
  $is_valid = true;

  foreach ($required_fields as $field) {
    if (empty($form_data[$field])) {
      $is_valid = false;
      break;
    }
  }

  if ($is_valid && !filter_var($form_data['メールアドレス'], FILTER_VALIDATE_EMAIL)) {
    $is_valid = false;
  }

  if ($is_valid) {
    // メール設定
    $admin_email = get_option('admin_email');
    $contact_email = ADMIN_CONTACT_EMAIL;
    $reply_email = REPLY_EMAIL;
    $site_name = SITE_NAME;

    send_admin_email($form_data, $contact_email, $site_name, $reply_email);
    send_auto_reply($form_data, $reply_email, $site_name, $contact_email);

    unset($_SESSION['contact_form']);
  } else {
    wp_redirect(home_url('/contact'));
    exit;
  }
} else {
  wp_redirect(home_url('/contact'));
  exit;
}

/**
 * 管理者宛メール送信
 */
function send_admin_email($data, $admin_email, $site_name, $from_email) {
  $subject = "【oroショップデザイン】ホームページよりお問い合わせがありました。";
  $subject = wp_strip_all_tags($subject);

  $message = "※本メールはシステムからの自動配信メールです。\n\n";
  $message .= "以下の内容でお問い合わせがありました。\n\n";
  $message .= "ーー お問い合わせ内容 ーー\n\n";

  $message .= "■お名前\n" . esc_html($data['お名前']) . "\n\n";
  $message .= "■ふりがな\n" . esc_html($data['ふりがな']) . "\n\n";
  $message .= "■郵便番号\n" . esc_html($data['郵便番号']) . "\n\n";
  $message .= "■都道府県\n" . esc_html($data['都道府県']) . "\n\n";
  $message .= "■市区町村\n" . esc_html($data['市区町村']) . "\n\n";

  if (!empty($data['番地・建物等'])) {
    $message .= "■番地・建物等\n" . esc_html($data['番地・建物等']) . "\n\n";
  }

  $message .= "■メールアドレス\n" . sanitize_email($data['メールアドレス']) . "\n\n";
  $message .= "■お電話番号\n" . esc_html($data['お電話番号']) . "\n\n";
  $message .= "■お問い合わせ内容\n" . esc_html($data['お問い合わせ内容']) . "\n\n";

  $message .= "--------------------------------------\n";
  $message .= "送信日時：" . date("Y/m/d H:i") . "\n";
  $message .= "IPアドレス：" . sanitize_text_field($_SERVER['REMOTE_ADDR']) . "\n";
  $message .= "--------------------------------------";

  $headers = array(
    'From: ' . $site_name . ' <' . sanitize_email($from_email) . '>'
  );

  wp_mail($admin_email, $subject, $message, $headers);
}

/**
 * 自動返信メール送信
 */
function send_auto_reply($data, $from_email, $site_name, $reply_to_email) {
  $subject = "【oroショップデザイン】お問い合わせありがとうございます。";
  $subject = wp_strip_all_tags($subject);

  $message = esc_html($data['お名前']) . " 様\n\n";
  $message .= "※本メールはシステムからの自動配信メールです。こちらのメールアドレス宛にはご返信いただけませんので、ご了承ください。\n\n";
  $message .= "お問い合わせありがとうございます。\n";
  $message .= "以下の内容で受付しました。\n\n";
  $message .= "ーー お問い合わせ内容 ーー\n\n";

  $message .= "■お名前\n" . esc_html($data['お名前']) . "\n\n";
  $message .= "■ふりがな\n" . esc_html($data['ふりがな']) . "\n\n";
  $message .= "■郵便番号\n" . esc_html($data['郵便番号']) . "\n\n";
  $message .= "■都道府県\n" . esc_html($data['都道府県']) . "\n\n";
  $message .= "■市区町村\n" . esc_html($data['市区町村']) . "\n\n";

  if (!empty($data['番地・建物等'])) {
    $message .= "■番地・建物等\n" . esc_html($data['番地・建物等']) . "\n\n";
  }

  $message .= "■メールアドレス\n" . sanitize_email($data['メールアドレス']) . "\n\n";
  $message .= "■お電話番号\n" . esc_html($data['お電話番号']) . "\n\n";
  $message .= "■お問い合わせ内容\n" . esc_html($data['お問い合わせ内容']) . "\n\n";

  $message .= "お問い合わせ内容確認後、担当者よりご返答いたします。\n";
  $message .= "数日経ちましても返答が無い場合は、サーバの不具合等も考えられるため、お手数ですがお電話またはメールフォームにて再度お問い合わせください。\n\n";

  $message .= "==========================\n";
  $message .= "{$site_name}\n";
  $message .= "URL: " . esc_url(home_url()) . "\n";
  $message .= "==========================\n";

  $headers = array(
    'From: ' . $site_name . ' <' . sanitize_email($from_email) . '>',
    'Reply-To: ' . sanitize_email($reply_to_email)
  );

  wp_mail(sanitize_email($data['メールアドレス']), $subject, $message, $headers);
}
?>

<?php get_header(); ?>

<main>

  <section class="sub-mv sub-mv--contact">
    <hgroup class="sub-mv__content sub-mv__content--contact">
      <p class="sub-mv__en-title">contact</p>
      <h1 class="sub-mv__title">
        <img src="<?php echo IMAGEPATH; ?>/common/contact-title.webp" alt="お問い合わせ" width="168.798" height="27.552"
          class="sub-mv__title-img">
      </h1>
    </hgroup>
  </section>

  <section class="contact-thanks">
    <div class="contact-thanks__inner">
      <p class="contact-thanks__sub">thank you</p>
      <p class="contact-thanks__text">お問い合わせありがとうございました。</p>
      <p class="contact-thanks__note">
        フォーム送信後、一定期間以上経っても連絡がない場合は、システムエラーの可能性がございます。その際は、お手数ですが再度フォームの送信をお願いいたします。
      </p>
      <div class="contact-thanks-top-btn">
        <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
          <span class="link-btn-sub__text">トップに戻る</span>
        </a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>