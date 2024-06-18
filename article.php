<!-- 管理者ページのトップページ -->
<?php
include __DIR__ . '/inc/header.php';
require_once __DIR__ . '/login-check.php';
require_once __DIR__ . '/../functions.php';
?>

<main>
  <div class="contents-img fixed-bg">
    <h1 class="section-title">記事一覧<br />ARTICLE</h1>
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

  <?php require_once __DIR__ . '/list.php'; ?>
</main>

<?php include __DIR__ . '/inc/footer.php';
