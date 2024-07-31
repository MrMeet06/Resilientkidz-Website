<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Ensure this contains your database connection logic

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize error messages
    $nameErr = $emailErr = $messageErr = "";
    $isValid = true;

    // Sanitize and validate name
    $name = test_input($_POST["name"]);
    if (empty($name)) {
        $nameErr = "Name is required";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
        $isValid = false;
    }

    // Sanitize and validate email
    $email = test_input($_POST["email"]);
    if (empty($email)) {
        $emailErr = "Email is required";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
    }

    // Sanitize and validate message
    $message = test_input($_POST["message"]);
    if (empty($message)) {
        $messageErr = "Message is required";
        $isValid = false;
    }

    // Other fields (optional)
    $organisation = test_input($_POST["organisation"] ?? '');
    $phone = test_input($_POST["phone"] ?? '');

    // Check if there are any validation errors
    if ($isValid) {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO contactus (name, organisation_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            echo '<script>alert("Failed to prepare statement: ' . htmlspecialchars($conn->error) . '");</script>';
            exit();
        }
        $stmt->bind_param("sssss", $name, $organisation, $email, $phone, $message);

        if ($stmt->execute()) {
            // Redirect to the same page with a success query parameter
            header("Location: contact.php?success=true");
            exit();
        } else {
            echo '<script>alert("Failed to execute statement: ' . htmlspecialchars($stmt->error) . '");</script>';
        }

        $stmt->close();
        $conn->close();
    } else {
        // Display validation errors
        $errors = [$nameErr, $emailErr, $messageErr];
        foreach ($errors as $error) {
            if (!empty($error)) {
                echo '<script>alert("' . htmlspecialchars($error) . '");</script>';
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>  