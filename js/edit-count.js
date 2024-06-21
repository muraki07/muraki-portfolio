// 記事更新フォームの文字数カウント処理
const editTextarea = document.getElementById("edit-content");
const editCounters = document.querySelectorAll(".count");

// 初期表示時にカウントを行うための関数
function countCharacters() {
  const maxLength = parseInt(editTextarea.getAttribute("maxlength"), 10);
  const currentLength = editTextarea.value.length;
  const remaining = maxLength - currentLength;

  editCounters.forEach(function (counter) {
    counter.textContent = remaining;
  });
}

countCharacters();

// 入力時にカウントを更新する
editTextarea.addEventListener("input", countCharacters);
