<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: login.php");
    exit();
}

include_once 'Database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "moviebook");
    
    // Add new admin
    if (isset($_POST['add_admin'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        
        // Check if email exists
        $check = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            echo "Email already exists!";
        } else {
            $query = "INSERT INTO admin (name, email, password, is_active) 
                     VALUES ('$name', '$email', '$password', '1')";
            mysqli_query($conn, $query);
            header("Location: index.php");
            exit();
        }
    }
    
    // Edit admin
    if (isset($_POST['edit_admin'])) {
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $status = $_POST['status'];
        
        // Password update
        $password_update = '';
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password_update = ", password='$password'";
        }
        
        $query = "UPDATE admin SET 
                 name='$name', 
                 email='$email', 
                 is_active='$status'
                 $password_update 
                 WHERE id=$id";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }
    
    // Delete admin
    if (isset($_POST['delete_admin'])) {
        $id = $_POST['id'];
        mysqli_query($conn, "DELETE FROM admin WHERE id=$id");
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Management</title>
    <link href="../img/logo.jpg" rel="icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .main-content { margin-left: 250px; padding: 30px; }
        .dashboard-card { background: white; border-radius: 8px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); padding: 25px; }
        .status-active { color: #1cc88a; }
        .status-inactive { color: #e74a3b; }
    </style>
</head>
<body>
    <?php include "./templates/top.php"; ?>
    <?php include "./templates/navbar.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include "./templates/sidebar.php"; ?>

            <div class="main-content" style="margin-left: 0;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Admin Management</h1>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addAdminModal">
                        Invite Admin
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM admin");
                            while ($row = mysqli_fetch_assoc($result)) :
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td class="<?= $row['is_active'] ? 'status-active' : 'status-inactive' ?>">
                                    <?= $row['is_active'] ? 'Active' : 'Inactive' ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-admin"
                                            data-id="<?= $row['id'] ?>"
                                            data-name="<?= htmlspecialchars($row['name']) ?>"
                                            data-email="<?= htmlspecialchars($row['email']) ?>"
                                            data-status="<?= $row['is_active'] ?>">
                                        Edit
                                    </button>
                                    <form method="POST" style="display:inline">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="delete_admin" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_admin" class="btn btn-primary">Create Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password (optional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" id="editStatus">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_admin" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Edit admin modal handler
        $('.edit-admin').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const status = $(this).data('status');
            
            $('#editId').val(id);
            $('#editName').val(name);
            $('#editEmail').val(email);
            $('#editStatus').val(status);
            $('#editAdminModal').modal('show');
        });
    </script>
</body>
</html>