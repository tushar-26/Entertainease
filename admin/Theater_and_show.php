<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}
include_once("./templates/top.php"); 
include_once("./templates/navbar.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Theater Show Management</title>
    <link href="../img/logo.jpg" rel="icon">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }

        body {
            background-color: #f8f9fc;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .management-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 25px;
        }

        .show-table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .show-table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
        }

        .show-table tbody tr {
            background: white;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .time-badge {
            background: #e3f2fd;
            color: var(--primary-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .theater-header {
            background-color: #f8f9fa !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include "./templates/sidebar.php"; ?>

    <div class="main-content" style="margin-left: 0;">
        <div class="management-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Screen Show Management</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addShowModal">
                    Add New Show
                </button>
            </div>

            <div class="table-responsive">
                <table class="table show-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Show Time</th>
                            <th>Screen</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'Database.php';
                        $result = mysqli_query($conn, "SELECT * FROM theater_show ORDER BY theater, `show`");
                        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= date("h:i A", strtotime($row['show'])) ?></td>
                                    <td>Screen <?= htmlspecialchars($row['theater']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" 
                                                data-toggle="modal" 
                                                data-target="#editShow<?= $row['id'] ?>">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" 
                                                data-toggle="modal" 
                                                data-target="#deleteShow<?= $row['id'] ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editShow<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Show</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="insert_data.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="e_id" value="<?= $row['id'] ?>">
                                                    <div class="form-group">
                                                        <label>Screen</label>
                                                        <select class="form-control" name="edit_screen" required>
                                                            <option value="1" <?= $row['theater'] == 1 ? 'selected' : '' ?>>Screen 1</option>
                                                            <option value="2" <?= $row['theater'] == 2 ? 'selected' : '' ?>>Screen 2</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Show Time</label>
                                                        <input type="time" class="form-control" 
                                                               name="edit_time" 
                                                               value="<?= htmlspecialchars($row['show']) ?>" 
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="updatetime" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteShow<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="insert_data.php" method="POST">
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this show time?</p>
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="deletetime" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-center">No shows scheduled</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Show Modal -->
    <div class="modal fade" id="addShowModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Show</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="insert_data.php" method="POST" onsubmit="return validateForm()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Screen</label>
                            <select class="form-control" name="theater_name" required>
                                <option value="">Select Screen</option>
                                <option value="1">Screen 1</option>
                                <option value="2">Screen 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Show Time</label>
                            <input type="time" class="form-control" name="show" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="addshow" class="btn btn-primary">Add Show</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            const screen = document.querySelector('[name="theater_name"]').value;
            const showTime = document.querySelector('[name="show"]').value;
            
            if (!screen || !showTime) {
                alert("Please fill all required fields!");
                return false;
            }
            return true;
        }
    </script>

    <?php include_once("./templates/footer.php"); ?>
</body>
</html>