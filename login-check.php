<?php
session_start();
?>

<main>
  <?php
  if (empty($_SESSION['login'])) {
    echo "<p class='error-text'>このページにアクセスするには<a class='link' href='login.php'>ログイン</a>が必要です。</p>";
    exit;
  }
  ?>
</main>