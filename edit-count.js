// 記事更新ページの文字数カウント
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

// 初期表示時にカウントを実行する
countCharacters();

// 入力時にカウントを更新するイベントリスナー
editTextarea.addEventListener("input", countCharacters);
