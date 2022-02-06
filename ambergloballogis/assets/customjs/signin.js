$(document).ready(function () {
  $(document).on("click", "#btn-signin", function (e) {
    e.preventDefault();

    var username = $("#username").val();

    var password = $("#password").val();

    if (username == "") {
      $("#div-alert").removeAttr("style");

      $("#alert-message").html("Please input username!");

      $("#username").focus();

      return;
    }

    if (password == "") {
      $("#div-alert").removeAttr("style");

      $("#alert-message").html("Please input password!");

      $("#password").focus();

      return;
    }

    $.ajax({
      url: "signin/user_login_process",

      type: "POST",

      dataType: "json",

      data: { username: username, password: password },

      success: function (response) {
        if (response.success == 1) {
          location.reload();
        } else if (response.success == 0) {
          $("#div-alert").removeAttr("style");

          $("#alert-message").html("Some errors happens! Please try again!");
        } else {
          $("#div-alert").removeAttr("style");

          $("#alert-message").html("Username or Password is invalid!");
        }
      },
    });
  });
});
