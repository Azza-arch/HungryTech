<?php
session_start(); // Start the session

if (isset($_SESSION['customer_id'])) {
    // Customer ID is set, do something with it
    $customer_id = $_SESSION['customer_id'];
} else {
    // Customer ID is not set, redirect to login page
    header('Location: login.php');
    exit();
}

include "connectdb.php"; // Include your database connection file

// Check if the required session key 'product_id' is set
if (isset($_SESSION['product_id'])) {
    // Retrieve the product ID from the session
    $product_id = $_SESSION['product_id'];

    // Check if comments field is not empty
    if (!empty($_POST['comments'])) {
        $comments = $_POST['comments'];
        $star_rating = $_POST['star_rating'];

        $stmt = $conn->prepare("INSERT INTO feedback (product_id, customer_id, comments, star_rating) VALUES (?, ?, ?, ?)");

        // Bind the parameters
        $stmt->execute([$product_id, $customer_id, $comments, $star_rating]);

        if ($stmt->rowCount() > 0) {
            echo "<font color='blue'>Data successfully inserted...</font>";
            header('Location: comment.php?product_id=' . $product_id);
            exit(); // Add an exit statement after the header to terminate the script execution
        } else {
            echo "<font color='red'>Statement error...</font>";
        }
    } else {
        header('Location: comment.php?product_id=' . $product_id);
        exit(); // Add an exit statement after the header to terminate the script execution
    }
}
?>