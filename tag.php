<!-- タグ別記事一覧ページ -->
<?php
include __DIR__ . '/inc/header.php';
?>

<main id="main">
  <div class="tags-img fixed-bg">
    <h1 class="section-title">タグ別記事一覧<br />CONTENTS</h1>
  </div>

  <!--記事一覧部分-->
  <?php require_once __DIR__ . '/tag-include.php'; ?>
</main>

<?php include __DIR__ . '/inc/footer.php';
