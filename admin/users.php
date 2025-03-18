<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.5">
  <title>Manage Users</title>
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      min-height: 100vh;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #343a40;
      padding-top: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }
    .table-responsive {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .user-avatar {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
      border: 2px solid #dee2e6;
      background: #fff;
      padding: 2px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table thead th {
      border-bottom: 2px solid #dee2e6;
      background: #f8f9fa;
    }
    h2 {
      color: #343a40;
      font-weight: 600;
      margin-bottom: 30px;
    }
    .action-buttons {
      min-width: 130px;
    }
    .modal-content {
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <?php session_start(); ?>
  <?php if (!isset($_SESSION['admin'])) { header("location:login.php"); } ?>
  <?php include_once("./templates/top.php"); ?>
  <?php include_once("./templates/navbar.php"); ?>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <?php include "./templates/sidebar.php"; ?>

      <!-- Main Content -->
      <div class="main-content" style=" margin-left:0">
        <h2>User Management</h2>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Avatar</th>
                <th class="action-buttons">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include_once 'Database.php';
              $result = mysqli_query($conn, "SELECT * FROM user");

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $id = $row['id'];
                  $image_file = $row['image'];
                  
                  // Image handling with double fallback
                  $avatar_path = 'image/'.$image_file;
                  $fallback_avatar = 'image/img_avatar.png';
                  
                  if (!file_exists($avatar_path) || empty($image_file)) {
                    $avatar_path = $fallback_avatar;
                  }
              ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile']) ?></td>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td>
                      <img src="<?= $avatar_path ?>" 
                           alt="User Avatar" 
                           class="user-avatar"
                           onerror="this.src='<?= $fallback_avatar ?>'">
                    </td>
                    <td>
                      <button class="btn btn-primary btn-sm" 
                              data-toggle="modal" 
                              data-target="#edit_users_modal<?= $id ?>">
                        Edit
                      </button>
                      <button class="btn btn-danger btn-sm" 
                              data-toggle="modal" 
                              data-target="#delete_users_modal<?= $id ?>">
                        Delete
                      </button>
                    </td>
                  </tr>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="delete_users_modal<?= $id ?>" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Confirm Delete</h5>
                          <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Delete user <?= htmlspecialchars($row['username']) ?> (ID: <?= $id ?>)?</p>
                          <form action="insert_data.php" method="POST">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button type="submit" name="deleteuser" 
                                    class="btn btn-danger">Confirm Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Edit Modal -->
                  <div class="modal fade" id="edit_users_modal<?= $id ?>" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit User</h5>
                          <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="insert_data.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="e_id" value="<?= $id ?>">
                            <input type="hidden" name="old_image" value="<?= $row['image'] ?>">
                            
                            <div class="form-group">
                              <label>Username</label>
                              <input type="text" name="edit_username" 
                                     value="<?= htmlspecialchars($row['username']) ?>" 
                                     class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                              <label>Email</label>
                              <input type="email" name="edit_email" 
                                     value="<?= htmlspecialchars($row['email']) ?>" 
                                     class="form-control" required>
                            </div>
                            
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Mobile</label>
                                  <input type="tel" name="edit_mobile" 
                                         value="<?= htmlspecialchars($row['mobile']) ?>" 
                                         class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>City</label>
                                  <input type="text" name="edit_city" 
                                         value="<?= htmlspecialchars($row['city']) ?>" 
                                         class="form-control" required>
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label>Profile Image</label>
                              <div class="custom-file">
                                <input type="file" name="edit_img" 
                                       class="custom-file-input" id="edit_img<?= $id ?>">
                                <label class="custom-file-label" 
                                       for="edit_img<?= $id ?>">Choose file</label>
                              </div>
                            </div>
                            
                            <button type="submit" name="updateusers" 
                                    class="btn btn-primary btn-block">Update User</button>
                          </form>
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
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <!-- File input script -->
  <script>
    document.querySelectorAll('.custom-file-input').forEach(item => {
      item.addEventListener('change', function(e) {
        let fileName = this.files[0] ? this.files[0].name : "Choose file";
        this.nextElementSibling.textContent = fileName;
      });
    });
  </script>
</body>
</html>