<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $short_description = isset($_POST['short_description']) ? $_POST['short_description'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';

    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $target_path = '/var/www/html/phpwork/projectwork/images/' . $image;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            echo '<div class="alert alert-success">Image uploaded successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to upload image.</div>';
        }
    }
    if (!empty($title) && !empty($description)) {
        try {
            echo $sql = "INSERT INTO blog (category_id, title, description, short_description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssss", $category_id, $title, $description, $short_description, $status, $image);
            $stmt->execute()
            or trigger_error($stmt->error, E_USER_ERROR);
            $stmt->close();
            echo '<div class="alert alert-success">Blog post added successfully.</div>';
        } catch(PDOException $e) {
           echo "Error: " . $e->getMessage();
           exit();
        }

    } else {
        echo '<div class="alert alert-danger">All fields are required.</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Blog Admin</a>
    </nav>
    <div class="container mt-5">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <?php
                    include 'config.php';
                    $result = $conn->query("SELECT id, name FROM category");
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="short_description">Short Description:</label>
                <input type="text" id="short_description" name="short_description" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Add Blog Post</button>
        </form>
        <?php
        include 'config.php';
        $sql = "SELECT blog.id, blog.title, blog.created_at, blog.image, category.name AS category_name
                FROM blog
                JOIN category ON blog.category_id = category.id";
        $result = $conn->query($sql); 

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered mt-5"><thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Category</th><th>Created At</th><th>Image</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                $imageSrc = !empty($row["image"]) ? '/phpwork/projectwork/images/' . $row["image"] : '/phpwork/projectwork/images/program-img1.jpg';
                echo '<tr><td>' . htmlspecialchars($row["id"]) . '</td><td>' . htmlspecialchars($row["title"]) . '</td><td>' . htmlspecialchars($row["category_name"]) . '</td><td>' . htmlspecialchars($row["created_at"]) . '</td><td><img src="' . htmlspecialchars($imageSrc) . '" alt="Image" style="width:100px;"></td></tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">No blog posts found.</div>';
        }
        $conn->close();
        ?>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; 2024 Blog Admin</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>