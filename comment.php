<?php
// Include database connection code
include "connectdb.php";

session_start(); // Start the session

if (isset($_SESSION['customer_id'])) {
    // Customer ID is set, do something with it
    $customer_id = $_SESSION['customer_id'];
} else {
    // Customer ID is not set, redirect to login page
    header('Location: login.php');
    exit();
}

if (isset($_GET['product_id'])) {
    // Retrieve the product ID from the URL query parameter
    $product_id = $_GET['product_id'];

    // Set the product ID in the session
    $_SESSION['product_id'] = $product_id;
} else {
    // Redirect to an error page or handle the error as per your requirement
    exit();
}

$sql = "SELECT * FROM feedback WHERE product_id = :product_id"; // Select feedback data based on product_id
$stmt = $conn->prepare($sql); // Prepare the query
$stmt->bindParam(':product_id', $product_id); // Bind the product_id parameter
$stmt->execute(); // Execute the query
$result = $stmt->fetchAll(); // Fetch all rows

$sql1 = "SELECT * FROM feedback"; // Select all feedback data
$stmt1 = $conn->prepare($sql1); // Prepare the query
$stmt1->execute(); // Execute the query
$result1 = $stmt1->fetchAll(); // Fetch all rows

$all_ratings = array_column($result, 'star_rating');
$mean_vote = 0;
if (!empty($all_ratings)) {
    $mean_vote = array_sum($all_ratings) / count($all_ratings);
}


$bayesCount = 0;
$mean_vote_all = 0; // Initialize $mean_vote_all variable
$all_ratings_all = array();

if ($stmt1->rowCount() > 0) {
    $totalRating = $mean_vote_all;
    $customerCount = count($all_ratings_all);

    foreach ($result1 as $row) {
        $totalRating += $row['star_rating'];
        $customerCount++;
    }

    $averageProduct = 0;
    $productCount = 0;

    foreach ($result1 as $row) {
        if ($row['product_id'] == $product_id) {
            $averageProduct += $row['star_rating'];
            $productCount++;
        }
    }

    // Minimum 3 customers' ratings required
    $minCustomerCount = 3;

if ($productCount > 0) {
    $averageProduct = ($averageProduct / $productCount);
} else {
    $averageProduct = 0; // or any other appropriate value when $productCount is zero
}


    $bayesCount = ($productCount / ($productCount + $minCustomerCount)) * $averageProduct + ($minCustomerCount / ($productCount + $minCustomerCount)) * $totalRating;
}


$sql = "SELECT * FROM feedback WHERE product_id = :product_id"; // Select feedback data based on product_id
$stmt = $conn->prepare($sql); // Prepare the query
$stmt->bindParam(':product_id', $product_id); // Bind the product_id parameter
$stmt->execute(); // Execute the query
$result = $stmt->fetchAll(); // Fetch all rows

// Set the retrieved product_id in the session
$_SESSION['product_id'] = $product_id;

$sql1 = "SELECT * FROM feedback"; // Select all feedback data
$stmt1 = $conn->prepare($sql1); // Prepare the query
$stmt1->execute(); // Execute the query
$result1 = $stmt1->fetchAll(); // Fetch all rows

$all_ratings = array_column($result, 'star_rating');
$mean_vote = 0; // Initialize $mean_vote variable

if (count($all_ratings) > 0) {
    $mean_vote = array_sum($all_ratings) / count($all_ratings);
}

// Rest of your code...



// Dynamically generate the styles based on the star_rating value from the database
$starRatingStyles = '';
foreach ($result as $row) {
    $starRating = $row['star_rating'];

    $starRatingStyles .= '.rate1 > input:checked ~ label,
          .rate1 > input:checked + label:hover,
          .rate1 > input:checked + label:hover ~ label {
              color: #ffc700;
          }';

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $starRating) {
            $starRatingStyles .= '.rate1 > input:checked ~ label:nth-child(' . $i . ') {
                    color: #ffc700;
                }';
        } else {
            $starRatingStyles .= '.rate1 > input:checked ~ label:nth-child(' . $i . ') {
                    color: #ccc;
                }';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="comment.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mainstyle.css">
    <link rel="icon" href="logo.png">
    <title>MENU</title>

