<?php
include 'config.php'; // Ensure this contains your database connection logic

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateInput($data)
{
    $errors = [];
    // Validate name
    if (empty($data['name']) || !preg_match("/^[a-zA-Z ]*$/", $data['name'])) {
        $errors['name'] = "Invalid name";
    }

    // Validate email
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email";
    }

    // Validate message
    if (empty($data['message'])) {
        $errors['message'] = "Message is required";
    }
    return $errors;
}

function insertContactData($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO contactus (name, organisation_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");

    if ($stmt === false) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("sssss", $data['name'], $data['organisation'], $data['email'], $data['phone'], $data['message']);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute statement: " . $stmt->error);
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputData = [
        'name' => sanitizeInput($_POST["name"]),
        'organisation' => sanitizeInput($_POST["organisation"] ?? ''),
        'email' => sanitizeInput($_POST["email"]),
        'phone' => sanitizeInput($_POST["phone"] ?? ''),
        'message' => sanitizeInput($_POST["message"])
    ];

    $errors = validateInput($inputData);

    if (empty($errors)) {
        try {
            insertContactData($inputData);
            // Redirect with a success query parameter
            header("Location: contact.php?success=true");
            exit();
        } catch (Exception $e) {
            echo '<script>alert("Error: ' . htmlspecialchars($e->getMessage()) . '");</script>';
        }
    } else {
        foreach ($errors as $field => $error) {
            echo '<script>alert("' . htmlspecialchars($error) . '");</script>';
        }
    }
}
?>