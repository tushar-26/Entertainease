<?php include "./templates/top.php"; ?>

<?php include "./templates/navbar.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>admin register page </title>
</head>
<body>
<style>
	body {
    font-family: Arial, sans-serif;
	background: linear-gradient(to right,#fc5c7d,#6a82fb);
}

.container {
    max-width: 600px;
	height: 600px;
    margin:  auto;
    padding: 20px;
    background-color: #fff;
    border: 5px solid white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(230, 111, 111, 0.1);
	background: linear-gradient(to right,#fc5c7d,#6a82fb);
	
}

.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.col-md-4 {
    flex-basis: 33.33%;
    padding: 20px;
}

h4 {
    text-align: center;
    margin-bottom: 20px;
	font-size: 20px;
	color: black;
}

.message {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;

}
.form-group label {
    display: block;
    margin-bottom: 10px;
}

.form-group input {
    width: 350px;
    height: 40px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-control {
    width: 200%;
    height: 40px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-control:focus {
    border-color: #aaa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 10px;
}

small {
    font-size: 14px;
    color: #666;
}

.register-btn {
    width: 150px;
    height: 40px;
    padding: 10px;
    font-size: 16px;
	margin-left: 100px;
    border: none;
    border-radius: 5px;
    background-color:rgb(0, 0, 0);
    color: #fff;
    cursor: pointer;
}


.text-success {
    color:rgb(0, 0, 0);
}

.text-danger {
    color: #e74c3c;
}
</style>

<div class="container">
	<div class="row justify-content-center" style="margin:100px 0;">
		<div class="col-md-4">
			<h4>Admin Register</h4>
			<p class="message"></p>
			<form id="admin-register-form">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
			  </div>
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			  </div>
			  <div class="form-group">
			    <label for="cpassword">Confirm Password</label>
			    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Password">
			  </div>
			  <input type="hidden" name="admin_register" value="1">
			  <button type="button" class="btn btn-primary register-btn">Register</button>
			</form>
		</div>
	</div>
</div>





<?php include "./templates/footer.php"; ?>

<script type="text/javascript">
	$(document).ready(function(){

	$(".register-btn").on("click", function(){

		$.ajax({
			url : '../admin/classes/Credentials.php',
			method : "POST",
			data : $("#admin-register-form").serialize(),
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					$("#admin-register-form").trigger("reset");
					$(".message").html('<span class="text-success">'+resp.message+'</span>');
				}else if(resp.status == 303){
					$(".message").html('<span class="text-danger">'+resp.message+'</span>');
				}
			}
		});

	});



});
</script>
</body>
</html>
