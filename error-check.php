<?php
require_once __DIR__ . '/../../functions.php';

if (empty($esc['title'])) {
  echo "<p class='text'>タイトルを入力してください</p>";
  exit;
}
if (!preg_match('/\A[[:^cntrl:]]{1,30}\z/u', $esc['title'])) {
  echo "<p class='text'>タイトルを30文字までにしてください</p>";
  exit;
}
if (empty($esc['content'])) {
  echo "<p class='text'>本文を入力してください</p>";
  exit;
}
$content = $esc['content'];
if (mb_strlen($content) > 2000) {
  echo "<p class='text'>本文を2000文字までにしてください</p>";
  exit;
}
if (empty($esc['employee_id'])) {
  echo "<p class='text'>あなたの名前を選択してください</p>";
  exit;
}
if (empty($esc['tag'])) {
  echo "<p class='text'>適切なタグを1つ以上選択してください</p>";
  exit;
}
