<?php
session_start(); // Start the session
include "connectdb.php";
$stmt = $conn->prepare("INSERT INTO customer (customer_id, customer_name, customer_email, customer_password) VALUES (NULL, :username, :email, :password)");


$stmt->bindParam(":username", $_POST['username']); 
$stmt->bindParam(":email", $_POST['email']); 
$stmt->bindParam(":password", $_POST['password']);

if ($stmt->execute()) {

echo"<font color='blue'>Data is success inserted...</font>";
header('Location: login.php');//terus ke log in page
} else {
echo"<font color='red'>Statement error...</font>"; }

?>