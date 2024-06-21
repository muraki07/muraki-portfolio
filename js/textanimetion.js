// サイトコンセプトのアニメーション
// テキスト要素を取得
const textElements = document.querySelectorAll(".concept-title, .concept-text");

function handleScroll() {
  textElements.forEach(function (element) {
    const elementPosition = element.getBoundingClientRect().top;

    // ウィンドウの高さの80%の位置に達した場合、テキストを表示
    if (elementPosition - window.innerHeight <= -window.innerHeight * 0.1) {
      element.style.opacity = "1";
    }
  });
}

window.addEventListener("scroll", handleScroll);
