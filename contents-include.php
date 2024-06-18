<!-- 記事一覧ページの内容 -->
<?php
require_once __DIR__ . '/../functions.php';

// ページネーション用の設定
$articles_per_page = 6; // 1ページに表示する記事の数
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 現在のページ番号
$start_index = ($current_page - 1) * $articles_per_page; // ページの開始インデックス

try {
  $pdo = db_open();

  $total_articles_stmt = $pdo->query("SELECT COUNT(*) FROM article");
  $total_articles = $total_articles_stmt->fetchColumn();

  // 総ページ数を計算
  $total_pages = ceil($total_articles / $articles_per_page);

  $sql = "SELECT article.article_id, title, SUBSTRING(content, 1, 100) AS content, insert_date, update_date, employee.employee_name, GROUP_CONCAT(tag.tag_name SEPARATOR ', ') AS tags
            FROM article
            LEFT JOIN employee ON article.employee_id = employee.employee_id
            LEFT JOIN article_tag ON article.article_id = article_tag.article_id
            LEFT JOIN tag ON article_tag.tag_id = tag.tag_id
            GROUP BY article.article_id
            ORDER BY CASE WHEN update_date IS NOT NULL THEN update_date ELSE insert_date END DESC
            LIMIT :start_index, :articles_per_page";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':start_index', $start_index, PDO::PARAM_INT);
  $stmt->bindParam(':articles_per_page', $articles_per_page, PDO::PARAM_INT);
  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

  <!-- 記事一覧部分 -->
  <article class="article-contents">
    <ul class="item-wrapper">
      <?php foreach ($articles as $article) {
        // 記事の画像を取得
        $sql_image = "SELECT image_path FROM article_image WHERE article_id = :article_id";
        $stmt_image = $pdo->prepare($sql_image);
        $stmt_image->bindParam(":article_id", $article['article_id'], PDO::PARAM_INT);
        $stmt_image->execute();
        $image = $stmt_image->fetch(PDO::FETCH_ASSOC);
      ?>
        <li>
          <a href="item.php?article_id=<?php echo htmlspecialchars($article['article_id']); ?>">
            <h3 class="item-title"><?php echo html2str($article['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <div class="article-detail"><img src="<?php echo html2str($image['image_path'] ?? '../img/default.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="記事の画像" /></div>
            <p>投稿者：<?php echo html2str($article['employee_name'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>投稿日：<?php echo html2str($article['insert_date'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php if (htmlspecialchars($article['update_date'])) {
              echo "<p>更新日：" . html2str($article['update_date'], ENT_QUOTES, 'UTF-8') . "</p>";
            } ?>
            <p>タグ：<?php echo html2str($article['tags'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><?php echo html2str($article['content'], ENT_QUOTES, 'UTF-8'); ?>...</p>
          </a>
        </li>
      <?php } ?>
    </ul>

    <!-- ページネーション -->
    <div class="pagination">
      <p><?php echo '全件数:' . $total_articles . '件'; ?></p>
      <ul class="page">
        <?php if ($current_page > 1) : ?>
          <li><a href="?page=<?php echo $current_page - 1; ?>">前へ</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li>
            <?php if ($i == $current_page) : ?>
              <span class="current-page"><?php echo $i; ?></span>
            <?php else : ?>
              <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
          </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages) : ?>
          <li><a href="?page=<?php echo $current_page + 1; ?>">次へ</a></li>
        <?php endif; ?>
      </ul>
      <p><?php echo $current_page; ?>/<?php echo $total_pages; ?></p>
    </div>
  </article>
<?php
} catch (PDOException) {
  require_once __DIR__ . '/error.php';
  exit;
}
