<?php
// サーバサイド：記事削除処理
require_once __DIR__ . '/../functions.php';

// GETパラメータから記事IDを取得
if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);

  // データベースから記事を削除
  $pdo = db_open();
  $pdo->beginTransaction();

  try {
    // article_imageテーブルから該当する記事IDのデータを削除
    $stmt_image = $pdo->prepare("DELETE FROM article_image WHERE article_id = ?");
    $stmt_image->execute([$id]);

    // articleテーブルから該当する記事IDのデータを削除
    $stmt_article = $pdo->prepare("DELETE FROM article WHERE article_id = ?");
    $stmt_article->execute([$id]);

    $pdo->commit();
    echo "success";
  } catch (PDOException $e) {
    $pdo->rollBack();
    echo "failure";
  }
};
