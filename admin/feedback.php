<?php
session_start(); 
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit;
}

include_once("./templates/top.php"); 
include_once("./templates/navbar.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer Feedback</title>
    
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .feedback-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 25px;
        }

        .table-header {
            background-color: var(--primary-color);
            color: white;
        }

        .feedback-table tbody tr {
            transition: all 0.2s ease;
        }

        .feedback-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .feedback-message {
            max-width: 400px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .search-container {
            max-width: 400px;
            margin-bottom: 25px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <?php include "./templates/sidebar.php"; ?>

    <div class="main-content" style="margin-left: 0;">
        <div class="feedback-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Customer Feedback</h2>
                <div class="search-container">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search feedback...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table feedback-table">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'Database.php';
                        $result = mysqli_query($conn, "SELECT * FROM feedback");
                        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '
                                <tr>
                                    <td>'.htmlspecialchars($row['id']).'</td>
                                    <td>'.htmlspecialchars($row['name']).'</td>
                                    <td>'.htmlspecialchars($row['email']).'</td>
                                    <td class="feedback-message">'.htmlspecialchars($row['massage']).'</td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-center">No feedback records found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('.feedback-table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Add hover effect
            $('.feedback-table tbody tr').hover(
                function() {
                    $(this).css('transform', 'translateX(10px)');
                },
                function() {
                    $(this).css('transform', 'translateX(0)');
                }
            );
        });
    </script>

    <?php include_once("./templates/footer.php"); ?>
</body>
</html>