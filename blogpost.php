<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $short_description = isset($_POST['short_description']) ? $_POST['short_description'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';

    $image = uploadImage(); // Handle file upload

    if (empty($image)) {
        $image = ''; // If upload fails, set image to an empty string
    }

    if (!empty($title) && !empty($description)) {
        $result = insertBlogPost($category_id, $title, $description, $short_description, $status, $image);
        echo '<div class="alert alert-' . ($result['status'] === 'success' ? 'success' : 'danger') . '">' . $result['message'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">All fields are required.</div>';
    }
}

$posts = fetchAllBlogPosts();
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
        if (!empty($posts)) {
            echo '<table class="table table-bordered mt-5"><thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Category</th><th>Created At</th><th>Image</th></tr></thead><tbody>';
            foreach ($posts as $post) {
                $imageSrc = !empty($post["image"]) ? '/phpwork/projectwork/images/' . $post["image"] : '/phpwork/projectwork/images/program-img1.jpg';
                echo '<tr><td>' . htmlspecialchars($post["id"]) . '</td><td>' . htmlspecialchars($post["title"]) . '</td><td>' . htmlspecialchars($post["category_name"]) . '</td><td>' . htmlspecialchars($post["created_at"]) . '</td><td><img src="' . htmlspecialchars($imageSrc) . '" alt="Image" style="width:100px;"></td></tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">No blog posts found.</div>';
        }
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