<style>
    .rate1 {
        float: left;
        height: 46px;
        padding: 0 10px;
    }

    .rate1:not(:checked) > input {
        position: absolute;
        top: -9999px;
    }

    .rate1:not(:checked) > label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate1:not(:checked) > label:before {
        content: '★ ';
    }

    .rate1 > input:checked ~ label {
        color: #ffc700;
    }

    .rate1:not(:checked) > label:hover,
    .rate1:not(:checked) > label:hover ~ label {
        color: #ffc700;
    }

    .rate1 > input:checked + label:hover,
    .rate1 > input:checked + label:hover ~ label,
    .rate1 > input:checked ~ label:hover,
    .rate1 > input:checked ~ label:hover ~ label,
    .rate1 > label:hover ~ input:checked ~ label {
        color: #ffc700;
    }
</style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo-wrapper">
            <img src="logo.png" style="height: 10%; width: 20%;">
            <span><?php echo "HI " . $_SESSION['customer_name']; ?></span>
        </div>
        <div class="menu">
            <ul class="list">
                <li><a href="ndatmain.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>
<br><br><br>
<?php
echo'<form name="comments" method="POST" action="insertcomment.php">
<table>
    <tr>
        <td>
<div class="rate1">
<input type="radio" id="star5" name="star_rating" value="5" />
<label for="star5" title="text">5 stars</label>
<input type="radio" id="star4" name="star_rating" value="4" />
<label for="star4" title="text">4 stars</label>
<input type="radio" id="star3" name="star_rating" value="3" />
<label for="star3" title="text">3 stars</label>
<input type="radio" id="star2" name="star_rating" value="2" />
<label for="star2" title="text">2 stars</label>
<input type="radio" id="star1" name="star_rating" value="1" />
<label for="star1" title="text">1 star</label>
</div>
        </td>
    </tr>
    <tr>
        <td><textarea rows="10" cols="30" name="comments" placeholder="Write your comment here" required></textarea></td>
    </tr>
    <tr>
        <td><input type="submit" name="submit" value="Submit" class="button"></td>
    </tr>
</table>
</form>';
echo "<table style='margin-top:100px;'>"; // Start a table
echo "<tr><th>Comment</th><th>Star Rating</th></tr>"; // Table header
if ($stmt->rowCount() > 0) { // Check if any feedback rows are returned
    foreach ($result as $row) { // Loop through the feedback rows
        echo "<tr><td>" . $row['comments'] . "</td>";
        echo "<td>";
        echo '<div>';
        echo "<td>" . $row['star_rating'] ;
        echo '</div>';
        echo "</td></tr>";
        echo "<tr><td><hr></td></tr>";
    }
   
} else {
    echo "No data found."; // Display message if no feedback rows are returned

}    echo "</table>"; // End the table
$all_ratings = array_column($result, 'star_rating');
$mean_vote = 0; // Initialize $mean_vote variable

if (count($all_ratings) > 0) {
    $mean_vote = array_sum($all_ratings) / count($all_ratings);
}

$bayesCount = 0;

if ($stmt1->rowCount() > 0) {
    $totalRating = $mean_vote;
    $customerCount = count($all_ratings);

    foreach ($result1 as $row) {
        $totalRating += $row['star_rating'];
        $customerCount++;
    }

    if (!empty($all_ratings)) {
        $averageAll = array_sum($all_ratings) / count($all_ratings);
    } else {
        // Handle the case when the array is empty
        // For example, you could assign a default value to $averageAll or show an error message.
    }
    
    $averageProduct = 0;
    $productCount = 0;

    foreach ($result1 as $row) {
        if ($row['product_id'] == $product_id) {
            $averageProduct += $row['star_rating'];
            $productCount++;
        }
    }

    // Minimum 3 customers' ratings required
    $minCustomerCount = 3;

    if ($productCount > 0) {
        $averageProduct = ($averageProduct / $productCount);
    }

    $bayesCount = ($productCount / ($productCount + $minCustomerCount)) * $averageProduct + ($minCustomerCount / ($productCount + $minCustomerCount)) * $averageAll;
}

// Rest of your code...

echo "Bayesian Star Rating for Product ID $product_id: " . number_format($bayesCount, 1);

$bayes_rating = number_format($bayesCount, 1); // Format the bayesCount to 1 decimal place

$updateSql = "UPDATE food_data SET bayes_rating = :bayes_rating WHERE product_id = :product_id";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bindParam(':bayes_rating', $bayes_rating); // Use $bayes_rating instead of $bayesCount
$updateStmt->bindParam(':product_id', $product_id);
$updateStmt->execute();

?>
<br><br><br><br><br>
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

