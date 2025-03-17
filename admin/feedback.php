<?php
session_start(); 
if (!isset($_SESSION['admin'])) {
  header("location:login.php");
  exit; // Ensure no further code is executed after the redirect
}

// Continue with your includes and HTML below
include_once("./templates/top.php"); 
include_once("./templates/navbar.php"); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Feedback Page</title>

  </head>
  <body>
    <!-- Your HTML content goes here -->
    <div class="container-fluid">
      <!-- Content continues... -->
    </div>
    <!-- Additional Modals and HTML content -->
  </body>
</html>
<?php
include_once("./templates/footer.php"); 
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Feedback Page</title>
    </head>
<style>
  /* General Body Styling */
body {
  font-family: 'Roboto', sans-serif;
  background-color: #f4f7fa;
  margin: 0;
  padding: 0;
}

/* Navbar Styling */
.navbar {
  background-color: #007bff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar .navbar-brand, .navbar .nav-link {
  color: #ffffff !important;
}

.navbar .nav-link:hover {
  color: #ffd700 !important;
}

/* Sidebar Styling */
.sidebar {
  background-color: #343a40;
  color: white;
  padding-top: 30px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  transition: all 0.3s ease;
}

.sidebar a {
  color: #ccc;
  text-decoration: none;
  padding: 15px 20px;
  display: block;
  font-size: 18px;
}

.sidebar a:hover {
  background-color: #007bff;
  color: white;
}

.sidebar .active {
  background-color: #007bff;
  color: white;
}

/* Container and Row Styling */
.container-fluid {
  margin-left: 10px;
  padding: 20px;
  transition: all 0.3s ease;
}

.row {
  margin-top: 20px;
}

/* Table Styling */
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
  margin-left: 50px;
}

.table th, .table td {
  padding: 12px;
  text-align: left;
  vertical-align: middle;
}

.table-striped tbody tr:nth-child(odd) {
  background-color: #f9f9f9;
}

.table-hover tbody tr:hover {
  background-color: #f1f1f1;
}

.table th {
  background-color: #007bff;
  color: white;
}

/* Modal Styling */
.modal-content {
  border-radius: 10px;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
  border-bottom: 1px solid #e5e5e5;
  background-color: #007bff;
  color: white;
  border-radius: 10px 10px 0 0;
  padding: 15px;
}

.modal-body {
  padding: 25px;
}

.modal-footer {
  border-top: 1px solid #e5e5e5;
  padding: 10px;
  text-align: right;
}

/* Button Styling */
.btn {
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  transition: all 0.3s ease;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
  border: none;
}

.btn-danger:hover {
  background-color: #c82333;
}

.btn-sm {
  padding: 5px 10px;
  font-size: 14px;
}

.btn:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
}

/* Form Styling */
.form-group {
  margin-bottom: 15px;
}

.form-control {
  border-radius: 5px;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  transition: border 0.3s ease;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}

textarea.form-control {
  height: 100px;
}

/* Input Field Styling */
input[type="text"], input[type="number"], input[type="email"], input[type="date"] {
  border-radius: 5px;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  transition: border 0.3s ease;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="date"]:focus {
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}

/* Footer Styling */
footer {
  background-color: #007bff;
  color: white;
  text-align: center;
  padding: 20px 0;
  position: fixed;
  bottom: 0;
  width: 100%;
}

/* Hover Effects for Cards */
.card {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .container-fluid {
    margin-left: 0;
  }

  .sidebar {
    position: static;
    width: 100%;
    padding: 0;
  }

  .sidebar a {
    font-size: 16px;
    padding: 12px 15px;
  }

  .modal-dialog {
    width: 100%;
    margin: 0;
  }

  .table {
    font-size: 14px;
  }
}

</style>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Feedback</h2>
      	</div>
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_feedback_modal" class="btn btn-primary btn-sm">Feedback detail</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>id</th>
              <th>Name</th>
              <th>email</th>
              <th>subject</th>
              <th>massage</th>
            </tr>
          </thead>
          <tbody id="product_list">
           <?php
include_once 'Database.php';
$result = mysqli_query($conn,"SELECT * FROM feedback");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    $id=$row['id'];?>
    <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['name'];?></td>
              <td><?php echo $row['email'];?></td>
              <td><?php echo $row['massage'];?></td>
              
              
              <td><button data-toggle="modal" type="button" data-target="#edit_feedback_modal<?php echo $id;?>" class="btn btn-primary btn-sm">Edit Movie</button></td>
              <td><button data-toggle="modal" type="button" data-target="#delete_feedback_modal<?php echo $id;?>" class="btn btn-danger btn-sm">Delete Movie</button></td>
            </tr>

 <div class="modal fade" id="delete_feedback_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="insert_movie" action="insert_data.php" method="post">
          <h4> Yor Sour This id "<?php echo $row['id'];?>" is delete.</h4>
          <input type="hidden" name="id" value="<?php echo $row['id'];?>">
          <input type="submit" name="deletefeedback" id="deletefeedback" value="OK" class="btn btn-primary">
          </form>

      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="edit_feedback_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="insert_movie" action="insert_data.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Name</label>
                <input type="hidden" name="e_id" value="<?php echo $row['id'];?>">
                <input class="form-control" name="edit_feedback_name" id="edit_name" value="<?php echo $row['name'];?>">
                <small></small>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="edit_feedback_email" id="edit_email" value="<?php echo $row['email'];?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Massage</label>
                <input class="form-control" name="edit_feedback_massage" id ="edit_massage" value="<?php echo $row['massage']; ?>">
              </div>
            </div>
            <div class="col-12">
            
              <input type="submit" name="updatefeedback" id="updatefeedback" value="update" class="btn btn-primary">
            </div>
          </div>
          
        </form>
        <div id="preview"></div>
      </div>
    </div>
  </div>
</div> 
  <?php

  }
}
?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>




<!-- Add Product Modal start -->
<div class="modal fade" id="add_feedback_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="myform" id="insert_movie" action="insert_data.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
          <div class="row">
            <div class="col-12">
              <div class="col-12">
              <div class="form-group">
                <label>Enter Your Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Enter Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter Name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Massage</label>
                <textarea class="form-control" name="massage" id="massage" placeholder="Enter Your Massage"></textarea>
              </div>
            </div>
      
           <div class="col-12">
              <input type="submit" name="add_feedback" class="btn btn-primary add-product" value="Add Product">
            </div>
          </div>
          
        </form>
        <div id="preview"></div>
      </div>
    </div>
  </div>
</div>
<!-- Add movie Modal end -->



<?php include_once("./templates/footer.php"); ?>


<script>  
function validateform(){  
var name=document.myform.name.value;  
var email=document.myform.email.value;  
var massage=document.myform.massage.value;  

if (name==""){  
  alert("Requre Name");  
  return false;  
}else if(email==""){  
  alert("Requre email Name");  
  return false;  
  } 
  else if(massage==""){  
  alert("Requre Massage Name");  
  return false;  
  }  
}

</script>
