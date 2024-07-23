<?php
include 'config.php';

// Start output buffering
ob_start();

// Handle form submission to add or edit a blog post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $short_description = $_POST['short_description'];
    $status = $_POST['status'];
    $image = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $target_path = '/var/www/html/phpwork/projectwork/images/' . $image;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image = '';
        }
    }

    // Insert or update blog post
    if ($id) {
        $sql = "UPDATE blog SET category_id = ?, title = ?, description = ?, short_description = ?, status = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssi", $category_id, $title, $description, $short_description, $status, $image, $id);
    } else {
        $sql = "INSERT INTO blog (category_id, title, description, short_description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $category_id, $title, $description, $short_description, $status, $image);
    }
    $stmt->execute();
    $stmt->close();

    // Redirect after saving
    header('Location: blog-admin.php');
    ob_end_flush();
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect after deletion
    header('Location: blog-admin.php');
    ob_end_flush();
    exit();
}

// Fetch all categories for the dropdown
$categories = $conn->query("SELECT id, name FROM category");

// Fetch all blog posts
$sql = "SELECT blog.id, blog.title, blog.created_at, blog.image, blog.description, blog.short_description, blog.status, category.name AS category_name
        FROM blog
        JOIN category ON blog.category_id = category.id";
$blogPosts = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-group {
            display: flex;
            gap: 1rem;
            /* Adjust the space between buttons here */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Blog Admin</a>
    </nav>
    <div class="container mt-5">
        <h2>Add / Edit Blog Post</h2>
        <form id="blogForm" method="POST" action="blog-admin.php" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="category_id">Category:</label>
                <div class="input-group">
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php
                        while ($row = $categories->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <div class="input-group-append">
                        <div class="dropdown-menu">
                            <?php
                            $categories->data_seek(0); // Reset the result pointer to the beginning
                            while ($row = $categories->fetch_assoc()) {
                                echo '<a class="dropdown-item" href="#" data-id="' . $row['id'] . '">' . $row['name'] . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
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
            <button type="submit" class="btn btn-primary">Save Blog Post</button>
        </form>
        <h2 class="mt-5">Blog Posts</h2>
        <?php
        if ($blogPosts->num_rows > 0) {
            echo '<table class="table table-bordered mt-5"><thead class="thead-dark"><tr><th>ID</th><th>Title</th><th>Category</th><th>Created At</th><th>Image</th><th>Description</th><th>Short Description</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $blogPosts->fetch_assoc()) {
                $imageSrc = !empty($row["image"]) ? '/phpwork/projectwork/images/' . $row["image"] : '/phpwork/projectwork/images/program-img1.jpg';
                echo '<tr>
                    <td>' . htmlspecialchars($row["id"]) . '</td>
                    <td>' . htmlspecialchars($row["title"]) . '</td>
                    <td>' . htmlspecialchars($row["category_name"]) . '</td>
                    <td>' . htmlspecialchars($row["created_at"]) .'</td>
                    <td><img src="' . htmlspecialchars($imageSrc) . '" alt="Image" style="width:100px;"></td>
                    <td>' . htmlspecialchars($row["description"]) . '</td>
                    <td>' . htmlspecialchars($row["short_description"]) . '</td>
                    <td>' . htmlspecialchars($row["status"]) . '</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm edit-btn" data-id="' . htmlspecialchars($row["id"]) . '">Edit</button>
                            <a href="blog-admin.php?delete=' . htmlspecialchars($row["id"]) . '" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </td>
                </tr>';
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    var categoryId = this.getAttribute('data-id');
                    document.getElementById('category_id').value = categoryId;
                });
            });

            document.querySelectorAll('.edit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var id = row.children[0].innerText.trim();
                    var title = row.children[1].innerText.trim();
                    var category = row.children[2].innerText.trim();
                    var createdAt = row.children[3].innerText.trim();
                    var imageSrc = row.children[4].querySelector('img').src;
                    var description = row.children[5].innerText.trim();
                    var short_description = row.children[6].innerText.trim();
                    var status = row.children[7].innerText.trim();

                    document.getElementById('id').value = id;
                    document.getElementById('title').value = title;
                    document.getElementById('category_id').value = category;
                    document.getElementById('description').value = description;
                    document.getElementById('short_description').value = short_description;
                    document.getElementById('status').value = status;
                    // For image preview, you might need additional logic to handle image display
                });
            });
        });
    </script>
</body>

</html>