<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php'; // Ensure this contains your database connection logic

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve data from POST
    $blog_id = $_POST['blog_id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = $_POST['website'] ?? '';
    $message = trim($_POST['message'] ?? '');

    // Validate input
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit();
    }

    // Get the current date
    $current_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO comments (name, email, website, message, created_at) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . mysqli_error($conn)]);
        exit();
    }
    $stmt->bind_param("sssss", $name, $email, $website, $message, $current_date);

    if ($stmt->execute()) {
        // Fetch the new comment to display it
        $comment_id = $stmt->insert_id;
        $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SELECT statement: ' . mysqli_error($conn)]);
            exit();
        }
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $new_comment = $result->fetch_assoc();

        if ($new_comment) {
            $comment_html = '
                <div class="comment">
                    <ul class="comments">
                        <li>
                            <div class="user-comment">
                                <div class="author-img">
                                    <img alt="" src="images/author.jpg" class="avatar avatar-86 photo" height="86" width="86" loading="lazy" decoding="async">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-content-top">
                                        <h5>' . htmlspecialchars($new_comment['name']) . ' || ' . htmlspecialchars($new_comment['created_at']) . '</h5>
                                        <div class="comment-reply-btn">
                                            <a class="comment-reply-link" href="#"><i class="fas fa-reply"></i> Reply</a>
                                        </div>
                                    </div>
                                    <p>' . htmlspecialchars($new_comment['message']) . '</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>';

            echo json_encode(['status' => 'success', 'html' => $comment_html]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch new comment after insertion.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to execute statement: ' . mysqli_error($conn)]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>