// 記事画像のプレビュー
function previewImage(event) {
  var input = event.target;
  var preview = document.getElementById("imagePreview");
  var reader = new FileReader();

  reader.onload = function () {
    preview.src = reader.result;
  };

  reader.readAsDataURL(input.files[0]); // 選択されたファイルの読み込み
}
