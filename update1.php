<?php
session_start(); // start the session

if (isset($_SESSION['cashier_email'])) {
    // customer ID is set, do something with it
    $cashier_email = $_SESSION['cashier_email'];
} else {
    // customer ID is not set, redirect to login page
    header('Location: login.php');
    exit();
}
include "connectdb.php"; // include database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"]) && isset($_POST["food_name"]) && isset($_POST["price"])) {
    // Retrieve the product_id, food_name, and price from the form
    $product_id = $_POST["product_id"];
    $food_name = $_POST["food_name"];
    $price = $_POST["price"];

    // Prepare the SQL statement with parameter placeholders
    $sql = "UPDATE food_data SET food_name = '$food_name', price = '$price' WHERE product_id = '$product_id'";

    // Execute the query
    if ($conn->query($sql) == TRUE) {
        echo "Product name and price updated successfully.";
        header('Location: menu(c).php');
        exit();
    } else {
        echo "Error updating product name and price.";
    }
}
?>
