$(document).ready(function () {
  function mediaQueriesWin() {
    //関数を呼ぶ
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

  // 初回読み込み時に動かす
  mediaQueriesWin();

  // ページがリサイズされたら動かす
  $(window).resize(function () {
    mediaQueriesWin();
  });
});
