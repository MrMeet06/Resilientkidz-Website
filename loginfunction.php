<?php
// Database connection (adjust credentials as needed)
include 'config.php'; // Ensure this file connects to your database

/**
 * Fetch user data by email
*/
function getUserByEmail($email)
{
    global $conn; // Assuming $conn is your database connection variable

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return user data as an associative array
    } else {
        return null; // No user found
    }
}

/**
 * Verify user password
 */
function verifyUserPassword($user, $password)
{
    // Assuming the password is hashed in the database
    return password_verify($password, $user['password']);
}

/**
 * Handle user login
 */
function handleLogin()
{
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if (empty($email) || empty($password)) {
            // If any field is empty, show an alert and stop execution
            echo "<script>alert('All fields are required.'); window.location.href='login.php';</script>";
            exit();
        }

        // Fetch user data
        $user = getUserByEmail($email);

        if ($user && verifyUserPassword($user, $password)) {
            // If user is authenticated, store user ID in session and redirect to the home page
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            header('Location: index.php'); // Redirect to home page
            exit();
        } else {
            // Show an error message if authentication fails
            echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.php';</script>";
        }
    }
}
?>