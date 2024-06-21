// 記事追加フォームバリデーション処理
document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const errorClassNames = [
      ".validate-msg.title-error",
      ".validate-msg.content-error",
      ".validate-msg.employee-id-error",
      ".validate-msg.tag-error",
    ];

    const addForm = document.getElementById("addForm");

    addForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const title = document.getElementById("add-title").value.trim();
      const content = document.getElementById("add-content").value.trim();
      const employeeIdInputs = document.querySelectorAll(
        'input[name="employee_id"]:checked'
      );
      const tagInputs = document.querySelectorAll(
        'input[name="tag[]"]:checked'
      );

      // 各エラーメッセージのクリア
      errorClassNames.forEach(function (className) {
        document.querySelector(className).innerHTML = "";
      });

      let hasError = false;

      if (title === "" || title.length > 30) {
        document.querySelector(".validate-msg.title-error").innerHTML =
          "タイトルは必須かつ、30文字までです。";
        hasError = true;
        return;
      }

      if (content === "" || content.length > 2000) {
        document.querySelector(".validate-msg.content-error").innerHTML =
          "本文は必須かつ、2000文字までです。";
        hasError = true;
        return;
      }

      if (employeeIdInputs.length === 0) {
        document.querySelector(".validate-msg.employee-id-error").innerHTML =
          "あなたの名前を選択してください";
        hasError = true;
        return;
      }

      if (tagInputs.length === 0) {
        document.querySelector(".validate-msg.tag-error").innerHTML =
          "適切なタグを1つ以上選択してください";
        hasError = true;
        return;
      }

      if (!hasError) {
        this.submit();
      }
    });
  })();
});
