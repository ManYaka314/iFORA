$("#feed").on("click", function () {
  var name = $("#name").val().trim();
  var email = $("#email").val().trim();
  var date = $("#date").val().trim();
  var time = $("#time").val().trim();

  var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;

  if (name == "") {
    $("#error").text("Пожалуйста, введите Ваши ФИО");
    return false;
  } else if (email == "") {
    $("#error").text("Пожалуйста, введите Ваш Email");
    return false;
  } else if (email.search(pattern) != 0) {
    $("#error").text("Вы ввели некорректный Email");
    return false;
  } else if (date == "") {
    $("#error").text("Пожалуйста, укажите дату");
    return false;
  } else if (time == "") {
    $("#error").text("Пожалуйста, укажите время");
    return false;
  }

  $("#error").text("");

  $.ajax({
    url: "core/feedback.php",
    type: "POST",
    cache: false,
    data: { name: name, email: email, date: date, time: time },
    dataType: "html",
    beforeSend: function () {
      $("#feed").prop("disabled", true);
    },
    success: function (data) {
      if (!data) {
        alert("Ошибка! Сообщение не отправлено :(");
      } else {
        alert("Вы успешно записались!");
        $("#feedForm").trigger("reset");
      }
      $("#feed").prop("disabled", false);
    },
  });
});
