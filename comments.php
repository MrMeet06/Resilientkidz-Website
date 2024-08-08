<?php
include 'functions.php'; // Include the functions file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle the AJAX comment submission
    handleCommentSubmission();
} else {
    // Display comments for a specific blog post
    if (isset($_GET['blog_id'])) {
        $blog_id = intval($_GET['blog_id']);
        echo displayComments($blog_id);
    } else {
        echo "No blog ID provided.";
    }
}
?>