// ハンバーガーメニュー
$(document).ready(function () {
  function mediaQueriesWin() {
    var width = $(window).width();
    if (width <= 961) {
      $(".hamburger-menu").off("click");
      $(".hamburger-menu").on("click", function () {
        $("#header, .hamburger-menu, .nav").toggleClass("active");
      });
    } else {
      $(".hamburger-menu").off("click");
      $("#nav-content").css("display", "");
    }
  }

  mediaQueriesWin();

  // ページがリサイズされたら動かす
  $(window).resize(function () {
    mediaQueriesWin();
  });
});
