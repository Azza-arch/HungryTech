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

$sql = "SELECT * FROM food_data"; // select data from the food_data table
$result = $conn->query($sql); // execute the query

// Retrieve reserved table numbers from the orders table
$sql2 = "SELECT DISTINCT table_no FROM orders";
$reservedTableNumbers = array();
$reservedResult = $conn->query($sql2);
while ($row = $reservedResult->fetch()) {
    $reservedTableNumbers[] = $row['table_no'];
}
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
    <br>
    <form method="POST" action="insertorder.php" onsubmit="return data_validate();">
        <?php
        if ($result->rowCount() > 0) { // check if any rows are returned
            echo "<table class='menu123'>"; // start a table
            echo "<br><br><br><div><h3>Food & Drinks</h3><hr></div>"; // table header
             
            // Function to generate number dropdown
            function generateNumberDropdown($selectName, $reservedTableNumbers)
            {
                echo "<label for='$selectName'>Table:</label>";
                echo "<select class='button' name='$selectName' id='$selectName'>";
                for ($i = 1; $i <= 50; $i++) {
                    if (!in_array($i, $reservedTableNumbers)) {
                        echo "<option value='$i'>$i</option>";
                    }
                }
                echo "</select>";
            }
            
            // Generate number dropdown for table selection excluding reserved table numbers
            generateNumberDropdown("table_number", $reservedTableNumbers);
            while ($row = $result->fetch()) { // loop through the rows
                echo "<tr><td><img style='height:100px;'src='data:image/jpeg;base64," . base64_encode($row['food_image']) . "' /></td></tr>";
                echo "<tr><td>" . $row['food_name'] . "</td><td>RM " . $row['price'] . "</td></tr>";
                echo '<tr class="gap"><td><input type="number" class="bang" id="ma" name="' . $row['product_id'] . '" min="0"></td><td><a href="comment.php?product_id=' . $row['product_id'] . '" class="comment" id="ma" >Komen</a></td></tr>';
            }
            echo '<input type="hidden" name="order_date" value="date("Y-m-d")>';
            echo "</table>"; // end the table
            echo '<button class="btnCART" type="submit"><b>Add</b></button>';
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

