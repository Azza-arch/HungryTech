<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="comment.css">
    <link rel="icon" href="logo.png">
    <title>NDAT</title>
</head>
<body>
<header>
        <nav class="navbar">
            <div class="logo-wrapper">
                <img src="logo.png" alt="Logo" style="height: 10%; width: 20%;">
            </div>
            <div class="menu">
                <ul class="list">
                    <li><a href="main(c).php">Home</a></li>
                    <li><a href="menu(c).php">Menu</a></li>
                    <li><a href="logout(c).php">Log-out</a></li>
                </ul>
            </div>
        </nav>
    </header>
<div style="margin-top:100px;">
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

include "connectdb.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["product_id"])) {
    // Retrieve the product_id from the query parameter
    $product_id = $_GET["product_id"];

    // Prepare the SQL statement with a parameter placeholder
    $sql = "SELECT * FROM food_data WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);

    // Bind the parameter value to the placeholder
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    if ($stmt->rowCount() > 0) { // check if any rows are returned
        $row = $stmt->fetch();

        // Display the form to edit the food name and price
        echo "<table style='border-collapse: collapse; padding: 10px;'>";
        echo "<form action='update1.php' class='update' method='POST' onsubmit='return data_validate();'>";
        echo "<input type='hidden' name='product_id' value='".$row['product_id']."'>";
        echo "<tr><td><label for='food_name'>Food Name:</label>";
        echo "<input type='text' id='food_name' name='food_name' value='".$row['food_name']."' style='padding: 5px 10px; border: none; border-radius: 30px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);'></td></tr>";
        echo "<tr><td><label for='price'>Price:</label>";
        echo "<input type='text' id='price' name='price' value='".$row['price']."0' style='padding: 5px 10px; border: none; border-radius: 30px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);'></td></tr>";
        echo"<tr><td><br></td></tr>";
        echo "<tr><td><input type='submit' value='Update' style='background-color: #2e2e2e; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 30px;'></td></tr>";
        echo "</form>";
        echo "</table>";
        
    } else {
        echo "No data found.";
    }
} else {
    echo "Invalid request.";
}
?>


</div>
<script>
   function data_validate() {
    var food_name = document.getElementById("food_name").value;
    var price = document.getElementById("price").value;

    if (food_name.length === 0 || price.length === 0) {
        alert("Fill in the form");
        return false;
    } else {
        alert("Menu has been updated");
    }
    return true; // Prevent form submission for this example
}
</script>
</body>
</html>
