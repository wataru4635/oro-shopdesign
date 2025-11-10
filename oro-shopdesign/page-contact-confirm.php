<?php
/*
Template Name: お問い合わせ確認
*/

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form_submit'))) {
  wp_redirect(home_url('/contact'));
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sanitized_data = array();
  foreach ($_POST as $key => $value) {
    if (!is_string($value)) {
      continue;
    }
    
    $value = str_replace(array("\r\n", "\r"), "\n", $value);
    
    if ($key === 'お問い合わせ内容') {
      $sanitized_data[$key] = sanitize_textarea_field($value);
    } else {
      $sanitized_data[$key] = sanitize_text_field($value);
    }
  }
  
  $_SESSION['contact_form'] = $sanitized_data;
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

  <section class="contact-form contact-form--confirm">
    <div class="contact-form__inner">
      <div class="contact-form__heading">
        <img src="<?php echo IMAGEPATH; ?>/contact/mail-icon.svg" alt="メールのアイコン" width="27" height="21.938"
          loading="lazy" class="contact-form__icon" />
        <h2 class="contact-form__title">メールで問い合わせる</h2>
      </div>
      <p class="contact-form__intro">入力内容をご確認いただき、間違いがなければ送信してください。</p>
      <p class="contact-form__note">※<span
          class="contact-form__required contact-form__required--note"></span>の項目は必須入力です。
      </p>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        ?>
      <form id="contact-form-confirm" action="<?php echo esc_url(home_url('/contact-thanks')); ?>" method="post">
        <?php wp_nonce_field('contact_form_confirm', 'contact_confirm_nonce'); ?>
        <dl class="contact-form__list contact-form__list--confirm">
          <div class="contact-form__item">
            <dt class="contact-form__label">お名前<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['お名前']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">ふりがな<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['ふりがな']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">郵便番号<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['郵便番号']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">都道府県<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['都道府県']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">市区町村<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['市区町村']); ?>
            </dd>
          </div>

          <?php if (!empty($_POST['番地・建物等'])) : ?>
          <div class="contact-form__item">
            <dt class="contact-form__label">番地・建物等</dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['番地・建物等']); ?>
            </dd>
          </div>
          <?php endif; ?>

          <div class="contact-form__item">
            <dt class="contact-form__label">メールアドレス<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['メールアドレス']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">メールアドレス確認用<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['メールアドレス確認用']); ?>
            </dd>
          </div>

          <div class="contact-form__item">
            <dt class="contact-form__label">お電話番号<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo esc_html($_POST['お電話番号']); ?>
            </dd>
          </div>

          <div class="contact-form__item contact-form__item--textarea">
            <dt class="contact-form__label">お問い合わせ内容<span class="contact-form__required"></span></dt>
            <dd class="contact-form__input contact-form__confirm-text">
              <?php echo wp_kses_post(nl2br(esc_html($_POST['お問い合わせ内容']))); ?>
            </dd>
          </div>
        </dl>

        <div class="contact-form__confirm-submit">
          <div class="contact-form__confirm-submit-back-btn"><button class="contact-form__confirm-submit-back"
              type="button" onclick="history.back()"><span
                class="contact-form__confirm-submit-back-text">戻る</span></button></div>
          <div class="contact-form__confirm-submit-btn"><button class="contact-form__submit-btn" type="submit"><span
                class="contact-form__submit-btn-text">送 信</span></button></div>
        </div>
      </form>
      <?php
      } else {
        wp_redirect(home_url('/contact'));
        exit;
      }
      ?>

      <div class="contact-form-top-btn">
        <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
          <span class="link-btn-sub__text">トップに戻る</span>
        </a>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>