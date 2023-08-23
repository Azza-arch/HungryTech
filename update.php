<?php
session_start(); // start the session

if (isset($_SESSION['customer_id'])) {
    // customer ID is set, do something with it
    $customer_id = $_SESSION['customer_id'];
} else {
    // customer ID is not set, redirect to login page
    header('Location: login.php');
    exit();
}
// update.php
include "connectdb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customer_id"]) && isset($_POST["customer_name"])&& isset($_POST["phone_number"])) {
    // Retrieve the customer_id and updated customer_name from the form
    $customer_id = $_POST["customer_id"];
    $customer_name = $_POST["customer_name"];
    $phone_number = $_POST["phone_number"];
    
    // Update the customer_name in the database
    $sql = "UPDATE customer SET customer_name = '$customer_name', phone_number = '$phone_number' WHERE customer_id = $customer_id";
    
    if ($conn->query($sql) == TRUE) {
        echo "Customer name updated successfully.";
        header('location: profile.php');
} else {
    echo "Invalid request.";
}}
?>
