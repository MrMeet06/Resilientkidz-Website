<?php
// Include database configuration
include 'config.php';

// Function to sanitize input data
function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

// Function to validate email format
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to validate phone number format
function validatePhoneNumber($phonenumber)
{
    return preg_match("/^[0-9]{10}$/", $phonenumber);
}

// Function to insert user data into the database
function insertUserData($conn, $fullname, $email, $password, $phonenumber, $date)
{
    $sql = "INSERT INTO user (name, email, password, phonenumber, date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $result = $stmt->bind_param("sssss", $fullname, $email, $password, $phonenumber, $date);
    if ($result === false) {
        throw new Exception("Bind failed: " . htmlspecialchars($stmt->error));
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

// Main logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? sanitizeInput($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $password = isset($_POST['password']) ? password_hash(sanitizeInput($_POST['password']), PASSWORD_BCRYPT) : '';
    $phonenumber = isset($_POST['phonenumber']) ? sanitizeInput($_POST['phonenumber']) : '';
    $date = isset($_POST['date']) ? sanitizeInput($_POST['date']) : '';

    if (empty($fullname) || empty($email) || empty($password) || empty($phonenumber) || empty($date)) {
        die("All fields are required.");
    }

    if (!validateEmail($email)) {
        die("Invalid email format.");
    }

    if (!validatePhoneNumber($phonenumber)) {
        die("Invalid phone number format. It should be 10 digits.");
    }

    try {
        insertUserData($conn, $fullname, $email, $password, $phonenumber, $date);
        // Redirect to home page with a success query parameter
        header("Location: index.php?status=success");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn->close();
?>