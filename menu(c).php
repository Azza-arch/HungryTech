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

$sql = "SELECT * FROM food_data"; // select data from the customer table based on customer_id
$result = $conn->query($sql); // execute the query
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mainstyle.css">
    <link rel="icon" href="logo.png">
    <title>MENU</title>
</head>
<body>
<header>
    <nav class="navbar">
        <a href="#" class="logo">NDAT-(CASHIER)</a>
        <div class="menu">
            <ul class="list">
                <li><a href="main(c).php">Home</a></li>
                <li><a href="menu(c).php">Menu</a></li>
                
                <li><a href="logout(c).php">Log-out</a></li>
            </ul>
        </div>
    </nav>
</header>
<br><br><br><br>
<form method="GET" action="update1.php" onsubmit="return data_validate();">
    <?php

    if ($result->rowCount() > 0) { // check if any rows are returned
        echo "<div><h3>Food & Drinks</h3><hr></div>"; // table header
        echo "<div style='display: flex; justify-content: center;'>";
        echo "<table style='border: 1px solid black;border-collapse: collapse;'>"; // add border style to the table
        echo "<tr style='background-color:#B3DEE5;;'><th style='border: 1px solid black;'>FOOD NAME</th><th style='border: 1px solid black;'>IMAGE</th><th style='border: 1px solid black;'>PRICE</th><th style='border: 1px solid black;'></th></tr>";
        while ($row = $result->fetch()) { // loop through the rows
            echo "<tr><td style='border: 1px solid black;'>" . $row['food_name'] . "</td><td style='border: 1px solid black;'><img style='height:100px;'src='data:image/jpeg;base64," . base64_encode($row['food_image']) . "' /></td><td style='border: 1px solid black;'>RM " . $row['price'] . "</td><td style='border: 1px solid black;'><a href='edit1.php?product_id=".$row['product_id']."'>Edit</a></td></tr>";
        }
        echo "</table>"; // end the table
        echo "</div>";
    } else {
        echo "No data found."; // display message if no rows are returned
    }    
    ?>
</form>
<div id="popup" class="popup">
    <span id="popup-message"></span>
</div>
<!-- <script>
   function data_validate() {
    var a = document.getElementById("ma").value;
    var msg = "";

    if (a.length == 0) {
        alert("Make an order");
        return false;
    } else {
        alert("Your order has been taken");
    } 
    return true; // Prevent form submission for this example
}
</script> -->

</body>
</html>
