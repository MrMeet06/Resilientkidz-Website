<?php
// Include database configuration
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : '';
    $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    // Debugging information
    echo "Full Name: " . htmlspecialchars($fullname) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Phone Number: " . htmlspecialchars($phonenumber) . "<br>";
    echo "Date: " . htmlspecialchars($date) . "<br>";

    // Check if any required fields are empty
    if (empty($fullname) || empty($email) || empty($password) || empty($phonenumber) || empty($date)) {
        die("All fields are required.");
    }

    // Prepare and bind
    $sql = "INSERT INTO user (name, email, password, phonenumber, date) VALUES (?, ?, ?, ?, ?)";
    $stmtinsert = $conn->prepare($sql);

    if ($stmtinsert === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $result = $stmtinsert->bind_param("sssss", $fullname, $email, $password, $phonenumber, $date);

    if ($result === false) {
        die("Bind failed: " . htmlspecialchars($stmtinsert->error));
    }

    if ($stmtinsert->execute()) {
        echo 'Successfully saved.';
    } else {
        die("Execute failed: " . htmlspecialchars($stmtinsert->error));
    }

    $stmtinsert->close();
} else {
    echo "No data";
}

$conn->close();
?>