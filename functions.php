<?php
include 'config.php';

// Helper function to execute a query and return all rows
function executeQuery($query, $params = [], $fetchAll = true)
{
    global $conn;

    if ($stmt = $conn->prepare($query)) {
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($fetchAll) {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $stmt->close();
            return $rows;
        } else {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row;
        }
    } else {
        die("ERROR: Could not prepare query: " . $conn->error);
    }
}

// Function to fetch all categories
function getCategories()
{
    $sql = "SELECT * FROM `category2`";
    return executeQuery($sql);
}

// Function to fetch a single category by ID
function getCategoryById($categoryId)
{
    $sql = "SELECT * FROM `category2` WHERE `id` = ?";
    return executeQuery($sql, [$categoryId], false);
}

// Function to fetch all programs
function getPrograms()
{
    $sql = "SELECT * FROM `programs`";
    $programs = executeQuery($sql);

    // Append category names to each program
    foreach ($programs as &$program) {
        $category = getCategoryById($program['category2']);
        $program['category_name'] = $category['name'];
    }

    return $programs;
}

// Function to get a blog post by ID
function getBlogPostById($blog_id)
{
    $sql = "SELECT * FROM blog WHERE id = ?";
    return executeQuery($sql, [$blog_id], false);
}

// Function to get a blog post by ID, or handle errors if not found
function getBlogPostByIdOrFail($blog_id)
{
    $blog_post = getBlogPostById($blog_id);

    if (!$blog_post) {
        die("ERROR: Blog post not found.");
    }

    return $blog_post;
}

// Function to check if blog ID is set and fetch the blog post
function getBlogPostWithId()
{
    if (isset($_GET['id'])) {
        $blog_id = intval($_GET['id']);
        return getBlogPostByIdOrFail($blog_id);
    } else {
        die("ERROR: No blog ID provided.");
    }
}
//blog Function
function getBlogPosts($conn)
{
    $sql = "SELECT blog.title, blog.short_description, blog.created_at, blog.id, blog.image, category.name AS category_name 
            FROM blog
            JOIN category ON blog.category_id = category.id";
    $result = $conn->query($sql);

    $blogs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $blog_id = $row["id"];
            // Fetch the number of comments for this blog post
            $comment_sql = "SELECT COUNT(*) AS comment_count FROM comments WHERE blog_id = ?";
            $stmt = $conn->prepare($comment_sql);
            $stmt->bind_param("i", $blog_id);
            $stmt->execute();
            $comment_result = $stmt->get_result();
            $comment_row = $comment_result->fetch_assoc();
            $row['comment_count'] = $comment_row['comment_count'];
            $blogs[] = $row;
        }
    }

    return $blogs;
}

/**
 * Handle file upload for blog post images.
 */
function uploadImage()
{
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $target_path = '/var/www/html/phpwork/projectwork/images/' . $image;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            return $image;
        }
    }
    return '';
}

/**
 * Insert a new blog post into the database.
 */
function insertBlogPost($category_id, $title, $description, $short_description, $status, $image)
{
    global $conn;

    $sql = "INSERT INTO blog (category_id, title, description, short_description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return ["status" => "error", "message" => "Prepare failed: " . htmlspecialchars($conn->error)];
    }

    $stmt->bind_param("isssss", $category_id, $title, $description, $short_description, $status, $image);
    $result = $stmt->execute();

    if ($result) {
        $stmt->close();
        return ["status" => "success", "message" => "Blog post added successfully."];
    } else {
        return ["status" => "error", "message" => "Execute failed: " . htmlspecialchars($stmt->error)];
    }
}

/**
 * Handle form submission to add a new category.
 */
