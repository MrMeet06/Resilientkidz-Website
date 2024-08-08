<?php
include 'blog-adminfunction.php'; // Include the functions

// Start output buffering
ob_start();

        // Handle form submission to add or edit a blog post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            handleBlogPostSubmission($_POST, $_FILES);
        }
        // Handle delete request
        if (isset($_GET['delete'])) {
            handleDeleteBlogPost($_GET['delete']);
        }

        // Fetch all categories for the dropdown
        $categories = fetchCategories();

        // Fetch all blog posts
        $blogPosts = fetchBlogPosts();
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
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
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
        <?php if (!empty($blogPosts)) : ?>
            <table class="table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Short Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogPosts as $row) : ?>
                        <?php $imageSrc = !empty($row["image"]) ? '/phpwork/projectwork/images/' . $row["image"] : '/phpwork/projectwork/images/program-img1.jpg'; ?>
                        <tr>
                            <td><?= htmlspecialchars($row["id"]) ?></td>
                            <td><?= htmlspecialchars($row["title"]) ?></td>
                            <td><?= htmlspecialchars($row["category_name"]) ?></td>
                            <td><?= htmlspecialchars($row["created_at"]) ?></td>
                            <td><img src="<?= htmlspecialchars($imageSrc) ?>" alt="Image" style="width:100px;"></td>
                            <td><?= htmlspecialchars($row["description"]) ?></td>
                            <td><?= htmlspecialchars($row["short_description"]) ?></td>
                            <td><?= htmlspecialchars($row["status"]) ?></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="<?= htmlspecialchars($row["id"]) ?>">Edit</button>
                                    <a href="blog-admin.php?delete=<?= htmlspecialchars($row["id"]) ?>" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info">No blog posts found.</div>
        <?php endif; ?>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; 2024 Blog Admin</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/blogadmin.js"></script>
</body>

</html>