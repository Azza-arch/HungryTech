<!DOCTYPE html>
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
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mainstyle.css">
    <link rel="icon" href="logo.png">
    <title>PROFILE</title>
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
    <br><br><br><br><br>
    <?php
    $sql = "SELECT * FROM customer WHERE customer_id = $customer_id"; // select data from the customer table based on customer_id
    $result = $conn->query($sql); // execute the query

    if ($result->rowCount() > 0) { // check if any rows are returned
        echo "<table>"; // start a table
        while ($row = $result->fetch()) { // loop through the rows
            echo "<tr><td><h1>Profile</h1></td></tr>";
            echo "<tr><th>Name</th><td>".$row['customer_name']."</td><td><a href='edit.php?customer_id=".$row['customer_id']."'>Edit</a></td></tr>"; // display each row in a table row with an edit link
            echo "<tr><th>Email</th><td>".$row['customer_email']."</td></tr>";
            echo "<tr><th>Phone No</th><td>".$row['phone_number']."</td></tr>";
            // echo"<tr><th>Phone No</th><td>".$row['customer_email']."</td></tr>";
        }
        echo "</table>"; // end the table
    } else {
        echo "No data found."; // display message if no rows are returned
    }
    ?>
</body>
</html>
