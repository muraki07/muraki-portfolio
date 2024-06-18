<!-- 記事の追加フォーム -->
<?php
include __DIR__ . '/inc/header.php';
?>

<main>
  <div class="contents-img fixed-bg">
    <h1 class="section-title">記事追加<br />ADD ARTICLE</h1>
  </div>

  <section>
    <p class="text">以下に追加する記事の情報を入力し、「追加する」ボタンをクリックしてください。</p>

    <form id="addForm" action="add.php" method="POST" enctype="multipart/form-data">
      <p>
        <label for="title">タイトル<span class="form-required">必須</span>（30文字まで）:</label>
        <input id="add-title" type="text" name="title" maxlength="30" required />
      </p>
      <p>
        <label for="content">内容<span class="form-required">必須</span>（2000文字まで）:</label>
        <textarea id="add-content" name="content" cols="75" rows="18" maxlength="2000" required></textarea>
      <div class="char-count">残り文字数: <span class="count">2000</span>（文字数には、改行やスペースも含まれます。入力を始めると、カウントされます。）</div>
      </p>
      <p>
        <label for="employee_id">投稿者<span class="form-required">必須</span>:</label>
        <input class="employee-id" type="radio" name="employee_id" value="1" required />村木
        <input class="employee-id" type="radio" name="employee_id" value="2" required />山田
        <input class="employee-id" type="radio" name="employee_id" value="3" required />佐藤
      </p>
      <p>
        <label for="tag">タグ<span class="form-required">必須</span>:</label>
        <input type="checkbox" name="tag[]" value="#国内" />#国内
        <input type="checkbox" name="tag[]" value="#海外" />#海外
        <input type="checkbox" name="tag[]" value="#体験談" />#体験談
        <input type="checkbox" name="tag[]" value="#配慮状況" />#配慮状況
      </p>
      <p>
        <label for="image">画像：</label>
        <input type="file" id="imageUpload" name="image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)" />
      <div class="item-img-wrapper">
        <img id="imagePreview" src="#" alt="" />
      </div>
      </p>
      <p id="validate_msg" class="validate-msg title-error content-error employee-id-error tag-error"></p>
      <p>
        <input class="add-btn btn" type="submit" value="追加する" />
      </p>
    </form>
  </section>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>
<script src="../js/add-validation.js"></script>
<script src="../js/add-count.js"></script>
</body>

</html>