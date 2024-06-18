<!-- 記事更新ページ -->
<?php
require_once __DIR__ . '/login-check.php';
include __DIR__ . '/inc/header.php';
?>

<main>
  <div class="contents-img fixed-bg">
    <h1 class="section-title">記事更新<br />UPDATE ARTICLE</h1>
  </div>
  <!-- 更新フォーム -->
  <?php require_once __DIR__ . '/edit-form.php'; ?>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>
<script src="../js/edit-validation.js"></script>
<script src="../js/edit-count.js"></script>
</body>

</html>