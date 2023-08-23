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
    <div class="mmenu-container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["customer_id"])) {
            // Retrieve the customer_id from the query parameter
            $customer_id = $_GET["customer_id"];

            // Retrieve the customer details from the database based on the customer_id
            $sql = "SELECT * FROM customer WHERE customer_id = $customer_id";
            $result = $conn->query($sql);

            if ($result->rowCount() > 0) { // check if any rows are returned
                $row = $result->fetch();
        ?>
                <table style="border-collapse: collapse; margin-top: 50px;">
        
                    <form action="update.php" class="update" method="POST" onsubmit="return data_validate();">
                        <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                        <tr>
                            <td>
                                <h1>Profile</h1>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="customer_name">Customer Name:</label>
                                <input class="edit" type="text" id="customer_name" name="customer_name" value="<?php echo $row['customer_name']; ?>" style="padding: 5px 10px; border: none; border-radius: 30px">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="phone_number">Customer Email:</label>
                                <input class="edit" type="int" id="phone_number" name="phone_number"  value="<?php echo $row['phone_number']; ?>" style="padding: 5px 10px; border: none; border-radius: 30px">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="customer_name">Customer Email:</label>
                                <input class="edit" type="text" id="customer_email" name="customer_email" readonly value="<?php echo $row['customer_email']; ?>" style="padding: 5px 10px; border: none; border-radius: 30px">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="edit" type="submit" value="Update" style="background-color: #2e2e2e; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 30px;">
                            </td>
                        </tr>
                    </form>
                </table>
        <?php
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
            var customer_email = document.getElementById("customer_email").value;
            var customer_name = document.getElementById("customer_name").value;
            var customer_name = document.getElementById("phone_number").value;
            var msg = "";

            if (customer_email.length == 0 || customer_name.length == 0 || phone_number.length == 0) {
                alert("Fill in the form");
                return false;
            } else {
                alert("Your profile has been updated");
            }
            return true; // Prevent form submission for this example
        }
    </script>
</body>
</html>
