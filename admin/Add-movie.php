<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Movies Page</title>
    <style>
     /* Global Styles */

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  color: #333;
  background-color: #f9f9f9;
}

.container-fluid {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

.col-10, .col-2 {
  padding: 20px;
}

h2 {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

/* Table Styles */

.table-responsive {
  overflow-x: auto;
  margin-bottom: 20px;
}

.table-striped {
  border-collapse: collapse;
  width: 100%;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table-striped th, .table-striped td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
  vertical-align: middle;
}

.table-striped th {
  background-color: #f0f0f0;
  font-weight: bold;
}

.table-striped tr:nth-child(even) {
  background-color: #f9f9f9;
}

/* Modal Styles */

.modal-content {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  padding: 20px;
}

.modal-header {
  background-color: #f0f0f0;
  border-bottom: 1px solid #ddd;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
  font-size: 18px;
  font-weight: bold;
  margin: 0;
}

.close {
  float: right;
  font-size: 24px;
  font-weight: bold;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: 0.2;
  cursor: pointer;
}

.close:hover {
  opacity: 0.5;
}

.modal-body {
  padding: 20px;
}

/* Form Styles */

.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  height: 40px;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
  border-color: #aaa;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* Button Styles */

.btn {
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn-primary {
  background-color: #337ab7;
  color: #fff;
}

.btn-primary:hover {
  background-color: #23527c;
}

.btn-danger {
  background-color: #d9534f;
  color: #fff;
}

.btn-danger:hover {
  background-color: #c9302c;
}

/* Responsive Design */

@media (max-width: 768px) {
  .container-fluid {
    max-width: 100%;
    padding: 0 10px;
  }
  .col-10, .col-2 {
    padding: 10px;
  }
}

@media (max-width: 480px) {
  .container-fluid {
    max-width: 100%;
    padding: 0 5px;
  }
  .col-10, .col-2 {
    padding: 5px;
  }
}
    </style>

<?php session_start();  
if (!isset($_SESSION['admin'])) {
  header("location:login.php");
}
?>


<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Add movie</h2>
      	</div>
      	<div class="col-2">
      		<button data-toggle="modal" data-target="#add_movie_modal" class="btn btn-primary btn-sm">Add Movie</button>
        </div>
        
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>id</th>
              <th>Movie name</th>
              <th>Directer</th>
              <th>categroy</th>
              <th>language</th>
              <th>Show</th>
              <th>Image</th>
              <th>Action</th>
              
            </tr>
          </thead>
          <tbody id="product_list">
            <?php
include_once 'Database.php';
$result = mysqli_query($conn,"SELECT * FROM add_movie");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    $id=$row['id'];?>
    <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['movie_name'];?></td>
              <td><?php echo $row['directer'];?></td>
              <td><?php echo $row['categroy'];?></td>
              <td><?php echo $row['language'];?></td>
      
              <td><?php echo $row['show'];?></td>
              <td><img src="image/<?php echo $row['image']; ?>" alt="" class="resize"></td>
              <td><button data-toggle="modal" type="button" data-target="#edit_movie_modal<?php echo $id;?>" class="btn btn-primary btn-sm">Edit Movie</button></td>
              <td><button data-toggle="modal" type="button" data-target="#delete_movie_modal<?php echo $id;?>" class="btn btn-danger btn-sm">Delete Movie</button></td></td>
            </tr>

 <div class="modal fade" id="delete_movie_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <input type="submit" name="deletemovie" id="deletemovie" value="OK" class="btn btn-primary">
          </form>

      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="edit_movie_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="insert_movie" action="insert_data.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Movie Name</label>
                <input type="hidden" name="e_id" value="<?php echo $row['id'];?>">
                <input class="form-control" name="edit_movie_name" id="edit_movie_name" value="<?php echo $row['movie_name'];?>">
                <small></small>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Directer Name</label>
                <input class="form-control" name="edit_directer_name" id="edit_directer_name" value="<?php echo $row['directer'];?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>category</label>
                <input class="form-control" name="edit_category" id ="edit_category" value="<?php echo $row['categroy']; ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>language</label>
                <input type="text" name="edit_language" id="edit_language" class="form-control" value="<?php echo $row['language'];?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Time</label>
                  <?php
                  $seats = explode(",", $row['show']);
                $sql = mysqli_query($conn,"SELECT * FROM theater_show");
                if (mysqli_num_rows($sql) > 0) {
                  while($fatch = mysqli_fetch_array($sql)) {
                        $checked = $fatch['show'];
                    ?>
                    <font size="2"> <?php echo $fatch['show'];?></font><input type="checkbox" name="show[]" id="show" value="<?php echo $fatch['show'];?>" <?php
                         if(in_array($checked,$seats)){
                                    echo "checked";
                                }
                    ?>>
                
                    <?php
                  }
                }
              ?>
              </div>
            </div>

             <div class="col-12">
              <div class="form-group">
                <label>Action</label>
                <select class="form-control" name="edit_action">
                  <option value="<?php echo $row['action'];?>"><?php echo $row['action'];?></option>
                  <option value="upcoming">upcoming</option>
                  <option value="running">running</option>                    
                </select>
              </div>
            </div>
            <div class="col-12">      
            <div class="col-12">
              <div class="form-group">
                <label>Set of Time</label>
                <img src="image/<?php echo $row['image'];?>" width="10%">
                <input type="file" name="edit_img" id="edit_img" class="form-control">
                <input type="hidden" name="old_image" value="<?php echo $row['image'];?>" id="old_image" class="form-control">              
              </div>
            </div>
            <input type="hidden" name="add_product" value="1">
            <div class="col-12">
            
              <input type="submit" name="updatemovie" id="updatemovie" value="update" class="btn btn-primary">
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
<div class="modal fade" id="add_movie_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="myform" id="insert_movie" action="insert_data.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()" >
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Movie Name</label>
		        		<input class="form-control" name="movie_name" id="movie_name" placeholder="movie name">
		        	</div>
        		</div>
            <div class="col-12">
              <div class="form-group">
                <label>Directer Name</label>
                <input class="form-control" name="directer_name" id="directer_name" placeholder="Directer name">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Release Date</label>
                <input class="form-control" name="release_date" id="release_date" placeholder="Directer name">
              </div>
            </div>
      
        		<div class="col-12">
        			<div class="form-group">
		        		<label>category</label>
		        		<input class="form-control" name="category" id ="category" placeholder="Enter category">
		        	</div>
        		</div>
            <div class="col-12">
              <div class="form-group">
                <label>language</label>
                <input type="text" name="language" id="language" class="form-control" placeholder="Enter Language">
              </div>
            </div>
            
            <div class="col-12">
              <div class="form-group">
                <label>Theater 1</label>
              <?php
                $result = mysqli_query($conn,"SELECT * FROM theater_show");
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    if($row['theater']==1){
                    
                    ?>
                    <font size="2"> <?php echo $row['show'];?></font><input type="checkbox" name="show[]" id="show" value="<?php echo $row['show'];?>">
                
                    <?php
                  }
                  }
                }
              ?>
                
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Theater 2</label>
              <?php
                $result = mysqli_query($conn,"SELECT * FROM theater_show");
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    if($row['theater']==2){
                    
                    ?>
                    <font size="2"> <?php echo $row['show'];?></font><input type="checkbox" name="show[]" id="show" value="<?php echo $row['show'];?>">
                
                    <?php
                  }
                  }
                }
              ?>
                
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Tailer</label>
                <input type="text" name="tailer" id="tailer" class="form-control" placeholder="Enter Tailer">
              </div>
            </div>
             <div class="col-12">
              <div class="form-group">
                <label>Action</label>
                <select class="form-control" name="action" id="action">
                  <option value="">Action</option>
                  <option value="upcoming">upcoming</option>
                  <option value="running">running</option>                    
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Decription</label>
                <textarea type="text" name="decription" id="decription" class="form-control">
                </textarea>
              </div>
            </div>
        		<div class="col-12">

        		<input type="hidden" name="add_product" value="1">
        		<div class="col-12">
        		
              <input type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">
        		</div>
        	</div>
        	
        </form>
        <div id="preview"></div>
      </div>
    </div>
  </div>
</div>
<!-- Add movie Modal end -->

<!-- Edit movie Modal start -->




<script>  
function validateform(){  
var name=document.myform.movie_name.value;  
var directer=document.myform.directer_name.value;  
  

if (name==""){  
  alert("Requre Movie Name");  
  return false;  
}else if(directer==""){  
  alert("Requre Directer Name");  
  return false;  
  }  
}

</script>

