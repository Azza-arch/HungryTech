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
include "connectdb.php"; // include database connection code

$currentDate = date('Y-m-d'); // Get the current date

$sql = "SELECT o.product_id, f.food_name, o.quantity, o.table_no, f.price
FROM orders o
JOIN food_data f ON o.product_id = f.product_id
WHERE o.customer_id = $customer_id
AND o.order_date = '$currentDate'"; // Add condition to filter results for the current date
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
  <div class="logo-wrapper">
    <img src="logo.png" style="height: 10%; width: 20%;">
    <span><?php echo "HI ".$_SESSION['customer_name']; ?></span>
  </div>
  <div class="menu">
    <ul class="list">
      <li><a href="ndatmain.php">Home</a></li>
      <li><a href="menu.php">Menu</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="logout.php">Log-out</a></li>
    </ul>
  </div>
</nav>
</header>
<?php
if ($result->rowCount() > 0) { // check if any rows are returned
    $total = 0;
    echo "<table style='margin: 80px auto; margin-top: 100px;'>"; // add inline style to center the table
    echo "<tr><th>Nama Makanan</th><th>Jumlah</th></tr>"; // table header
    while ($row = $result->fetch()) { // loop through the rows
        $productTotal = $row['quantity'] * $row['price'];
        $total += $productTotal;

        echo "<tr><td>".$row['food_name']."</td><td>".$row['quantity']."</td></tr>"; // display each row in a table row
    }
    echo "</table>"; // end the table
    echo "Jumlah Harga RM" .$total;
} else {
    echo "No data";
}
?>
<br><br><br><br><br><br><br><br><br>
<footer>
        <hr>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Menu</h3>
            <ul>
                <li><a href="#">Food</a></li>
                <li><a href="#">Drinks</a></li>
                <li><a href="#">Promotions</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>About Us</h3>
            <ul>
                <li><a href="#">Our Company</a></li>
                <li><a href="#">Franchise</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Customer Service</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2023 NDAT. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>