function addCategory($name)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
    if ($stmt === false) {
        return ['status' => 'error', 'message' => 'Prepare failed: ' . htmlspecialchars($conn->error)];
    }

    $stmt->bind_param("s", $name);
    $result = $stmt->execute();

    if ($result) {
        $id = $stmt->insert_id;
        $created_at = date('Y-m-d H:i:s');
        $stmt->close();
        return ['status' => 'success', 'id' => $id, 'name' => $name, 'created_at' => $created_at];
    } else {
        return ['status' => 'error', 'message' => 'Execute failed: ' . htmlspecialchars($stmt->error)];
    }
}

/**
 * Fetch all categories from the database.
 */
function fetchCategories()
{
    global $conn;

    $sql = "SELECT * FROM category ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}
/**
 * Fetch all blog posts from the database.
 */
function fetchAllBlogPosts()
{
    global $conn;
    $sql = "SELECT blog.id, blog.title, blog.created_at, blog.image, category.name AS category_name
            FROM blog
            JOIN category ON blog.category_id = category.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    } else {
        return [];
    }
}

// Insert a new comment into the database
function insertComment($blog_id, $name, $email, $website, $message)
{
    global $conn;

    $sql = "INSERT INTO comments (blog_id, name, email, website, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return ["status" => "error", "message" => "Prepare failed: " . htmlspecialchars($conn->error)];
    }

    $stmt->bind_param("issss", $blog_id, $name, $email, $website, $message);
    $result = $stmt->execute();

    if ($result) {
        $stmt->close();
        return ["status" => "success", "comment_id" => $conn->insert_id];
    } else {
        return ["status" => "error", "message" => "Execute failed: " . htmlspecialchars($stmt->error)];
    }
}

// Fetch comments for a blog post
function fetchComments($blog_id)
{
    $sql = "SELECT name, message, created_at FROM comments WHERE blog_id = ? ORDER BY id DESC";
    return executeQuery($sql, [$blog_id]);
}

// Generate HTML for a single comment
function generateCommentHTML($name, $message, $created_at)
{
    return "
    <li>
        <div class='user-comment'>
            <div class='author-img'>
                <img alt='' src='images/author.jpg' class='avatar avatar-86 photo' height='86' width='86' loading='lazy' decoding='async'>
            </div>
            <div class='comment-content'>
                <div class='comment-content-top'>
                    <h5>" . htmlspecialchars($name) . " || " . date('F j, Y, g:i a', strtotime($created_at)) . "</h5>
                </div>
                <p>" . htmlspecialchars($message) . "</p>
            </div>
        </div>
    </li>";
}

// Handle comment submission via AJAX
function handleCommentSubmission()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = array();

        $blog_id = isset($_POST["blog_id"]) ? intval($_POST["blog_id"]) : null;
        $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : '';
        $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : '';
        $website = isset($_POST["website"]) ? htmlspecialchars(trim($_POST["website"])) : '';
        $message = isset($_POST["message"]) ? htmlspecialchars(trim($_POST["message"])) : '';

        if (empty($name) || empty($email) || empty($message) || !$blog_id) {
            $response['status'] = 'error';
            $response['message'] = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid email format.';
        } else {
            $result = insertComment($blog_id, $name, $email, $website, $message);
            if ($result['status'] === 'success') {
                $response['status'] = 'success';
                $response['html'] = generateCommentHTML($name, $message, date('Y-m-d H:i:s'));
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to submit comment.';
            }
        }

        echo json_encode($response);
        exit;
    }
}

// Fetch and display comments
function displayComments($blog_id)
{
    $comments = fetchComments($blog_id);
    $comments_html = "<div class='blog-comments'>
        <div class='blog-comments-section'>
            <div class='comment-main-title section-bg-color'>Comments (" . count($comments) . ")</div>
            <ul class='comments' id='comments-ul'>";

    if ($comments) {
        foreach ($comments as $comment) {
            $comments_html .= generateCommentHTML($comment['name'], $comment['message'], $comment['created_at']);
        }
    } else {
        $comments_html .= "<li class='no-comments-message'>No comments yet.</li>";
    }

    $comments_html .= "</ul>
        </div>
    </div>";

    return $comments_html;
}
?>