"use strict";

/* ===============================================
# お問い合わせフォーム
=============================================== */
document.addEventListener("DOMContentLoaded", function () {
  const email = document.getElementById("email");
  const emailConfirm = document.getElementById("email-confirm");
  const form = document.getElementById("contact-form");
  const postalCode = document.getElementById("postal-code");
  const prefecture = document.getElementById("prefecture");
  const city = document.getElementById("city");
  const address = document.getElementById("address");
  if (!email || !emailConfirm || !form) return;
  const emailErrorRequired = emailConfirm.nextElementSibling;
  const emailErrorMismatch = emailErrorRequired.nextElementSibling;
  emailErrorRequired.style.display = "none";
  emailErrorMismatch.style.display = "none";
  if (postalCode && prefecture && city) {
    postalCode.addEventListener('input', function () {
      const cleanZip = this.value.replace(/-/g, '');
      if (cleanZip.length === 7) {
        AjaxZip3.zip2addr(this, '', '都道府県', '市区町村');
      }
    });
  }
  function checkEmailMatch() {
    const emailValue = email.value.trim();
    const emailConfirmValue = emailConfirm.value.trim();
    if (emailConfirmValue === "" && document.activeElement !== emailConfirm) {
      emailErrorRequired.style.display = "block";
      emailErrorMismatch.style.display = "none";
      emailConfirm.setCustomValidity("この項目は必須です");
    } else if (emailValue !== "" && emailValue !== emailConfirmValue && document.activeElement !== emailConfirm) {
      emailErrorRequired.style.display = "none";
      emailErrorMismatch.style.display = "block";
      emailConfirm.setCustomValidity("メールアドレスが一致しません");
    } else {
      emailErrorRequired.style.display = "none";
      emailErrorMismatch.style.display = "none";
      emailConfirm.setCustomValidity("");
    }
  }
  emailConfirm.addEventListener("focus", function () {
    emailErrorRequired.style.display = "none";
    emailErrorMismatch.style.display = "none";
    emailConfirm.setCustomValidity("");
  });
  emailConfirm.addEventListener("input", function () {
    emailErrorRequired.style.display = "none";
    emailErrorMismatch.style.display = "none";
    emailConfirm.setCustomValidity("");
  });
  email.addEventListener("input", function () {
    if (emailConfirm.value !== "") {
      emailErrorMismatch.style.display = "none";
      emailConfirm.setCustomValidity("");
    }
  });
  emailConfirm.addEventListener("blur", checkEmailMatch);
  email.addEventListener("blur", function () {
    if (emailConfirm.value !== "") {
      checkEmailMatch();
    }
  });
  form.addEventListener("submit", function (event) {
    checkEmailMatch();
    if (emailConfirm.validity.customError) {
      event.preventDefault();
    }
  });
});