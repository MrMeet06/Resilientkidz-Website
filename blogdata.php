<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $website = isset($_POST['website']) ? $_POST['website'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Check if any required fields are empty
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Prepare and bind
    $sql = "INSERT INTO comments (name, email, website, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . htmlspecialchars($conn->error)]);
        exit;
    }

    $result = $stmt->bind_param("ssss", $name, $email, $website, $message);

    if ($result === false) {
        echo json_encode(["status" => "error", "message" => "Bind failed: " . htmlspecialchars($stmt->error)]);
        exit;
    }

    if ($stmt->execute()) {
        $new_comment_id = $stmt->insert_id;
        $stmt->close();

        // Fetch the new comment
        $new_comment_sql = "SELECT * FROM comments WHERE id = ?";
        $new_stmt = $conn->prepare($new_comment_sql);
        $new_stmt->bind_param("i", $new_comment_id);
        $new_stmt->execute();
        $new_comment_result = $new_stmt->get_result();
        $new_comment = $new_comment_result->fetch_assoc();

        // Return the new comment in HTML format
        $new_comment_html = "
            <div class='comment'>
                <p><strong>{$new_comment['name']}</strong></p>
                <p>{$new_comment['message']}</p>
            </div>
        ";

        echo json_encode(["status" => "success", "html" => $new_comment_html]);
    } else {
        echo json_encode(["status" => "error", "message" => "Execute failed: " . htmlspecialchars($stmt->error)]);
    }
    $conn->close();
}
?>