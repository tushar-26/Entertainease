<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Movie Management | Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .movie-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .movie-poster {
            width: 100px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid #dee2e6;
        }
        .form-control-file {
            border: 2px dashed #dee2e6;
            padding: 15px;
        }
        .custom-checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }
        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
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

            <div class="main-content" style="margin-left: 0">
                <div class="movie-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Movie Management</h2>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_movie_modal">
                            + Add New Movie
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Poster</th>
                                    <th>Movie Name</th>
                                    <th>Director</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include_once 'Database.php';
                                $result = mysqli_query($conn, "SELECT * FROM add_movie");

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $image_path = 'image/'.$row['image'];
                                        $fallback_image = 'image/default-movie.png';
                                ?>
                                <tr>
                                    <td>
                                        <img src="<?= file_exists($image_path) ? $image_path : $fallback_image ?>" 
                                             class="movie-poster" 
                                             alt="<?= htmlspecialchars($row['movie_name']) ?>">
                                    </td>
                                    <td><?= htmlspecialchars($row['movie_name']) ?></td>
                                    <td><?= htmlspecialchars($row['directer']) ?></td>
                                    <td><?= htmlspecialchars($row['categroy']) ?></td>
                                    <td>
                                        <span class="badge <?= $row['action'] === 'running' ? 'badge-success' : 'badge-warning' ?>">
                                            <?= ucfirst($row['action']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" 
                                                data-toggle="modal" 
                                                data-target="#edit_movie_modal<?= $id ?>">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" 
                                                data-toggle="modal" 
                                                data-target="#delete_movie_modal<?= $id ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Movie Modal -->
                                <div class="modal fade" id="edit_movie_modal<?= $id ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Movie Details</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="insert_data.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="e_id" value="<?= $id ?>">
                                                    <input type="hidden" name="old_image" value="<?= $row['image'] ?>">
                                                    
                                                    <div class="form-section">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Movie Title</label>
                                                                    <input type="text" name="edit_movie_name" 
                                                                           value="<?= htmlspecialchars($row['movie_name']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Director</label>
                                                                    <input type="text" name="edit_directer_name" 
                                                                           value="<?= htmlspecialchars($row['directer']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Release Date</label>
                                                                    <input type="date" name="edit_release_date" 
                                                                           value="<?= htmlspecialchars($row['release_date']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Category</label>
                                                                    <input type="text" name="edit_category" 
                                                                           value="<?= htmlspecialchars($row['categroy']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Language</label>
                                                                    <input type="text" name="edit_language" 
                                                                           value="<?= htmlspecialchars($row['language']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>YouTube Trailer Link</label>
                                                                    <input type="url" name="edit_youtube_link" 
                                                                           value="<?= htmlspecialchars($row['you_tube_link']) ?>" 
                                                                           class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Movie Status</label>
                                                                    <select name="edit_action" class="form-control" required>
                                                                        <option value="running" <?= $row['action'] === 'running' ? 'selected' : '' ?>>Running</option>
                                                                        <option value="upcoming" <?= $row['action'] === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-section">
                                                        <div class="form-group">
                                                            <label>Update Poster</label>
                                                            <div class="custom-file">
                                                                <input type="file" name="edit_img" 
                                                                       class="custom-file-input" 
                                                                       id="editImage<?= $id ?>">
                                                                <label class="custom-file-label" 
                                                                       for="editImage<?= $id ?>">Choose new poster</label>
                                                            </div>
                                                            <small class="form-text text-muted">
                                                                Current: <?= $row['image'] ?>
                                                            </small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Show Times</label>
                                                            <div class="custom-checkbox-group">
                                                                <?php
                                                                $selected_shows = explode(',', $row['show']);
                                                                $shows = mysqli_query($conn, "SELECT * FROM theater_show");
                                                                while($show = mysqli_fetch_assoc($shows)) {
                                                                    $checked = in_array($show['show'], $selected_shows) ? 'checked' : '';
                                                                ?>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" 
                                                                           name="show[]" 
                                                                           value="<?= $show['show'] ?>" 
                                                                           id="show<?= $show['id'] ?>_<?= $id ?>" 
                                                                           class="custom-control-input" <?= $checked ?>>
                                                                    <label class="custom-control-label" 
                                                                           for="show<?= $show['id'] ?>_<?= $id ?>">
                                                                        <?= $show['show'] ?>
                                                                    </label>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-section">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="edit_description" class="form-control" rows="4" required><?= htmlspecialchars($row['decription']) ?></textarea>
                                                        </div>
                                                    </div>

                                                    <button type="submit" name="updatemovie" 
                                                            class="btn btn-primary btn-block">
                                                        Update Movie
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete_movie_modal<?= $id ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete "<strong><?= htmlspecialchars($row['movie_name']) ?></strong>"?</p>
                                                <form action="insert_data.php" method="POST">
                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="deletemovie" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Movie Modal -->
    <div class="modal fade" id="add_movie_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Movie</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_data.php" method="POST" enctype="multipart/form-data" onsubmit="return validateMovieForm()">
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Movie Title</label>
                                        <input type="text" name="movie_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Director</label>
                                        <input type="text" name="directer_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Release Date</label>
                                        <input type="date" name="release_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="category" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Language</label>
                                        <input type="text" name="language" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>YouTube Trailer Link</label>
                                        <input type="url" name="youtube_link" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Movie Status</label>
                                        <select name="action" class="form-control" required>
                                            <option value="running">Running</option>
                                            <option value="upcoming">Upcoming</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label>Movie Poster</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="moviePoster" required>
                                    <label class="custom-file-label" for="moviePoster">Choose poster image</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Show Times</label>
                                <div class="custom-checkbox-group">
                                    <?php
                                    $shows = mysqli_query($conn, "SELECT * FROM theater_show");
                                    while($show = mysqli_fetch_assoc($shows)) {
                                    ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="show[]" 
                                               value="<?= $show['show'] ?>" 
                                               id="show<?= $show['id'] ?>" 
                                               class="custom-control-input">
                                        <label class="custom-control-label" 
                                               for="show<?= $show['id'] ?>">
                                            <?= $show['show'] ?>
                                        </label>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block">
                            Add Movie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // File input label update
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Form validation
        function validateMovieForm() {
            const requiredFields = document.querySelectorAll('#add_movie_modal [required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Please fill all required fields!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>