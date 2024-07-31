<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle comment submission
    $response = array();

    // Retrieve and sanitize input data
    $blog_id = intval($_POST["blog_id"]);
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $website = htmlspecialchars(trim($_POST["website"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate input data
    if (empty($name) || empty($email) || empty($message)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email format.';
    } else {
        // Insert comment into database
        $stmt = $conn->prepare("INSERT INTO comments (blog_id, name, email, website, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("issss", $blog_id, $name, $email, $website, $message);

        if ($stmt->execute()) {
            // Prepare the HTML for the new comment to be appended via AJAX
            $comment_html = "
                <li>
                    <div class='user-comment'>
                        <div class='author-img'>
                            <img alt='' src='images/author.jpg' class='avatar avatar-86 photo' height='86' width='86' loading='lazy' decoding='async'>
                        </div>
                        <div class='comment-content'>
                            <div class='comment-content-top'>
                                <h5>" . htmlspecialchars($name) . " || " . date('F j, Y, g:i a') . "</h5>
                            </div>
                            <p>" . htmlspecialchars($message) . "</p>
                        </div>
                    </div>
                </li>";
            $response['status'] = 'success';
            $response['html'] = $comment_html;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to submit comment.';
        }

        $stmt->close();
    }

    echo json_encode($response);
    $conn->close();
    exit;
} else {
    // Display comments for the specific blog post
    if (isset($blog_id)) {
        $stmt = $conn->prepare("SELECT name, message, created_at FROM comments WHERE blog_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
?>
        <div id="comments" class="comments-area">
            <div class="blog-comments">
                <div class="blog-comments-section">
                    <div class="comment-main-title section-bg-color">Comments (<?php echo $result->num_rows; ?>)</div>
                    <ul class="comments">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li>
                                <div class='user-comment'>
                                    <div class='author-img'>
                                        <img alt='' src='images/author.jpg' class='avatar avatar-86 photo' height='86' width='86' loading='lazy' decoding='async'>
                                    </div>
                                    <div class='comment-content'>
                                        <div class='comment-content-top'>
                                            <h5>" . htmlspecialchars($row['name']) . " || " . date('F j, Y, g:i a', strtotime($row['created_at'])) . "</h5>
                                            <div class='comment-reply-btn'>
                                                <a class='comment-reply-link' href='#'><i class='fas fa-reply'></i> Reply</a>
                                            </div>
                                        </div>
                                        <p>" . htmlspecialchars($row['message']) . "</p>
                                    </div>
                                </div>
                              </li>";
                            }
                        } else {
                            echo "<li class='no-comments-message'>No comments yet.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
<?php
        $stmt->close();
    } else {
        echo "No blog ID provided.";
    }

    $conn->close();
}
?>