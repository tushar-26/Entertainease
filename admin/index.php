<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">

    <title>Dashboard Page</title>
  </head>
  <body>
  <style>
    /* General Styling */
body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
}

h2 {
  color: #343a40;
  margin-top: 30px;

}

table {
  background-color: #ffffff;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

th, td {
  text-align: left;
  padding: 10px;
}

th {
  background-color: #007bff;
  color: #fff;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #d6ecf3;
}

/* Dashboard-specific styles */

    
  </style>
<?php 
session_start();  
if (!isset($_SESSION['admin'])) {
  header("location:login.php");
}

include "./templates/top.php"; 

?>
 
 <?php include "./templates/navbar.php"; ?>


<div class="container-fluid" style="margin-top: 150px; width: 900px;">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>


      <h2>Total Admins</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>

            </tr>
          </thead>
          <?php
include_once 'Database.php';
$result = mysqli_query($conn,"SELECT * FROM admin");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    ?>
    <tr><td><?php echo $row['id'];?></td>
          <td><?php echo $row['name'];?></td>
          <td><?php echo $row['email'];?></td>
          
          <td><?php echo $row['is_active'];?></td>
          
            </tr>
  <?php
  }
}
?>
           
          
        </table>
      </div>
    </main>
  </div>
</div>

<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/admin.js"></script>
</body>
</html>
