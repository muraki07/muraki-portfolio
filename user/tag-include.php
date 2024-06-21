<?php
// タグ別記事一覧ページの内容
require_once __DIR__ . '/../functions.php';

// ページネーション
$articles_per_page = 6; // 1ページに表示する記事の数
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 現在のページ番号
$start_index = ($current_page - 1) * $articles_per_page; // ページの開始インデックス

try {
  $pdo = db_open();

  // タグ(リンク)を取得
  if (isset($_GET['tag'])) {
    $tag = htmlspecialchars($_GET['tag']);

    // 該当するタグの記事数を取得
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM article
                                 INNER JOIN article_tag ON article.article_id = article_tag.article_id
                                 INNER JOIN tag ON article_tag.tag_id = tag.tag_id
                                 WHERE tag.tag_name = :tag");
    $stmt_count->bindParam(':tag', $tag, PDO::PARAM_STR);
    $stmt_count->execute();
    $total_articles = $stmt_count->fetchColumn();

    // 総ページ数を計算
    $total_pages = ceil($total_articles / $articles_per_page);

    // 該当するタグの記事を取得
    $stmt = $pdo->prepare("SELECT article.article_id, title, SUBSTRING(content, 1, 100) AS content, insert_date, update_date, employee.employee_name, GROUP_CONCAT(tag.tag_name SEPARATOR ', ') AS tags
                           FROM article
                           LEFT JOIN employee ON article.employee_id = employee.employee_id
                           LEFT JOIN article_tag ON article.article_id = article_tag.article_id
                           LEFT JOIN tag ON article_tag.tag_id = tag.tag_id
                           WHERE tag.tag_name = :tag
                           GROUP BY article.article_id
                           ORDER BY CASE WHEN update_date IS NOT NULL THEN update_date ELSE insert_date END DESC
                           LIMIT :start_index, :articles_per_page");
    $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
    $stmt->bindParam(':start_index', $start_index, PDO::PARAM_INT);
    $stmt->bindParam(':articles_per_page', $articles_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $articles = []; // タグが指定されていない場合は空の配列を代入
    $total_pages = 1; // タグが指定されていない場合は1ページのみ
  } ?>

  <article class="article-contents">
    <?php
    // タグタイトル表示
    $tag_name = isset($_GET['tag']) ? htmlspecialchars($_GET['tag']) : '';
    $title = html2str($tag_name, ENT_QUOTES, 'UTF-8');
    echo "<h2 class='article-title'>{$title}</h2>";
    ?>

    <aside class="tag-wrapper">
      <h2 class="tag-title">記事タグ</h2>
      <ul class="tag-list">
        <li><a href="tag.php?tag=<?php echo urlencode('#国内'); ?>"><?php echo '#国内'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#海外'); ?>"><?php echo '#海外'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#体験談'); ?>"><?php echo '#体験談'; ?></a></li>
        <li><a href="tag.php?tag=<?php echo urlencode('#配慮状況'); ?>"><?php echo '#配慮状況'; ?></a></li>
      </ul>
    </aside>

    <ul class="item-wrapper">
      <?php foreach ($articles as $article) {
        // 記事の画像を取得
        $sql_image = "SELECT image_path FROM article_image WHERE article_id = :article_id";
        $stmt_image = $pdo->prepare($sql_image);
        $stmt_image->bindParam(":article_id", ($article['article_id']), PDO::PARAM_INT);
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
            <p>タグ：<?php
                  // 記事に関連するすべてのタグを取得
                  $tag_sql = "SELECT tag_name FROM tag INNER JOIN article_tag ON tag.tag_id = article_tag.tag_id WHERE article_tag.article_id = :article_id";
                  $tag_stmt = $pdo->prepare($tag_sql);
                  $tag_stmt->bindParam(":article_id", ($article['article_id']), PDO::PARAM_INT);
                  $tag_stmt->execute();
                  $tags = $tag_stmt->fetchAll(PDO::FETCH_COLUMN);
                  echo implode(', ', $tags);
                  ?>
            </p>
            <p><?php echo html2str($article['content'], ENT_QUOTES, 'UTF-8'); ?>...</p>
          </a>
        </li>
      <?php } ?>
    </ul>

    <!-- ページネーション -->
    <div class="pagination">
      <p><?php echo '全件数:' . $total_articles . '件'; ?></p>
      <ul class="page">
        <?php if ($total_pages > 1 && $current_page > 1) : ?>
          <li><a href="?page=<?php echo $current_page - 1; ?><?php if (isset($_GET['tag'])) echo "&tag=" . urlencode($_GET['tag']); ?>">前へ</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li>
            <?php if ($i == $current_page) : ?>
              <span class="current-page"><?php echo $i; ?></span>
            <?php else : ?>
              <a href="?page=<?php echo $i; ?><?php if (isset($_GET['tag'])) echo "&tag=" . urlencode($_GET['tag']); ?>"><?php echo $i; ?></a>
            <?php endif; ?>
          </li>
        <?php endfor; ?>

        <?php if ($total_pages > 1 && $current_page < $total_pages) : ?>
          <li><a href="?page=<?php echo $current_page + 1; ?><?php if (isset($_GET['tag'])) echo "&tag=" . urlencode($_GET['tag']); ?>">次へ</a></li>
        <?php endif; ?>
      </ul>
      <?php if ($total_pages > 1) : ?>
        <p><?php echo $current_page; ?>/<?php echo $total_pages; ?></p>
      <?php else : ?>
        <p>1/1</p>
      <?php endif; ?>
    </div>
  </article>
<?php
} catch (PDOException) {
  require_once __DIR__ . '/error.php';
  exit;
}
