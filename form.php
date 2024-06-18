<!-- 問い合わせフォーム -->
<form id="contactForm" action="form-validation.php" method="post">
  <div class="left">
    <label class="form-title" for="name">お名前<span class="form-required">必須</span></label>
    <input id="user_name" class="text-field" type="text" name="user_name" required="required" />
    <p>例）旅崎　花子</p>
    <p class="validate_msg nameError" style="color: red;"></p>
    <label class="form-title" for="email">メールアドレス<span class="form-required">必須</span></label>
    <input id="user_email" class="text-field" type="email" name="user_email" required />
    <p>例）tabisaki.875@gmail.com</p>
    <p class="validate_msg emailError" style="color: red;"></p>
  </div>
  <div class="right">
    <label class="form-title" for="message" required>内容<span class="form-required">必須</span></label>
    <textarea id="message" name="message" rows="7" cols="35" placeholder="お問い合わせの内容をご入力ください。" required="required"></textarea>
  </div>
  <p id="validate_msg" class="validate_msg messageError" style="color: red;"></p>
  <p class="attention">！ご注意ください！<br>以下のボタンをクリックするとすぐに送信されます。<br>送信する前に一度、入力内容に誤りがないか、お確かめください。</p>
  <p class="submit-message"></p>
  <input id="confirm" class="submit-btn btn" type="submit" name="confirm" value="送信する" />
</form>