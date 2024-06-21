// 記事更新フォームのバリデーション処理
document.addEventListener("DOMContentLoaded", function () {
  const errorClassNames = [
    ".validate-msg.edit-title-error",
    ".validate-msg.edit-content-error",
    ".validate-msg.edit-tag-error",
  ];

  const editForm = document.getElementById("editForm");

  editForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const title = document.getElementById("edit-title").value.trim();
    const content = document.getElementById("edit-content").value.trim();
    const tagInputs = document.querySelectorAll('input[name="tag[]"]:checked');

    errorClassNames.forEach(function (className) {
      document.querySelector(className).innerHTML = "";
    });

    let hasError = false;

    if (title === "" || title.length > 30) {
      document.querySelector(".validate-msg.edit-title-error").innerHTML =
        "タイトルは必須かつ、30文字までです。";
      hasError = true;
    }

    if (content === "" || content.length > 2000) {
      document.querySelector(".validate-msg.edit-content-error").innerHTML =
        "本文は必須かつ、2000文字までです。";
      hasError = true;
    }

    if (tagInputs.length === 0) {
      document.querySelector(".validate-msg.edit-tag-error").innerHTML =
        "適切なタグを1つ以上選択してください";
      hasError = true;
    }

    if (hasError) {
      return;
    }

    this.submit();
  });
});
