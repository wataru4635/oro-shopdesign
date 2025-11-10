<?php
/*
Template Name: お問い合わせ
*/
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

  <div class="contact-lead">
    <div class="contact-lead__inner">
      <p class="contact-lead__text">
        oroショップデザインは、oro株式会社が運営しております。お問い合わせは、以下の問い合わせフォームまたはLINEにて受け付けています。ご相談は無料ですので、お気軽にご連絡ください。
      </p>
    </div>
  </div>

  <section class="contact-line">
    <div class="contact-line__inner">
      <div class="contact-line__heading">
        <img src="<?php echo IMAGEPATH; ?>/contact/line-icon.webp" alt="LINEのロゴアイコン" width="31" height="31"
          loading="lazy" class="contact-line__icon" />
        <h2 class="contact-line__title">LINEで問い合わせる</h2>
      </div>

      <p class="contact-line__lead">
        LINEで友だち追加をしていただいた上で、プランやお見積のご依頼や、その他ご質問があればお気軽にメッセージください。
      </p>

      <div class="contact-line__block contact-line__block--qr">
        <p class="contact-line__subtitle">1／QRコードで友だち追加をする方法</p>
        <p class="contact-line__text">
          LINEの友だち追加ページで「QRコード」を選択して、友だち追加ができます。
        </p>

        <div class="contact-line__img-wrap">
          <img src="<?php echo IMAGEPATH; ?>/contact/line-qr.webp" alt="LINE友だち追加用のQRコード" width="143.829"
            height="143.829" loading="lazy" class="contact-line__img" />
        </div>
      </div>

      <div class="contact-line__block contact-line__block--id">
        <p class="contact-line__subtitle">2／ID検索で友だち追加をする方法</p>
        <p class="contact-line__text">
          LINEの友だち追加ページで「ID検索」を選択して、友だち追加ができます。
        </p>

        <div class="contact-line__id">
          <p class="contact-line__id-text">ID:＠557nuvpl</p>
        </div>
      </div>
    </div>
  </section>


  <section class="contact-form">
    <div class="contact-form__inner">
      <div class="contact-form__heading">
        <img src="<?php echo IMAGEPATH; ?>/contact/mail-icon.svg" alt="メールのアイコン" width="27" height="21.938"
          loading="lazy" class="contact-form__icon" />
        <h2 class="contact-form__title">メールで問い合わせる</h2>
      </div>
      <p class="contact-form__intro">以下の問い合わせフォームに必要事項をご入力ください。</p>
      <p class="contact-form__note">※<span class="contact-form__required contact-form__required--note"></span>の項目は必須入力です。
      </p>
      <form id="contact-form" action="<?php echo esc_url(home_url('/contact-confirm')); ?>" method="post">
        <?php wp_nonce_field('contact_form_submit', 'contact_nonce'); ?>
        <dl class="contact-form__list">
          <div class="contact-form__item">
            <dt>
              <label for="name" class="contact-form__label">お名前<span class="contact-form__required"></span></label>
            </dt>
            <dd class="contact-form__input">
              <input type="text" id="name" name="お名前" required autocomplete="name">
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt><label for="furigana" class="contact-form__label">ふりがな<span
                  class="contact-form__required"></span></label>
            </dt>
            <dd class="contact-form__input">
              <input type="text" id="furigana" name="ふりがな" required
                autocomplete="additional-name">
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt class="contact-form__label--mt"><label for="postal-code" class="contact-form__label">郵便番号<span
                  class="contact-form__required"></span></label></dt>
            <dd class="contact-form__input contact-form__input--postal">
              <input type="text" id="postal-code" name="郵便番号" pattern="[0-9]{3}-?[0-9]{4}" maxlength="8"
                autocomplete="postal-code" required>
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt><label for="prefecture" class="contact-form__label">都道府県<span class="contact-form__required"></span></label></dt>
            <dd class="contact-form__input">
              <input type="text" id="prefecture" name="都道府県" required autocomplete="address-level1">
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt><label for="city" class="contact-form__label">市区町村<span class="contact-form__required"></span></label></dt>
            <dd class="contact-form__input">
              <input type="text" id="city" name="市区町村" autocomplete="address-level2" required>
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt><label for="address" class="contact-form__label">番地・建物等</label></dt>
            <dd class="contact-form__input">
              <input type="text" id="address" name="番地・建物等" autocomplete="address-line1">
            </dd>
          </div>
          <div class="contact-form__item">
            <dt class="contact-form__label--mt"><label for="email"
                class="contact-form__label contact-form__label--column">メールアドレス<span
                  class="contact-form__required"></span></label><span class="contact-form__label-note">※半角英数字</span>
            </dt>
            <dd class="contact-form__input">
              <input type="email" id="email" name="メールアドレス" required autocomplete="email">
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt class="contact-form__label--mt"><label for="email-confirm" class="contact-form__label">メールアドレス確認用<span
                  class="contact-form__required"></span></label><span class="contact-form__label-note">※半角英数字</span>
            </dt>
            <dd class="contact-form__input">
              <input type="email" id="email-confirm" name="メールアドレス確認用" required autocomplete="email">
              <span class="error-message">この項目は必須です</span>
              <span class="email-mismatch-error error-message">メールアドレスが一致しません</span>
            </dd>
          </div>
          <div class="contact-form__item">
            <dt><label for="phone" class="contact-form__label">お電話番号<span class="contact-form__required"></span></label>
            </dt>
            <dd class="contact-form__input">
              <input type="tel" id="phone" name="お電話番号" pattern="^(\d{10}|\d{11}|\d{2,4}-\d{1,4}-\d{4})$" required
                autocomplete="tel">
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
          <div class="contact-form__item contact-form__item--textarea">
            <dt><label for="inquiry" class="contact-form__label">お問い合わせ内容</label><span
                class="contact-form__required"></span></dt>
            <dd class="contact-form__input">
              <textarea id="inquiry" name="お問い合わせ内容" required></textarea>
              <span class="error-message">この項目は必須です</span>
            </dd>
          </div>
        </dl>
        <div class="contact-form__submit">
          <button class="contact-form__submit-btn" type="submit"><span class="contact-form__submit-btn-text">確 認</span></button>
        </div>
      </form>
      <div class="contact-form-top-btn">
    <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
      <span class="link-btn-sub__text">トップに戻る</span>
    </a>
  </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>