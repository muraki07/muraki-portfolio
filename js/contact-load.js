// 問い合わせフォームの送信処理
(function () {
  const errorClassNames = [
    ".validate-msg.nameError",
    ".validate-msg.emailError",
    ".validate-msg.messageError",
  ];

  $("#contact-form").submit(function (event) {
    event.preventDefault();

    const user_name = $("#user-name").val().trim();
    const user_email = $("#user-email").val().trim();
    const message = $("#message").val().trim();

    errorClassNames.forEach(function (className) {
      $(className).html("");
    });

    if (user_name === "") {
      $(".validate-msg").html("お名前をご入力ください。");
      return;
    }

    if (
      user_email === "" ||
      !/^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/.test(
        user_email
      )
    ) {
      $(".validate-msg").html("メールアドレスを正しくご入力ください。");
      return;
    }

    if (message === "") {
      $(".validate-msg").html("お問い合わせ内容をご入力ください。");
      return;
    }

    const form_data = new FormData(this);

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: form_data,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      },
      success: function (response) {
        if (response.success) {
          $.ajax({
            type: "POST",
            url: "submit.php",
            dataType: "json",
            beforeSend: function (xhr) {
              $(".submit-btn").prop("disabled", true);
              $(".submit-message").html("送信中です。しばらくお待ちください。");
              xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            },
            success: function (submitResponse) {
              if (submitResponse.success) {
                $(".submit-message").html(submitResponse.successText);
              } else {
                $("#validate-msg").html(submitResponse.errorText);
              }
            },
            error: function () {
              $("#validate-msg").html(
                "エラーが発生したため、送信できませんでした。お手数おかけしますが、フォーム上に記載されているメールアドレス宛てにお問い合わせください。"
              );
            },
            complete: function () {
              // リクエスト完了後にフォームのリセット＆ボタンを有効化
              $(".submit-btn").prop("disabled", false);
              $("#contact-form")[0].reset();
            },
          });
        } else {
          $("#validate-msg").html(response.errorMessage);
        }
      },
      error: function () {
        $("#validate-msg").html(
          "エラー発生のため、送信できませんでした。お手数おかけしますが、メールにてお問い合わせください。"
        );
      },
    });
  });
})();
