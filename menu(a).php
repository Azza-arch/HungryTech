<?php
include "connectdb.php"; // include database connection code

$sql = "SELECT * FROM food_data"; // select data from the customer table based on customer_id
$result = $conn->query($sql); // execute the query
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="menu.css">
    <link rel="icon" href="logo.png">
    <title>MENU</title>
</head>
<body>
<header>
<nav class="navbar">
  <div class="logo-wrapper">
    <img src="logo.png" style="height: 10%; width: 20%;">
  </div>
  <div class="menu">
    <ul class="list">
      <li><a href="index.php">Home</a></li>
      <li><a href="menu(a).php">Menu</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </div>
</nav>
</header>
<br>
<form method="POST" action="insertorder.php" onsubmit="return data_validate();">
    <?php
    if ($result->rowCount() > 0) { // check if any rows are returned
        echo "<div class='menu123'>"; // start a div
        echo "<br><br><br><div><h3>Food & Drinks</h3><hr></div>"; // table header
    
        echo "<div class='menu-container'>"; // start a container div
        while ($row = $result->fetch()) { // loop through the rows
            echo "<div class='mmenu'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['food_image']) . "' />";
            echo "<p>" . $row['food_name'] . "<br>RM " . $row['price'] . "0</p>";
            echo "<a href='menu.php?product_id=".$row['product_id']."'></a><br>";
            echo "</div>";    
        }
        echo "</div>"; // end the container div
    
        echo "</div>"; // end the outer div
    } else {
        echo "No data found."; // display message if no rows are returned
    }
    
    ?>
</form>
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
<footer>
  <table>
  <hr>
    <tr><th>Menu</th><th>About Us</th></tr>
    <tr><td>Food</td><td>Our Company</td></tr>
    <tr><td>Drinks</td></tr>
  </table>
</footer>
</html>
