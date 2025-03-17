<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <style>
    /* General page styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

/* Sidebar Styling */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    background-color: #f8f9fa;
    padding-top: 20px;
    border-right: 1px solid #ddd;
}

.sidebar .nav-item {
    width: 100%;
}

.sidebar .nav-link {
    display: block;
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s, color 0.3s;
}

.sidebar .nav-link:hover {
    background-color: #007bff;
    color: white;
}

.sidebar .nav-link .feather {
    margin-right: 10px;
}

/* Active link styling */
.sidebar .nav-link.active {
    background-color: #007bff;
    color: white;
}

/* Main content styling */
main {
    margin-left: 250px; /* Space for the sidebar */
    padding: 20px;
    background-color: #ffffff;
}

/* Header Styling */
main .h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

/* Ensure the sidebar does not overlap the content */
body {
    display: flex;
}

/* Responsive sidebar for smaller screens */
@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        padding-top: 0;
    }

    main {
        margin-left: 0;
    }
}

  </style>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">

          <?php 

            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);

          ?>


          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="add-movie.php">
              <span data-feather="users"></span>
              Add Movie
            </a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="Theater_and_show.php">
              <span data-feather="users"></span>
              Theater And Show
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="customers.php">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="Feedback.php">
              <span data-feather="users"></span>
              Feedback
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="users.php">
              <span data-feather="users"></span>
              Users
            </a>
          </li>
           
        </ul>

      </div>
    </nav>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hello <?php echo $_SESSION["admin"]; ?></h1>
        
      </div>
      </body>
      </html>