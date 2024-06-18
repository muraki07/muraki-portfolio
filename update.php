<!-- サーバサイド：更新処理 -->
<?php
require_once __DIR__ . '/../functions.php';
include __DIR__ . '/inc/error-check.php';
include __DIR__ . '/inc/header.php';

$pdo = db_open();
if (empty($esc['id'])) {
  echo "<p class='text'>idを指定してください</p>";
  exit;
}
if (!preg_match('/\A\d{1,3}+\z/u', $esc['id'])) {
  echo "<p class='text'>idは必須かつ、3桁までの数字で入力してください</p>";
  exit;
}

try {

  $id = $esc['id'];
  $title = $esc['title'];
  $employee_id = $esc['employee_id'];
  $tags = $esc['tag'];

  // 画像のアップロード処理が成功した場合のみ実行
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../img/';
    $uploaded_file = $upload_dir . basename($_FILES['image']['name']); // 画像ファイルのパス

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
      // 既存の画像があるかどうかのチェック
      $sql_check_image = "SELECT COUNT(*) FROM article_image WHERE article_id = :article_id";
      $stmt_check_image = $pdo->prepare($sql_check_image);
      $stmt_check_image->bindParam(":article_id", $id, PDO::PARAM_INT);
      $stmt_check_image->execute();
      $image_count = $stmt_check_image->fetchColumn();

      // 既存の画像がある場合
      if ($image_count > 0) {
        $updated_image_path = $uploaded_file;
        $sql_update_image = "UPDATE article_image SET image_path = :image_path WHERE article_id = :article_id";
        $stmt_update_image = $pdo->prepare($sql_update_image);
        $stmt_update_image->bindParam(":image_path", $updated_image_path, PDO::PARAM_STR);
        $stmt_update_image->bindParam(":article_id", $id, PDO::PARAM_INT);
        $stmt_update_image->execute();
      } else { // 既存の画像がない場合
        $sql_add_image = "INSERT INTO article_image (article_id, image_path) VALUES (:article_id, :image_path)";
        $stmt_add_image = $pdo->prepare($sql_add_image);
        $stmt_add_image->bindParam(":article_id", $id, PDO::PARAM_INT);
        $stmt_add_image->bindParam(":image_path", $uploaded_file, PDO::PARAM_STR);
        $stmt_add_image->execute();
      }
    } else {
      echo "<p class='text'>画像のアップロードに失敗しました。</p>";
    }
  }

  // 本文とタイトルの更新処理
  $sql_update_article = "UPDATE article SET title = :title, content = :content, employee_id = :employee_id WHERE article_id = :id";
  $stmt_update_article = $pdo->prepare($sql_update_article);
  $stmt_update_article->bindParam(":title", $title, PDO::PARAM_STR);
  $stmt_update_article->bindParam(":content", $content, PDO::PARAM_STR);
  $stmt_update_article->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
  $stmt_update_article->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt_update_article->execute();

  // タグの削除と追加処理
  $sql_delete_tags = "DELETE FROM article_tag WHERE article_id = :article_id";
  $stmt_delete_tags = $pdo->prepare($sql_delete_tags);
  $stmt_delete_tags->bindParam(":article_id", $id, PDO::PARAM_INT);
  $stmt_delete_tags->execute();

  foreach ($tags as $tag) {
    $sql_add_tag = "INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, (SELECT tag_id FROM tag WHERE tag_name = :tag_name))";
    $stmt_add_tag = $pdo->prepare($sql_add_tag);
    $stmt_add_tag->bindParam(":article_id", $id, PDO::PARAM_INT);
    $stmt_add_tag->bindParam(":tag_name", $tag, PDO::PARAM_STR);
    $stmt_add_tag->execute();
  }

  echo "<p class='text'>記事が更新されました。</p>";
  echo "<button class='btn'><a href='article.php'>一覧へ戻る</a></button>";
} catch (PDOException $e) {
  echo $e->getMessage() . "<br>";
  echo "<p class='text'>エラーが起きたため、記事を更新できませんでした。</p>";
  exit;
}

include __DIR__ . '/inc/footer.php';
echo "</body>";

echo "</html>";
