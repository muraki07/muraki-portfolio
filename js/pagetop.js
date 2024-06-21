// ページトップリンクボタン
$(function () {
  $("#js-page-top").click(function () {
    $("html, body").animate(
      {
        scrollTop: 0, //ページ表示時には非表示にする
      },
      {
        duration: 400,
      }
    );
  });
  $(window).scroll(function () {
    if ($(window).scrollTop() > 1) {
      //スクロールが開始されたら表示
      $("#js-page-top").fadeIn(200).css("display", "flex");
    } else {
      $("#js-page-top").fadeOut(200);
    }
  });
});
