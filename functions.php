<?php
// エスケープ
$esc = array();
if (!empty($_POST)) {
  foreach ($_POST as $key => $value) {
    if (is_array($value)) {
      foreach ($value as $sub_key => $sub_value) {
        $esc[$key][$sub_key] = htmlspecialchars($sub_value);
      }
    } else {
      $esc[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
  }
}

// デコード
function html2str(string $string): string
{
  return htmlspecialchars_decode(nl2br($string, ENT_QUOTES));
}

//データベースへの接続
function db_open(): PDO
{
  try {
    $db_host = $_SERVER['DB_HOST'];
    $db_user = $_SERVER['DB_USER'];
    $db_password = $_SERVER['DB_PASSWORD'];
    $db_database = $_SERVER['DB_DATABASE'];

    $dsh = "mysql:host=$db_host;dbname=$db_database;charset=utf8mb4";
    $opt = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    $pdo = new PDO($dsh, $db_user, $db_password, $opt);
    return $pdo;
  } catch (PDOException) {
    echo "<p class='text'>申し訳ございませんが、エラーが発生したため、ページを表示できません。<br>しばらくしてから再度お試しください。<br>もし問題が解決しない場合には、管理者にご連絡ください。";
    exit;
  }
}
