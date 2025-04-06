<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/jpg" href="img/logo.jpg">
  <title>Entertainease</title>
  <link rel="stylesheet" href="css/register.css">
  <script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background-repeat: no-repeat; background-image: url(img/bg.png); background-size: cover;">
  <div class="container">
    <center><a href="./index.html"><img src="img/logo.png" alt="" style="margin-top: 80px; width: 50%;"></a></center>
    <div class="title" style="text-align: center; color: white; background-color:red">register on<br> Entertainease 🎥</div>
    <div class="content">
      <form id="form" action="register.php" method="post" enctype="multipart/form-data" onsubmit="return validate();">
        <div id="errorDiv" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 1000;"></div>
        <div class="user-details">
          <div class="input-box">
            <span class="details">UserName</span>
            <input type="text" id="username" name="username" placeholder="Enter your name">
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" id="email" name="email" placeholder="Enter your Email">
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <div style="display: flex;">
              <select id="countryCode" name="countryCode" style="width: 30%;">
                <option value="+1">+1</option>
                <option value="+91">+91</option>
                <option value="+44">+44</option>
                <!-- Add more country codes as needed -->
                <option value="+61">+61</option>
                <option value="+81">+81</option>
                <option value="+86">+86</option>
                <option value="+49">+49</option>
                <option value="+33">+33</option>
                <option value="+39">+39</option>
                <option value="+7">+7</option>
                <option value="+34">+34</option>
                <option value="+55">+55</option>
                <option value="+27">+27</option>
                <option value="+82">+82</option>
                <option value="+31">+31</option>
                <option value="+64">+64</option>
                <option value="+47">+47</option>
                <option value="+46">+46</option>
                <option value="+41">+41</option>
                <option value="+90">+90</option>
                <option value="+971">+971</option>
              </select>
              <input type="number" id="number" name="number" placeholder="Enter your Phone Number" style="width: 70%;">
            </div>
          </div>
          <div class="input-box">
            <span class="details">City</span>
            <input type="text" id="city" name="city" placeholder="Enter your City">
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" id="password" name="password" placeholder="Enter your password">
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your password">
          </div>
          <div class="input-box">
            <span class="details">Upload user picture (optional)</span>
            <input type="file" id="image" name="image">
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Register" id="submit" name="submit">
        </div>
      </form>
    </div>
  </div>
  <script type="text/javascript">
    function validate() {
      var error = "";
      var name = document.getElementById("username");
      var email = document.getElementById("email");
      var number = document.getElementById("number");
      var city = document.getElementById("city");
      var password = document.getElementById("password");
      var cpassword = document.getElementById("cpassword");
      var errorDiv = document.getElementById("errorDiv");

      if (name.value == '' && email.value == '' && number.value == '' && city.value == '' && password.value == '' && cpassword.value == '') {
        error = 'All fields are empty! Please fill in the required information.';
        showError(error);
        return false;
      }

      if (name.value == "") {
        error = "Name Required";
        showError(error);
        return false;
      }
      if (name.value.length < 2 || name.value.length > 30) {
        error = "Characters are allowed only from 2 to 30";
        showError(error);
        return false;
      }
      if (!isNaN(name.value)) {
        error = "Only Characters allowed";
        showError(error);
        return false;
      }

      if (email.value == "") {
        error = "Required Email";
        showError(error);
        return false;
      }
      if (email.value.indexOf('@') <= 0) {
        error = "@ invalid position";
        showError(error);
        return false;
      }
      if ((email.value.charAt(email.value.length - 4) != '.') && (email.value.charAt(email.value.length - 3) != '.')) {
        error = ". invalid position";
        showError(error);
        return false;
      }

      if (number.value == "") {
        error = "Number Required";
        showError(error);
        return false;
      }
      if (number.value.length != 10) {
        error = "Please Enter only 10 digits";
        showError(error);
        return false;
      }
      if (isNaN(number.value)) {
        error = "Only numbers are allowed!";
        showError(error);
        return false;
      }

      if (city.value == "") {
        error = "City Required";
        showError(error);
        return false;
      }

      if (password.value == "") {
        error = "Password Required";
        showError(error);
        return false;
      }
      if (password.value.length < 8) {
        error = "Password must be at least 8 characters long";
        showError(error);
        return false;
      }
      if (!/[a-z]/.test(password.value) || !/[A-Z]/.test(password.value) || !/[0-9]/.test(password.value)) {
        error = "Password must contain at least one lowercase letter, one uppercase letter, and one number";
        showError(error);
        return false;
      }

      if (cpassword.value == "") {
        error = "Confirm Password Required";
        showError(error);
        return false;
      }
      if (cpassword.value != password.value) {
        error = "Confirm Password Not Matched";
        showError(error);
        return false;
      }

      return true;
    }

    function showError(error) {
      var errorDiv = document.getElementById("errorDiv");
      errorDiv.innerHTML = error;
      errorDiv.style.display = 'block';
      setTimeout(() => {
        errorDiv.style.display = 'none';
      }, 4000);
    }
  </script>
</body>
</html>