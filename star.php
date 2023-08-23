<?php
include "connectdb.php"; // Include database connection code

$sql1 = "SELECT * FROM feedback"; // Select all feedback data
$stmt1 = $conn->prepare($sql1); // Prepare the query
$stmt1->execute(); // Execute the query
$result1 = $stmt1->fetchAll(); // Fetch all rows

$all_ratings = array_column($result1, 'star_rating');
$mean_vote = array_sum($all_ratings) / count($all_ratings);

$bayesCount = 0;

if ($stmt1->rowCount() > 0) {
    $totalRating = $mean_vote;
    $customerCount = count($all_ratings);

    foreach ($result1 as $row) {
        $totalRating += $row['star_rating'];
        $customerCount++;
    }

    $averageAll = array_sum($all_ratings) / count($all_ratings);

    $averageProduct = 0;
    $productCount = 0;

    $sql2 = "SELECT * FROM food_data WHERE product_id = :product_id"; // Select specific product from food_data
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':product_id', $product_id);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();

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
        $bayesCount = ($productCount / ($productCount + $minCustomerCount)) * $averageProduct + ($minCustomerCount / ($productCount + $minCustomerCount)) * $averageAll;
    } else {
        // Handle the case where $productCount is zero
        $bayesCount = $averageAll; // Assign a default value or handle appropriately
    }
}

// Create an array to hold the result
$resultArray = array('bayesCount' => $bayesCount);

// Return the result array
echo json_encode($resultArray);
?>
