<?php
// Include database configuration
include 'config.php';

// Fetch comments from the database
$sql = "SELECT name, message, created_at FROM comments ORDER BY id DESC"; // Assuming you have an 'id' column to sort by
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . htmlspecialchars($conn->error));
}
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
                    echo "<li>No comments yet.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php
$conn->close();
?>