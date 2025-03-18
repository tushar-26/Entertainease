<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: login.php");
    exit();
}
include_once 'Database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer Management</title>
    
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

        .dashboard-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 25px;
        }

        .table-header {
            background-color: var(--primary-color);
            color: white;
        }

        .search-container {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-active {
            background-color: #28a745;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f4f6;
            cursor: pointer;
        }

        .currency {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <?php include "./templates/top.php"; ?>
    <?php include "./templates/navbar.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include "./templates/sidebar.php"; ?>

            <div class="main-content" style="margin-left: 0;">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Customer Bookings</h2>
                        <div class="search-container">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search bookings...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-header">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Movie</th>
                                    <th>Theater</th>
                                    <th>Show Time</th>
                                    <th>Seats</th>
                                    <th>Total</th>
                                    <th>Booking Date</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody id="bookingList">
                                <?php
                                $query = "SELECT c.id, c.booking_date, c.show_time, c.seat, c.totalseat, 
                                          c.price, c.payment_date, u.username AS customer_name, 
                                          m.movie_name, t.theater 
                                          FROM customers c
                                          INNER JOIN user u ON c.uid = u.id
                                          INNER JOIN add_movie m ON c.movie = m.movie_name
                                          INNER JOIN theater_show t ON c.show_time = t.show";
                                
                                $result = mysqli_query($conn, $query);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                        <tr>
                                            <td>#'.htmlspecialchars($row['id']).'</td>
                                            <td>'.htmlspecialchars($row['customer_name']).'</td>
                                            <td>'.htmlspecialchars($row['movie_name']).'</td>
                                            <td>Theater '.htmlspecialchars($row['theater']).'</td>
                                            <td>'.date('h:i A', strtotime($row['show_time'])).'</td>
                                            <td>'.htmlspecialchars($row['seat']).' ('.htmlspecialchars($row['totalseat']).')</td>
                                            <td class="currency">₹'.number_format($row['price'], 2).'</td>
                                            <td>'.date('d M Y', strtotime($row['booking_date'])).'</td>
                                            <td>'.date('d M Y', strtotime($row['payment_date'])).'</td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">No bookings found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                $('#bookingList tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Add hover effect
            $('tbody tr').hover(
                function() {
                    $(this).css('transform', 'scale(1.01)');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        });
    </script>
</body>
</html>