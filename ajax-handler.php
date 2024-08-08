<?php
include 'config.php';
include 'functions.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle comment submission via AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $response = array();

    $blog_id = isset($_POST["blog_id"]) ? intval($_POST["blog_id"]) : null;
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : '';
    $website = isset($_POST["website"]) ? htmlspecialchars(trim($_POST["website"])) : '';
    $message = isset($_POST["message"]) ? htmlspecialchars(trim($_POST["message"])) : '';

    if (empty($name) || empty($email) || empty($message) || !$blog_id) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email format.';
    } else {
        $result = insertComment($blog_id, $name, $email, $website, $message);
        if ($result['status'] === 'success') {
            $response['status'] = 'success';
            $response['html'] = generateCommentHTML($name, $message, date('Y-m-d H:i:s'));
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to submit comment: ' . $result['message'];
        }
    }

    echo json_encode($response);
    exit;
}
