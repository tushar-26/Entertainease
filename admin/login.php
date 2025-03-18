<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="ajaxValidation.js"></script>
  <style type="text/css">
    li {
      color: red;
    }
  </style>
</head>

<body>
  <div class="container col-md-5">
    <h1 style="text-align:center; color: red;">Admin Login</h1>
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="email" class="form-control" id="userEmail">
    </div>
    <div class="mb-3">
      <label class="col-sm-2 col-form-label">Password</label>
      <input type="password" class="form-control" id="userPassword">
    </div>
    <p id="message"></p>
    <div class="mb-3 col-md-4">
      <button class="form-control btn btn-danger" id="checkValidation" style="margin-bottom: 10px;">Login</button>

    </div>
    
  </div>
</body>

<style>
  body {
    background: url(../img/bg.png);
    background-repeat: no-repeat;
    background-size: cover;
  }

  /* Style for the container */
  /* Style for the container */
  .container {
    margin: 50px auto;
    padding: 20px;
    border: 5px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
  }

  /* Style for form labels */
  .form-label {
    font-weight: bold;
  }

  /* Style for form inputs */
  .form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  /* Style for the login button */
  .btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px;
    cursor: pointer;
  }

  /* Hover effect for the login button */
  .btn:hover {
    background-color: rgb(35, 46, 200);
  }

  /* Style for the error message */
  #message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
  }
</style>

</html>