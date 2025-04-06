<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/jpg" href="img/logo.jpg">
  <title>Your Ticket</title>
  <style>
    /* Styling for the buttons */
    .button {
      display: inline-block;
      padding: 15px 30px; /* Increased padding for larger button */
      background-color: #007bff; /* Blue color */
      color: #fff; /* White text color */
      text-decoration: none; /* Remove underline */
      border-radius: 5px; /* Rounded corners */
      margin: 10px; /* Add margin */
      font-size: 16px; /* Font size */
      transition: background-color 0.3s ease; /* Smooth transition */
    }

    .button:hover {
      background-color: #0056b3; /* Darker blue color on hover */
    }

    /* Centering the buttons */
    .center {
      text-align: center;
    }

    /* Styling for the success animation */
    .success-animation {
      width: 350px;
      
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <div class="center">
    <img src="https://i.pinimg.com/originals/0d/e4/1a/0de41a3c5953fba1755ebd416ec109dd.gif" alt="Payment Successful" class="success-animation">
    <h1 style="color:red;">Congratulations! You have successfully booked your tickets for the show.</h1>
    <h1 style="color:indianred">Check your email for confirmation ! ❤️</h1>
  </div>
  <!-- Log Out Button -->
  <div class="center">
    <a href="logout.php" class="button" style="display: none;">Log Out</a><br>
    <!-- Back To Home Button -->
    <a href="index.php" class="button">Back To Home</a><br>
    <!-- Collect Your Ticket Button -->
    <h3><a href="ticket_show.php" target="_blank" class="button" style="font-weight:bold; font-size:20px;">Collect Your Ticket</a></h3>
  </div>
</body>
</html>