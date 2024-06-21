<?php
// 利用者トップページ
session_start();
include __DIR__ . '/inc/header.php'; ?>

<main id="main">
  <div class="container">
    <div class="slide-img src1"></div>
    <div class="slide-img src2"></div>
    <div class="slide-img src3"></div>
    <div class="slide-img src4"></div>
    <div class="slide-img src5"></div>
  </div>

  <div class="concept">
    <p class="concept-title title">一人旅に挑戦したい、<br />聴こえないあなたへ</p>
    <div class="concept-text text">
      <p>未知の世界に飛び込もうとする時は、<br>ワクワクするけれど、ちょっぴり不安も付いてくると思います。</p>
      <p>あなたと同じように不安な気持ちを抱えながら、旅してきた聴こえない人達が沢山います。</p>
      <p>ここでは、聴こえない私たちの体験談や、<br>一人旅に役立つような情報を届けることで、<br>
        一人でも多くの方がのびのびと世界を広げられることを目指しています。</p>
      <p>知る事が更なるワクワクに繋がりますように。</p>
      <p>ここから、あなただけの冒険を始めよう。</p>
    </div>
  </div>

  <!-- CONTENTSセクション -->
  <section id="contents">
    <div class="top-img fixed-bg">
      <h1 class="section-title">記事<br />CONTENTS</h1>
    </div>

    <aside class="tag-wrapper">
      <h2 class="tag-title">記事タグ</h2>
      <ul class="tag-list">
        <li><a href="tag.php?tag=<?php echo urlencode('#国内'); ?>"><?php echo '#国内'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#海外'); ?>"><?php echo '#海外'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#体験談'); ?>"><?php echo '#体験談'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#配慮状況'); ?>"><?php echo '#配慮状況'; ?></a></li>
      </ul>
    </aside>

    <!--記事一覧部分　※最新のものから6つ表示-->
    <article class="article-contents">
      <ul class="item-wrapper">
        <?php include __DIR__ . '/index-include.php' ?>
      </ul>
    </article>

    <button class="read-more btn">
      <a href="contents.php">もっと見る</a>
    </button>
  </section>

  <!-- ABOUTセクション -->
  <section id="about">
    <div class="second-img fixed-bg">
      <h1 class="section-title">私たちについて<br />ABOUT US</h1>
    </div>
    <ul class="about-wrapper">
      <li class="pink-figure">
        <h3 class="about-heading">名前の由来</h3>
        <p class="site-name title">「Silent Adventure」</p>
        <p class="about-text text">
          私たちは、"聴こえない人たちの一人旅"にフォーカスを当てています。音は聴こえずとも、旅先で目を通じて、その地ならではの景色・食・交流などを思いっきり楽しむ＝刺激豊かな冒険であると、私たちは考えています。そして、多くの人にとってその足掛かりになるという使命を込めて、名付けました。
        </p>
      </li>
      <li class="yellow-figure">
        <h3 class="about-heading">目指しているもの</h3>
        <p class="about-text text">
          「聴こえない方達が一人旅への不安を解消し、安心して挑戦できる社会」<br>
          「一人旅を通じた交流の創生」<br>
          「国内における聴こえない方々や関わる方々の双方の意識向上及び配慮状況の向上」
        </p>
      </li>
      <li class="blue-figure">
        <h3 class="about-heading">事業内容</h3>
        <p class="about-text text">
          聴こえない方に向けて、当サイトにて、一人旅に役立つ情報や国内外のスポット・交通手段について発信しています。
          (掲載情報は、実際に聴こえない弊社社員が一人旅を通して得た情報を基に作成しております。掲載記事や私たちについてなど、お問い合わせがありましたら、<a class="link" href="#contact">コチラ</a>からお問い合わせください。
        </p>
      </li>
    </ul>
  </section>

  <!-- CONTACTセクション -->
  <section id="contact">
    <div class="third-img fixed-bg">
      <h1 class="section-title">お問い合わせ<br />CONTACT</h1>
    </div>
    <p class="text">
      ご質問・ご意見などありましたら、下記メールアドレス宛てもしくは、お問い合わせフォームにて、お問い合わせください。<br />また、配慮について、ご存じで掲載されていないものがありましたら、是非お聞かせください！<br>※なお、頂いた問い合わせに対しては、3営業日以内にメールにてご返信させていただきます。
    </p>
    <h2 class="address-title title">メールアドレス</h2>
    <a class="address-text" href="mailto:silentadventure.contact@gmail.com?subject=お問い合わせ">silentadventure.contact@gmail.com</a>

    <h2 class="form-heading title">お問い合わせフォーム</h2>
    <div id="form-container">
      <form id="contact-form" action="form-validation.php" method="post">
        <div class="form-left">
          <label class="form-title" for="name">お名前<span class="form-required">必須</span></label>
          <input id="user-name" class="text-field" type="text" name="user_name" required />
          <p>例）旅崎　花子</p>
          <label class="form-title" for="email">メールアドレス<span class="form-required">必須</span></label>
          <input id="user-email" class="text-field" type="email" name="user_email" required />
          <p>例）tabisaki.875@gmail.com</p>
        </div>
        <div class="form-right">
          <label class="form-title" for="message">内容<span class="form-required">必須</span></label>
          <textarea id="message" name="message" rows="7" cols="35" placeholder="お問い合わせの内容をご入力ください。" required></textarea>
        </div>
        <p class="attention">！ご注意ください！<br>以下のボタンをクリックするとすぐに送信されます。<br>送信する前に一度、入力内容に誤りがないか、お確かめください。</p>
        <p id="validate-msg" class="validate-msg nameError emailError messageError"></p>
        <p class="submit-message"></p>
        <input id="confirm" class="submit-btn btn" type="submit" name="confirm" value="送信する" />
      </form>
    </div>
  </section>
</main>

<?php include __DIR__ . '/inc/footer.php';
