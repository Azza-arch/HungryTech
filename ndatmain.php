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

$sql = "SELECT * FROM food_data ORDER BY bayes_rating DESC"; // select data from the food_data table
$result = $conn->query($sql); // execute the query
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mainstyle.css">
    <link rel="icon" href="logo.png">
    <title>MAINPAGE</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo-wrapper">
                <img src="logo.png" alt="Logo" style="height: 10%; width: 20%;">
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
    <br><br>
    <div class="mmenu-container">
        <h1>BEST DEAL</h1>
        <?php
        $counter = 0; // Counter variable to track the number of iterations

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                if ($counter >= 5) {
                    break; // Exit the loop once 5 rows have been displayed
                }
                echo "<div class='mmenu'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['food_image']) . "' />";
                echo "<p>" . $row['food_name'] . "<br>RM " . $row['price'] . "0</p>";
                echo "<a href='menu.php?product_id=".$row['product_id']."'>
                        <button class='btn1'>Order</button></a><br>";
                echo "</div>";

                $counter++; // Increment the counter
            }
        } else {
            echo "No data found."; // Display message if no rows are returned
        }
        ?>
    </div>
          
    <section class="section">
        <img class="bg" src="nasbg.png" alt="Background Image" style="height: 80%; width: 20% ;">
        <h1>NDAT</h1>
        <h2>PROMOTION</h2>
    </section>

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

