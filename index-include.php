<!-- トップページ　記事一覧部分 -->
<?php
require_once __DIR__ . '/../functions.php';

try {
  $pdo = db_open();

  $sql = "SELECT article.article_id, title, SUBSTRING(content, 1, 100) AS content, insert_date, update_date, employee.employee_name, GROUP_CONCAT(tag.tag_name SEPARATOR ', ') AS tags
            FROM article
            LEFT JOIN employee ON article.employee_id = employee.employee_id
            LEFT JOIN article_tag ON article.article_id = article_tag.article_id
            LEFT JOIN tag ON article_tag.tag_id = tag.tag_id
            GROUP BY article.article_id
            ORDER BY CASE WHEN update_date IS NOT NULL THEN update_date ELSE insert_date END DESC
            LIMIT 6";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // 記事情報の表示
  foreach ($articles as $article) {
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
<?php }
} catch (PDOException) {
  require_once __DIR__ . '/error.php';
  exit;
}
?>
</ul>
</article>