<?php
include 'config.php';

/**
 * Add or update a blog post.
 */
function saveBlogPost($data)
{
    global $conn;
    $id = $data['id'] ?? null;
    $category_id = $data['category_id'];
    $title = $data['title'];
    $description = $data['description'];
    $short_description = $data['short_description'];
    $status = $data['status'];
    $image = $data['image'];

    if ($id) {
        $sql = "UPDATE blog SET category_id = ?, title = ?, description = ?, short_description = ?, status = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "INSERT INTO blog (category_id, title, description, short_description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
    }

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    if ($id) {
        $stmt->bind_param("isssssi", $category_id, $title, $description, $short_description, $status, $image, $id);
    } else {
        $stmt->bind_param("isssss", $category_id, $title, $description, $short_description, $status, $image);
    }

    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

/**
 * Delete a blog post.
 */
function deleteBlogPost($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

/**
 * Fetch all categories.
 */
function fetchCategories()
{
    global $conn;
    $categories = $conn->query("SELECT id, name FROM category");

    if ($categories === false) {
        die('Query failed: ' . htmlspecialchars($conn->error));
    }

    return $categories->fetch_all(MYSQLI_ASSOC);
}

/**
 * Fetch all blog posts.
 */
function fetchBlogPosts()
{
    global $conn;
    $sql = "SELECT blog.id, blog.title, blog.created_at, blog.image, blog.description, blog.short_description, blog.status, category.name AS category_name
            FROM blog
            JOIN category ON blog.category_id = category.id";
    $result = $conn->query($sql);

    if ($result === false) {
        die('Query failed: ' . htmlspecialchars($conn->error));
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Handle form submission to add or edit a blog post.
 */
function handleBlogPostSubmission($postData, $fileData)
{
    global $conn;
    // Validate required fields
    if (empty($postData['category_id']) || empty($postData['title']) || empty($postData['description'])) {
        $response = ['status' => 'error', 'message' => 'All fields are required.'];
        echo json_encode($response);
        return;
    }

    // Process and sanitize inputs
    $id = isset($postData['id']) ? intval($postData['id']) : null;
    $category_id = intval($postData['category_id']);
    $title = htmlspecialchars(trim($postData['title']));
    $description = htmlspecialchars(trim($postData['description']));
    $short_description = htmlspecialchars(trim($postData['short_description']));
    $status = htmlspecialchars(trim($postData['status']));
    $image = '';

    // Handle file upload
    if (isset($fileData['image']) && $fileData['image']['error'] == 0) {
        $image = basename($fileData['image']['name']);
        $target_path = '/var/www/html/phpwork/projectwork/images/' . $image;
        if (!move_uploaded_file($fileData['image']['tmp_name'], $target_path)) {
            $image = '';
        }
    }

    // Insert or update the blog post in the database
    if ($id) {
        // Update existing post
        $sql = "UPDATE blog SET category_id = ?, title = ?, description = ?, short_description = ?, status = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
    } else {
        // Insert new post
        $sql = "INSERT INTO blog (category_id, title, description, short_description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
    }

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    if ($id) {
        $stmt->bind_param("isssssi", $category_id, $title, $description, $short_description, $status, $image, $id);
    } else {
        $stmt->bind_param("isssss", $category_id, $title, $description, $short_description, $status, $image);
    }

    // Execute the query
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    header('Location: blog-admin.php');
    exit();
}

/**
 * Handle delete request for a blog post.
 */
function handleDeleteBlogPost($id)
{
    deleteBlogPost($id);

    // Redirect after deletion
    header('Location: blog-admin.php');
    ob_end_flush();
    exit();
}
?>