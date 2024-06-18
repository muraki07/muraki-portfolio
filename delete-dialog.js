// 記事削除時の確認ダイアログボックス
document.querySelectorAll(".delete-btn").forEach(function (element) {
  element.addEventListener("click", function () {
    if (confirm("本当にこの記事を削除しますか？")) {
      var article_id = element.getAttribute("data-article-id");
      var url = "delete.php?id=" + article_id;
      var xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader(
        "content-type",
        "application/x-www-form-urlencoded;charset=UTF-8"
      );
      xhr.send();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = xhr.responseText;
          if (response === "success") {
            alert("削除に成功しました。");
            window.location.href = "article.php";
          } else {
            alert("削除に失敗しました。再度お試しください。");
          }
        }
      };
    }
  });
});
