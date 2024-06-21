<?php
// 記事一覧ページ
include __DIR__ . '/inc/header.php';
?>

<main id="main">
  <div class="contents-img fixed-bg">
    <h1 class="section-title">CONTENTS<br />記事一覧</h1>
  </div>

  <!-- 記事タグ一覧 -->
  <aside class="tag-wrapper">
    <h2 class="tag-title">記事タグ</h2>
    <ul class="tag-list">
      <li><a href="tag.php?tag=<?php echo urlencode('#国内'); ?>"><?php echo '#国内'; ?></a></li>
      <li><a href="tag.php?tag=<?php echo urlencode('#海外'); ?>"><?php echo '#海外'; ?></a></li>
      <li><a href="tag.php?tag=<?php echo urlencode('#体験談'); ?>"><?php echo '#体験談'; ?></a></li>
      <li><a href="tag.php?tag=<?php echo urlencode('#配慮状況'); ?>"><?php echo '#配慮状況'; ?></a></li>
    </ul>
  </aside>

  <!-- 記事一覧部分 -->
  <?php include __DIR__ . '/contents-include.php'; ?>
</main>

<?php include __DIR__ . '/inc/footer.php';

