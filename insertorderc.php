<?php
include "connectdb.php";

session_start(); // memulakan sesi

if (isset($_SESSION['customer_id'])) {
    // ID pelanggan ditetapkan, lakukan sesuatu dengannya
    $customer_id = $_SESSION['customer_id'];
} else {
    // ID pelanggan tidak ditetapkan, redirect ke halaman log masuk
    header('Location: login.php');
    exit();
}

// Periksa jika borang telah dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sediakan penyata SQL dengan placeholder
    $sql = "INSERT INTO orders (customer_id, product_id, quantity) VALUES (:customer_id, :product_id, :quantity)";
    $stmt = $conn->prepare($sql);

    // Loop melalui data borang yang dihantar
    foreach ($_POST as $item_id => $quantity) {
        if ($quantity >= 1) {
            // Dapatkan ID produk berdasarkan ID item
            $food_sql = "SELECT product_id FROM food_data WHERE product_id = :item_id";
            $food_stmt = $conn->prepare($food_sql);
            $food_stmt->bindParam(":item_id", $item_id);
            $stmt->execute();
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $product_id = $result['product_id']; // Dapatkan ID produk dari hasil pertanyaan
                $stmt->bindParam(":customer_id", $customer_id);
                $stmt->bindParam(":comments", $comments); // Gunakan ID produk yang diperoleh
                $stmt->bindParam(":star_rating", $star_rating);
                $stmt->execute();
                echo "<font color='blue'>Item berjaya dimasukkan ke dalam pangkalan data...</font>";
            } else {
                echo "ID item tidak sah. Item tidak akan dimasukkan ke dalam pangkalan data.";
            }
        } else {
            echo "Kuantiti untuk item dengan ID $item_id mesti lebih besar daripada atau sama dengan 1. Item tidak akan dimasukkan ke dalam pangkalan data.";
        }
    }

    $_SESSION['message'] = "Item berjaya dimasukkan ke dalam pangkalan data...";
    header('location: comment.php');

    // Tutup penyata food_data dan sambungan pangkalan data
    $stmt = null;
    $conn = null;
}
?>
