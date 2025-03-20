<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forget Password</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <style>
    body {
      background-color: black;
      color: white;
      font-family: 'Montserrat', sans-serif;
      margin-top: 100px;
    }

    .loginholder {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      color: black;
    }

    .inputbox {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .btn-normal {
      background-color: red;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-normal:hover {
      background-color: darkred;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }
  </style>
</head>

<body>
  <h2 style="margin-top: 0; text-align:center">Reset Password</h2>
  <div class="container" style="margin-top: 20px;">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="loginholder">
          <a href="./index.html" style="text-decoration: none;">
            <h1 style="color: white; background-color:red; text-align: center;">Entertainease</h1>
          </a>
          <form id="forgetPasswordForm">
            <div class="form-group">
              <label for="email" style="font-size: 17px;">Email Id:</label>
              <input type="text" class="inputbox" id="email" style="font-size: 14px;" />
              <p id="emailerror" class="error"></p>
            </div>
            <div class="form-group">
              <label for="newpassword" style="font-size: 17px;">New Password:</label>
              <input type="password" class="inputbox" id="newpassword" style="font-size: 14px;" />
              <p id="newpassworderror" class="error"></p>
            </div>
            <div class="form-group">
              <label for="cpassword" style="font-size: 17px;">Confirm Password:</label>
              <input type="password" class="inputbox" id="cpassword" style="font-size: 14px;" />
              <p id="cpassworderror" class="error"></p>
            </div>
            <div id="msg" class="error"></div>
            <div id="successmsg" class="success" style="font-size: 17px;"></div>
            <div class="form-group text-center">
              <button type="button" class="btn-normal" id="login" style="font-size: 17px;">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#login").click(function () {
        var email = $("#email").val().trim();
        var newpassword = $("#newpassword").val().trim();
        var cpassword = $("#cpassword").val().trim();
        var error = "";

        if (email == "") {
          error = "Email is required.";
          $("#emailerror").html(error);
          return false;
        } else {
          $("#emailerror").html("");
        }

        if (newpassword == "") {
          error = "New password is required.";
          $("#newpassworderror").html(error);
          return false;
        } else {
          $("#newpassworderror").html("");
        }

        if (cpassword == "") {
          error = "Confirm password is required.";
          $("#cpassworderror").html(error);
          return false;
        } else {
          $("#cpassworderror").html("");
        }

        if (cpassword != newpassword) {
          error = "Passwords do not match.";
          $("#cpassworderror").html(error);
          return false;
        } else {
          $("#cpassworderror").html("");
        }

        $.ajax({
          url: 'forget.php',
          type: 'post',
          data: {
            email: email,
            newpassword: newpassword
          },
          success: function (response) {
            if (response == 1) {
              $("#successmsg").html("Password changed successfully. Redirecting to login_form page...");
              setTimeout(function () {
                window.location = "login_form.php";
              }, 5000);
            } else {
              error = "Invalid UserId.";
              $("#msg").html(error);
              return false;
            }
          }
        });
      });
    });
  </script>
</body>

</html>