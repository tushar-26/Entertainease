 
 <!DOCTYPE html>
 <html lang="en">
 <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
 </head>
 <body>
	<style>
	
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
   
}
.navbar {
    background-color:rgb(0, 128, 255); 
    padding: 10px 15px;
    box-shadow: 0 4px 8px rgba(249, 4, 4, 0.2);
}

.navbar .navbar-brand {
    display: flex;
    align-items: center;
}

.navbar .navbar-brand img {
    max-width: 100px; 
    height: auto;
}

.navbar-nav {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.navbar-nav .nav-item {
    margin-left: 20px;
}

.navbar-nav .nav-item .nav-link {
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    transition: color 0.3s;
}

.navbar-nav .nav-item .nav-link:hover {
    color:rgb(255, 149, 0); /* A gold/yellow color on hover */
}

/* Add some space to the body for content below the navbar */
body {
    padding-top: 60px; /* Ensure content doesn't hide behind the fixed navbar */
}

	</style>
 <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img src="logo.png" alt=""></a>

  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
    	<?php
    		if (isset($_SESSION['admin'])) {
    			?>
                   <h4 style="display: inline-block; margin-right: 1000px; color:orangered; font-family: arial; font-style:italic; box-shadow: red 0 0 20px; padding: 3px;">Admin Panel</h3>
    				<a class="nav-link" href="../admin/admin-logout.php" style="display: inline-block;">Sign out</a>
    			<?php
    		}
    	?>
      
    </li>
  </ul>
</nav>
</body>
</html>