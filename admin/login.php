<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="ajaxValidation.js"></script>
  <style type="text/css">
   
  </style>
</head>

<body>
  <div class="container col-5">
    <h1 style="text-align:center; color: white;">Admin Login</h1>
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="email" class="form-control" id="userEmail">
    </div>
    <div class="mb-3">
      <label class="col-form-label">Password</label>
      <input type="password" class="form-control" id="userPassword" minlength="8" maxlength="20">
    </div>
    <p id="message"></p>
    <div class="mb-3 col-md-4">
      <button class="form-control btn " id="checkValidation" style="margin-bottom: 10px; margin-left:180px; background-color:black;">Login</button>
    </div>
    <div style="margin-left: 16px;">
      <a href="register.php" style="font-size: 20px; color: white;  padding: 5px 19px;">Admin register</a>
    </div>
  </div>
</body>

<style>
  body {
    background: linear-gradient(to right,#fc5c7d,#6a82fb);
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 520px;
     
  }

  
  .container {
    margin-top: 200px;
    padding: 20px;
    border: 5px solid #ccc;
    border-radius: 1px;
    background: linear-gradient(to right,#fc5c7d,#6a82fb);
  }

  .form-label {
    font-weight: bold;
  }

  .form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .btn {
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px;
    cursor: pointer;
  }

  #message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
  }
  a{
    background-color: black;
    margin-left: 180px;
  }
</style>

</html>