<?php
// サーバサイド：問い合わせフォーム送信処理
session_start();
require_once __DIR__ . '/../functions.php';

$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$message = $_SESSION['message'];

date_default_timezone_set('Asia/Tokyo');

mb_language("ja");
mb_internal_encoding("UTF-8");

// SMTP認証情報(Gmail)
$smtp_username = 'silentadventure.contact@gmail.com';
$smtp_password = 'rhypkmpeaybszuoj';
$smtp_server = 'smtp.gmail.com';
$smtp_port = '587';

// ヘッダー情報
$header = "MIME-Version: 1.3\r\n";
$header .= "From: Silent Adventure <silentadventure.contact@gmail.com>\r\n";
$header .= "Reply-To: Silent Adventure <silentadventure.contact@gmail.com>\r\n";
$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
$header .= "Content-Transfer-Encoding: 8bit\r\n";

// 自動返信メール件名
$reply_subject = "お問い合わせいただきありがとうございます";

// 自動返信メール本文
$reply_text = "下記の内容の通り、お問い合わせを受け付けました。3営業日以内にご返信させていただきます。しばらくお待ちいただけますようお願い申し上げます" . "\n\n";
$reply_text .= "お問い合わせ受付日時：" . date('Y-m-d H:i') . "\n";
$reply_text .= "お名前：" . $user_name . "\n";
$reply_text .= "メールアドレス：" . $user_email . "\n";
$reply_text .= "お問い合わせ内容：" . $message . "\n\n";
$reply_text .= "Silent Adventure管理担当者";

// 自動通知メール件名
$notice_subject = "ホームページからメッセージがありました";

// 自動通知メール本文
$notice_text = "下記の内容でお問い合わせを受け付けました。" . "\n\n";
$notice_text .= "お問い合わせ受付日時：" . date('Y-m-d H:i') . "\n";
$notice_text .= "お名前：" . $user_name . "\n";
$notice_text .= "メールアドレス：" . $user_email . "\n";
$notice_text .= "お問い合わせ内容：" . $message . "\n";

if (mb_send_mail($user_email, $reply_subject, $reply_text, $header) && mb_send_mail('silentadventure.contact@gmail.com', $notice_subject, $notice_text, $header)) {
  unset($user_name);
  unset($user_email);
  unset($message);
  $submitResponse = array(
    "success" => true,
    "successText" => "送信が完了しました。お問い合わせいただきありがとうございました。"
  );
} else {
  $submitResponse = array(
    "success" => false,
    "errorText" => "申し訳ございません。エラー発生のため、フォームを送信できませんでした。<br>お手数おかけしますが、こちらのメールアドレスからお問い合わせください。<a class='address-text text' href='mailto:silentadventure.contact@gmail.com?subject=お問い合わせ'>silentadventure.contact@gmail.com</a>"
  );
}
echo json_encode($submitResponse);
exit;
