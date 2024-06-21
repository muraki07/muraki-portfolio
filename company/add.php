<?php
// サーバサイド：追加処理
require_once __DIR__ . '/login-check.php';
require_once __DIR__ . '/../functions.php';
include __DIR__ . '/inc/error-check.php';
include __DIR__ . '/inc/header.php';

$pdo = db_open();

// フォームから送信された社員IDを取得
$employee_id = $_POST['employee_id'];

try {
  // 記事をデータベースに挿入
  $sql_insert_article = "INSERT INTO article (title, content, employee_id) VALUES (:title, :content, :employee_id)";
  $stmt_insert_article = $pdo->prepare($sql_insert_article);
  $stmt_insert_article->bindParam(":title", $esc['title'], PDO::PARAM_STR);
  $stmt_insert_article->bindParam(":content", $esc['content'], PDO::PARAM_STR);
  $stmt_insert_article->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
  $stmt_insert_article->execute();

  // 挿入された記事のIDを取得
  $article_id = $pdo->lastInsertId();

  // 選択されたタグを中間テーブルに挿入
  foreach ($esc['tag'] as $tag) {
    // タグ名からタグIDを取得
    $sql_get_tag_id = "SELECT tag_id FROM tag WHERE tag_name = :tag_name";
    $stmt_get_tag_id = $pdo->prepare($sql_get_tag_id);
    $stmt_get_tag_id->bindParam(":tag_name", $tag, PDO::PARAM_STR);
    $stmt_get_tag_id->execute();
    $tag_id = $stmt_get_tag_id->fetch(PDO::FETCH_ASSOC)['tag_id'];

    // 中間テーブルに挿入(記事IDとタグID)
    $sql_insert_tag = "INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)";
    $stmt_insert_tag = $pdo->prepare($sql_insert_tag);
    $stmt_insert_tag->bindParam(":article_id", $article_id, PDO::PARAM_INT);
    $stmt_insert_tag->bindParam(":tag_id", $tag_id, PDO::PARAM_INT);
    $stmt_insert_tag->execute();

    if ($stmt_insert_tag->rowCount() == 0) {
      echo "<p class='text'>タグの挿入に失敗しました。</p>";
    }
  }

  // 画像のアップロード処理が成功した場合のみ実行
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // 画像がアップロードされた場合の処理
    $upload_dir = '../img/';
    $uploaded_file = $upload_dir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {

      // アップロードされた画像のデータを中間テーブルに挿入
      $sql_insert_image = "INSERT INTO article_image (article_id, image_path) VALUES (:article_id, :image_path)";
      $stmt_insert_image = $pdo->prepare($sql_insert_image);
      $stmt_insert_image->bindParam(":article_id", $article_id, PDO::PARAM_INT);
      $stmt_insert_image->bindParam(":image_path", $uploaded_file, PDO::PARAM_STR);
      $stmt_insert_image->execute();

      if ($stmt_insert_image->rowCount() == 0) {
        echo "<p class='text'>画像の挿入に失敗しました。</p>";
      }
    } else {
      echo "<p class='text'>画像のアップロードに失敗しました。</p><br>";
    }
  }

  echo "<p class='text'>記事が追加されました。</p>";
  echo "<button class='btn'><a href='article.php'>一覧へ戻る</a></button>";
} catch (PDOException $e) {
  echo "<p class='text'>エラーが起きたため、記事を追加できませんでした。担当者へ連絡してください。</p>";
}

include __DIR__ . '/inc/footer.php';
echo "</body>";

echo "</html>";

