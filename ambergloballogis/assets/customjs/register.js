$(document).ready(function () {
  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(email);
  }
  function isNumeric(value) {
    return /^-?\d+$/.test(value);
  }
  $("#goToLogin").bind("click", function () {
    location.href = "signin";
  });
  $("#goToSignin").bind("click", function () {
    location.href = "signin";
  });
  $(document).on("click", "#btn-save", function (e) {
    var username = $("#username").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var name = $("#name").val();
    // var custom_id	    = $('#custom_id').val();
    var contact_number = $("#contact_number").val();
    var company = $("#company").val();
    var country = $("#country").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var post_code = $("#post_code").val();
    var address = $("#address").val();

    if (username == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input username!");
      $("#username").focus();
      return;
    }
    if (!validateEmail(email)) {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input valid email address!");
      $("#email").focus();
      return;
    }
    if (password == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input password!");
      $("#password").focus();
      return;
    }
    if (name == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input name!");
      $("#name").focus();
      return;
    }
    if (!isNumeric(contact_number)) {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Contact number should be numeric!");
      $("#contact_number").focus();
      return;
    }
    if (company == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input company name!");
      $("#company").focus();
      return;
    }
    if (country == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input country!");
      $("#country").focus();
      return;
    }
    if (state == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input state!");
      $("#state").focus();
      return;
    }
    if (city == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input city!");
      $("#city").focus();
      return;
    }
    if (!isNumeric(post_code)) {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Postal code should be numeric!");
      $("#post_code").focus();
      return;
    }
    if (address == "") {
      $("#div-alert").removeAttr("style");
      $("#alert-message").html("Please input address!");
      $("#address").focus();
      return;
    }

    $.ajax({
      //url: "customers/create",
      url: "register/create",
      type: "POST",
      dataType: "json",
      data: {
        username: username,
        email: email,
        password: password,
        name: name,
        contact_number: contact_number,
        company: company,
        country: country,
        state: state,
        city: city,
        post_code: post_code,
        address: address,
      },
      success: function (response) {
        if (response.success == 1) {
          $("#form-customer").trigger("reset");
          $(".modal").modal("toggle");
        } else if (response.success == 0) {
          $("#div-alert").removeAttr("style");
          $("#alert-message").html("Some errors happens! Please try again!");
        } else {
          $("#div-alert").removeAttr("style");
          $("#alert-message").html("Duplicated username!");
          $("#username").focus();
        }
      },
    });
  });
});
