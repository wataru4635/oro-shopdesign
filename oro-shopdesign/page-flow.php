<?php
/*
Template Name: ご依頼の流れ
*/
?>

<?php get_header(); ?>

<main>

  <section class="sub-mv">
    <hgroup class="sub-mv__content sub-mv__content--flow">
      <p class="sub-mv__en-title">flow</p>
      <h1 class="sub-mv__title">
        <img src="<?php echo IMAGEPATH; ?>/common/flow-title.webp" alt="ご依頼の流れ" width="167.561" height="27.567" class="sub-mv__title-img">
      </h1>
    </hgroup>
  </section>

  <section class="flow">
    <div class="flow__inner">
      <ul class="flow__list">
        <li class="flow__item flow__item--01 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 1">1</span>
            <p class="flow__title">ご依頼・相談・打合せ</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                お客様のご要望、計画内容をお聞かせください。事業内容やご希望のコンセプト、スケジュール感、ご予算などをヒアリングいたします。
              </p>
            </div>
          </div>
        </li>

        <li class="flow__item flow__item--02 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 2">2</span>
            <p class="flow__title">テナント調査</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                ご希望エリアや候補物件について、テナントの条件や設備状況を調査・確認いたします。物件の特性を理解した上で、設計可能な内容や制約を整理します。消防法や保健所の基準など、営業に必要な法令面の調査も行います。
              </p>
            </div>
          </div>
        </li>

        <li class="flow__item flow__item--03 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 3">3</span>
            <p class="flow__title">プランニング提案・ご契約</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                プラン・イメージの方針が決まりましたら、プラン等の図面、パース、その他資料により、説明を行い確認いたします。合意確認後、設計契約を結び、実施設計に入ります（設計契約の時期はプロジェクトごとに異なります）。
              </p>
            </div>
          </div>
        </li>

        <li class="flow__item flow__item--04 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 4">4</span>
            <p class="flow__title">実施設計・見積</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                構造、設備を含む詳細な打ち合わせ、図面、仕様書の作成にかかります。
              </p>
              <p class="flow__text">
                工事費見積もりの前に、上記の実施設計図書の内容をご説明、確認いたします。自社で施工が可能なので、見積書を作成いたします。
              </p>
            </div>
          </div>
        </li>

        <li class="flow__item flow__item--05 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 5">5</span>
            <p class="flow__title">工事着工・工事管理業務</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                設計図書通り工事が行われているか、確認、調整を行います。設計図書からの変更がある場合、検討、調整をします。工事進捗の管理・確認を行い、工事の品質を確保します。
              </p>
            </div>
          </div>
        </li>

        <li class="flow__item flow__item--06 js-flow-animation">
          <div class="flow__header">
            <span class="flow__step-number" aria-label="step 6">6</span>
            <p class="flow__title">完成・アフターサポート</p>
          </div>
          <div class="flow__body">
            <span class="flow__rule" aria-hidden="true"></span>
            <div class="flow__text-wrap">
              <p class="flow__text">
                すべての工事が完了したら、最終確認のうえお引き渡しいたします。営業開始後も、必要に応じて設備の調整や、改装・追加工事のご相談を承ります。
              </p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <section class="contact-section contact-section--flow">
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

  <div class="flow-top-btn">
    <a href="<?php echo HOME_URL; ?>" class="link-btn-sub link-btn-sub--white">
      <span class="link-btn-sub__text">トップに戻る</span>
    </a>
  </div>

</main>

<?php get_footer(); ?>