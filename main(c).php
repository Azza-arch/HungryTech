<?php
include "connectdb.php";

session_start(); // Start the session

if (isset($_SESSION['cashier_email'])) {
    // Cashier email is set, do something with it
    $cashier_email = $_SESSION['cashier_email'];
} else {
    // Cashier email is not set, redirect to the login page
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  <link rel="stylesheet" href="mainstyle.css">
  <link rel="icon" href="logo.png">
    <title>HOMEPAGE</title>
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
<?php
// Retrieve data from the orders table
$sql = "SELECT o.order_id, o.customer_id, f.food_name, o.table_no, o.quantity
        FROM orders o
        JOIN food_data f ON o.product_id = f.product_id";

$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    echo "<div><h3>Order List</h3><hr></div>";
    echo "<div style='display: flex; justify-content: center;'>";
    echo "<table style='border: 1px solid black; border-collapse: collapse;'>";
    echo "<tr><th style='border: 1px solid black; background-color:#B3DEE5;'>Order ID</th><th style='border: 1px solid black; background-color:#B3DEE5;'>Customer ID</th><th style='border: 1px solid black; background-color:#B3DEE5;'>Food Name</th><th style='border: 1px solid black; background-color:#B3DEE5;'>Table No</th><th style='border: 1px solid black; background-color:#B3DEE5;'>Quantity</th></tr>";

    while ($row = $result->fetch()) {
        echo "<tr>";
        echo "<td style='border: 1px solid black;'>" . $row['order_id'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['customer_id'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['food_name'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['table_no'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['quantity'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</div>";
    
} else {
    echo "No data";
}
?>


</body>
<footer>
  <table>
  <hr>
    <tr><th>Menu</th><th>About Us</th></tr>
    <tr><td>Food</td><td>Our Company</td></tr>
    <tr><td>Drinks</td></tr>
  </table>
</footer>
</html>

