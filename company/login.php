<?php
session_start();
require_once __DIR__ . '/../functions.php';

$error_message = "<p class='initial-display'>ユーザ名、パスワードを入力してください。</p>";

if (!empty($_SESSION['login'])) {
  echo "ログイン済です<br>";
  echo "<a class='btn' href='article.php'>リストに戻る</a>";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($esc['username'])) {
    $error_message = "<p class='error-text'>ユーザ名を入力してください。</p>";
  } elseif (empty($esc['password'])) {
    $error_message = "<p class='error-text'>パスワードを入力してください。</p>";
  } else {
    try {
      $pdo = db_open();
      $sql = "SELECT password FROM employee WHERE username = :username";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":username", $esc['username'], PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
        // ユーザ名の不一致
        $error_message = "<p class='error-text'>ログインできませんでした。ユーザ名、パスワードが正しいことを確認してください。</p>";
      } elseif (password_verify($esc['password'], $result['password'])) {
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        header("Location: article.php");
        exit;
      } else {
        // PWの不一致
        $error_message = "<p class='error-text'>ログインできませんでした。ユーザ名、パスワードが正しいことを確認してください。</p>";
      }
    } catch (PDOException $e) {
      $error_message = "<p class='error-text'>エラーが発生したため、ログインできませんでした。管理者へ連絡してください。</p>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>-聴こえないひとのための一人旅情報-Silent Adventure</title>
  <meta name="description" content="『Silent Adventure』は、聴覚障害者の一人旅のための情報提供をしているWebサイトです。一人旅の不安払拭に繋がるような情報や、聴覚障害者の体験談をお伝えしています。" />
  <meta name="author" content="silentadventure" />
  <link rel="icon" href="../img/favicon.png" />
  <link rel="stylesheet" href="../css/sanitize.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/company.css" />
  <script src="../js/jquery-3.7.1.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
</head>

<body>
  <header id="header">
    <div class="header-logo"><img src="../img/logo.png" alt="silentadventure" /></div>
    <nav class="nav">
      <ul class="nohover-nav-list">
        <li>
          <p class="nav-ja">記事一覧</p>
          <p class="nav-en">ARTICLE</p>
        </li>
        <li>
          <p class="nav-ja">記事追加</p>
          <p class="nav-en">ADD ARTICLE</p>
        </li>
        <li>
          <p class="nav-ja">ログアウト</p>
          <p class="nav-en">LOGOUT</p>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="top-img fixed-bg">
      <h1 class="section-title">ログイン<br />LOGIN</h1>
    </div>

    <?php if (!empty($error_message)) : ?>
      <?php echo $error_message; ?>
    <?php endif; ?>

    <form id="loginForm" method='post' action=''>
      <p class="login-information">
        <label for="username">ユーザ名:</label>
        <input class='input text-field' type='text' name='username' id='username'>
      </p>
      <p class="login-information">
        <label for="password">パスワード:</label>
        <input class='input text-field' type='password' name='password' id='password'>
      </p>
      <input class='login-btn btn' type='submit' value='ログインする'>
    </form>

  </main>
</body>

</html>