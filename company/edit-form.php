<?php
// 記事更新フォーム
require_once __DIR__ . '/../functions.php';

if (empty(htmlspecialchars($_GET['id']))) {
  echo "<p class='text'>idを指定してください</p>";
  exit;
}
if (!preg_match('/\A\d{1,3}+\z/u', htmlspecialchars($_GET['id']))) {
  echo "<p class='text'>idは必須かつ、3桁までの数字で入力してください</p>";
  exit;
}
$id = (int) htmlspecialchars($_GET['id']);

$pdo = db_open();

// タグ以外の対象IDのデータをデータベースから取得する
$sql = 'SELECT article.article_id, title, content, article.employee_id, GROUP_CONCAT(tag.tag_name) AS tags, article_image.image_path AS image_path 
FROM article 
LEFT JOIN article_tag ON article.article_id = article_tag.article_id 
LEFT JOIN tag ON article_tag.tag_id = tag.tag_id 
LEFT JOIN employee ON article.employee_id = employee.employee_id 
LEFT JOIN article_image ON article.article_id = article_image.article_id
WHERE article.article_id = :article_id 
GROUP BY article.article_id
';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':article_id', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result) {
  echo "<p class='text'>指定したデータが見つかりません</p>";
  exit;
}

// 投稿者名の一覧を取得
$sql_employee_name = "SELECT employee_id, employee_name FROM employee";
$stmt_employee_name = $pdo->query($sql_employee_name);
$all_employee_name = $stmt_employee_name->fetchAll(PDO::FETCH_ASSOC);
if (!$all_employee_name) {
  echo "<p class='text'>指定したデータが見つかりません</p>";
  exit;
}

// タグの一覧を取得
$sql_tags = "SELECT tag_name FROM tag";
$stmt_tags = $pdo->query($sql_tags);
$all_tags = $stmt_tags->fetchAll(PDO::FETCH_COLUMN);
if (!$all_tags) {
  echo "<p class='text'>指定したデータが見つかりません</p>";
  exit;
}

// 取得したデータをフォームに配置
$title = htmlspecialchars($result['title']);
$content = htmlspecialchars($result['content']);
$id = htmlspecialchars($result['article_id']);
$image_path = htmlspecialchars($result['image_path']) ? htmlspecialchars($result['image_path']) : '../img/default.jpg';
$tags = explode(',', htmlspecialchars($result['tags']));
$employees = htmlspecialchars($result['employee_id']); ?>

<form id="editForm" action="update.php" method="post" enctype="multipart/form-data">
  <p>
    <label for="title">タイトル（30文字まで）:</label>
    <input id="edit-title" type="text" name="title" value="<?php echo $title; ?>" size="65" maxlength="30">
  </p>
  <p>
    <label for="content">内容（2000文字まで）:</label>
    <textarea id="edit-content" name="content" cols="75" rows="18" maxlength="2000"><?php echo $content; ?></textarea>
  <div class="char-count">残り文字数:<span class="count">2000</span>（文字数には、改行やスペースも含まれます。入力を始めると、カウントされます。）</div>
  </p>
  <p>
    <label for="employee_id">投稿者:</label>
    <?php
    foreach ($all_employee_name as $employee) {
      $employee_id = $employee['employee_id'];
      $employee_name = $employee['employee_name'];
      $checked = ($employee_id == $result['employee_id']) ? 'checked' : '';
      echo "<input class='employee-id' type='radio' name='employee_id' value='$employee_id' $checked> $employee_name<br>";
    }
    ?>
  </p>
  <p>
    <label for='tag'>タグ名:</label>
    <?php
    foreach ($all_tags as $tag) {
      $checked = in_array($tag, $tags) ? 'checked' : '';
      echo "<input class='tag' type='checkbox' name='tag[]' value='$tag' $checked> $tag<br>";
    }
    ?>
  </p>
  <?php
  if (!empty($image_path)) {
    echo "<p><label for='current_img'>現在の画像:</label>";
    echo "<img id='current-img' src='$image_path' alt='現在の画像'><br></p>";
  }
  ?>
  <p class="new-img">
    <label for='imageUpload'>新しい画像:</label>
  <p class="new-img-wrapper">
    <input type="file" id="imageUpload" name="image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)" />
    <img id="imagePreview" src="#" alt="" />
  </p>
  </p>
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>">
  <p id="validate_msg" class="validate-msg edit-title-error edit-content-error edit-tag-error"></p>
  <p>
    <input class="edit-form-btn btn" type="submit" value="更新する" />
  </p>
</form>