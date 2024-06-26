// 記事追加フォーム文字数カウント処理
const addTextarea = document.getElementById("add-content");
const addCounters = document.querySelectorAll(".count");

addTextarea.addEventListener("input", function () {
  const maxLength = parseInt(addTextarea.getAttribute("maxlength"), 10);
  const currentLength = addTextarea.value.length;
  const remaining = maxLength - currentLength;

  addCounters.forEach(function (counter) {
    counter.textContent = remaining;
  });
});
