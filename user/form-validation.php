<?php
// 問い合わせフォームのバリデーション処理
session_start();
require_once __DIR__ . '/../functions.php';

$_SESSION['user_name'] = $esc['user_name'];
$_SESSION['user_email'] = $esc['user_email'];
$_SESSION['message'] = $esc['message'];

$errors = array();

if (empty($_SESSION['user_name'])) {
  $errors[] = "お名前をご入力ください";
}

if (empty($_SESSION['user_email']) && !filter_var($_SESSION['user_email'], FILTER_VALIDATE_EMAIL)) {
  $errors[] = "メールアドレスをご入力ください";
}

if (empty($_SESSION['message'])) {
  $errors[] = "メッセージをご入力ください";
}

if (empty($errors)) {
  $response = array("success" => true);
} else {
  $response = array("success" => false, "errors" => $errors);
}

echo json_encode($response);
exit;
