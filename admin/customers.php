<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Customer Page</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      /* Body Styles */
      body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fa;
        color: #333;
      }

      .container-fluid {
        padding-top: 20px;
      }

      /* Navbar Styles */
      .navbar {
        background-color: #2c3e50;
        border-radius: 0;
      }

      .navbar-brand {
        color: #ecf0f1 !important;
        font-size: 24px;
      }

      .navbar-nav .nav-link {
        color: #ecf0f1 !important;
      }

      .navbar-nav .nav-link:hover {
        background-color: #34495e;
      }

      /* Sidebar Styles */
      .sidebar {
        background-color: #34495e;
        padding: 20px;
        border-radius: 8px;
      }

      .sidebar a {
        color: #ecf0f1;
        text-decoration: none;
        padding: 10px;
        display: block;
        border-radius: 4px;
        transition: background-color 0.3s ease;
      }

      .sidebar a:hover {
        background-color: #1abc9c;
      }

      /* Table Styles */
      .table {
        background-color: #fff;
        border-radius: 8px;
        margin-top: 20px;
      }

      .table th, .table td {
        text-align: center;
        padding: 12px;
        vertical-align: middle;
      }

      .table-striped tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
      }

      .table-hover tbody tr:hover {
        background-color: #ecf0f1;
      }

      /* Modal Styles */
      .modal-header {
        background-color: #2c3e50;
        color: #fff;
        border-bottom: none;
      }

      .modal-body {
        padding: 20px;
      }

      .form-group label {
        font-weight: bold;
      }

      .form-control {
        border-radius: 4px;
        border: 1px solid #ccc;
        padding: 10px;
      }

      .form-control:focus {
        border-color: #3498db;
      }

      .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: #fff;
      }

      .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
      }

      /* Custom Button Styling */
      .btn-sm {
        background-color: #16a085;
        border: none;
        font-size: 14px;
        color: #fff;
        padding: 10px 15px;
        cursor: pointer;
      }

      .btn-sm:hover {
        background-color: #1abc9c;
      }

      .btn-primary.add-product {
        width: 100%;
        padding: 12px;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .navbar {
          font-size: 18px;
        }

        .container-fluid {
          padding-left: 15px;
          padding-right: 15px;
        }

        .sidebar {
          display: none;
        }

        .modal-dialog {
          max-width: 90%;
        }
      }
    </style>
  </head>
  <body>

    <?php session_start();
    if (!isset($_SESSION['admin'])) {
      header("location:login.php");
    }
    ?>

    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>

    <div class="container-fluid">
      <div class="row">
        
        <?php include "./templates/sidebar.php"; ?>

        <div class="col-12 col-md-10">
          <div class="row">
            <div class="col-8">
              <h2 class="text-center">Customers</h2>
            </div>
            <div class="col-4">
              <button data-toggle="modal" data-target="#add_custemer_modal" class="btn btn-sm btn-primary float-right">Add Movie</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Movie</th>
                  <th>Theater</th>
                  <th>Show Time</th>
                  <th>Seat</th>
                  <th>Total Seat</th>
                  <th>Price</th>
                  <th>Payment Date</th>
                  <th>Booking Date</th>
                  <th>Customer</th>
                </tr>
              </thead>
              <tbody id="customer_list">
                <?php
                include_once 'Database.php';
                $result = mysqli_query($conn,"SELECT c.id,c.movie,c.booking_date,c.show_time,c.seat,c.totalseat,c.price,c.payment_date,c.custemer_id,u.username,t.theater FROM customers c INNER JOIN user u on c.uid = u.id INNER JOIN theater_show t on c.show_time = t.show");
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    $id=$row['id'];?>
                    <tr>
                      <td><?php echo $row['id'];?></td>
                      <td><?php echo $row['username'];?></td>
                      <td><?php echo $row['movie'];?></td>
                      <td><?php echo $row['theater'];?></td>
                      <td><?php echo $row['booking_date'];?></td>
                      <td><?php echo $row['show_time'];?></td>
                      <td><?php echo $row['seat'];?></td>
                      <td><?php echo $row['totalseat'];?></td>
                      <td><?php echo $row['price'];?></td>
                      <td><?php echo $row['payment_date'];?></td>
                      <td><?php echo $row['custemer_id'];?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Customers Modal -->
    <div class="modal fade" id="add_custemer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <label>Username Id</label>
                  <select class="form-control category_list" name="username_id">
                    <option value="">Select Username</option>
                    <?php
                    $result = mysqli_query($conn,"SELECT * FROM user");
                    if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row['id'];?>"><?php echo $row['username'];?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="col-12">
                  <label>Movie</label>
                  <select class="form-control category_list" name="movie">
                    <option>Select Movie</option>
                    <?php
                    $result = mysqli_query($conn,"SELECT * FROM add_movie");
                    if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_array($result)) {
                        if($row['action']=="running"){
                    ?>
                    <option value="<?php echo $row['movie_name'];?>"><?php echo $row['movie_name'];?></option>
                    <?php
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                
                <div class="col-12">
                  <div class="form-group">
                    <label>Show Time</label>
                    <input type="text" name="show_time" class="form-control" placeholder="Enter Show">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Seats</label>
                    <input type="text" name="seat" class="form-control" placeholder="Enter Seats">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Total Seat</label>
                    <input type="number" name="totalseat" class="form-control" placeholder="Enter Total Seat">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" placeholder="Enter Price">
                  </div>
                </div>

                <div class="col-12">
                  <input type="submit" name="customers" class="btn btn-primary add-product" value="Add Product">
                </div>
              </div>
            </form>
            <div id="preview"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Customers Modal End -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
