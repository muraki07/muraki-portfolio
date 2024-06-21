<?php
// 個別記事ページの内容
require_once __DIR__ . '/../functions.php';

try {
  $pdo = db_open();

  // GETパラメータから記事IDを取得
  if (isset($_GET['article_id'])) {
    $article_id = htmlspecialchars($_GET['article_id']);

    // データベースから記事情報を取得
    $sql = "SELECT article.article_id, title, content, insert_date, update_date, employee.employee_name, GROUP_CONCAT(tag.tag_name SEPARATOR ', ') AS tags
            FROM article
            LEFT JOIN employee ON article.employee_id = employee.employee_id
            LEFT JOIN article_tag ON article.article_id = article_tag.article_id
            LEFT JOIN tag ON article_tag.tag_id = tag.tag_id
            WHERE article.article_id = :article_id
            GROUP BY article.article_id
            ORDER BY CASE WHEN update_date IS NOT NULL THEN update_date ELSE insert_date END DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":article_id", $article_id, PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 記事情報を表示
    foreach ($articles as $article) {
      // 記事の画像を取得するクエリ
      $sql_image = "SELECT image_path FROM article_image WHERE article_id = :article_id";
      $stmt_image = $pdo->prepare($sql_image);
      $stmt_image->bindParam(":article_id", $article['article_id'], PDO::PARAM_INT);
      $stmt_image->execute();
      $image = $stmt_image->fetch(PDO::FETCH_ASSOC);
?>
      <article class="article-item">
        <h3 class="item-title"><?php echo htmlspecialchars($article['title']); ?></h3>
        <div class="article-detail">
          <p>著者：<?php echo html2str($article['employee_name'], ENT_QUOTES, 'UTF-8'); ?></p>
          <p>投稿日：<?php echo html2str($article['insert_date'], ENT_QUOTES, 'UTF-8'); ?></p>
          <?php if (htmlspecialchars($article['update_date'])) {
            echo "<p>更新日：" . html2str($article['update_date'], ENT_QUOTES, 'UTF-8') . "</p>";
          } ?>
          <p>タグ：<?php echo html2str($article['tags'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="item-img-wrapper">
          <img src="<?php echo html2str($image['image_path'] ?? '../img/default.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="記事の画像" />
        </div>
        <div class="article-text">
          <p><?php echo html2str($article['content'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      </article>
      <button class="read-more btn">
        <a href="contents.php">一覧に戻る</a>
      </button>
<?php
    }
  }
} catch (PDOException) {
  require_once __DIR__ . '/error.php';
  exit;
}
