<?php 

session_start();

include "connectdb.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email)) {
        header("Location: login.php?error=User Name is required");
        exit();
    } elseif (empty($password)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        $customer_sql = "SELECT * FROM customer WHERE customer_email='$email' AND customer_password='$password'";
        $customer_result = $conn->query($customer_sql);

        $cashier_sql = "SELECT * FROM cashier WHERE cashier_email='$email' AND cashier_password='$password'";
        $cashier_result = $conn->query($cashier_sql);

        if ($customer_result && $customer_result->rowCount() === 1) {
            $row = $customer_result->fetch(PDO::FETCH_ASSOC);
            $_SESSION['customer_email'] = $row['customer_email'];
            $_SESSION['customer_name'] = $row['customer_name'];
            $_SESSION['customer_id'] = $row['customer_id'];
            header("Location: ndatmain.php");
            exit();
        } elseif ($cashier_result && $cashier_result->rowCount() === 1) {
            $row = $cashier_result->fetch(PDO::FETCH_ASSOC);
            $_SESSION['cashier_email'] = $row['cashier_email'];
            $_SESSION['cashier_id'] = $row['id'];
            header("Location: main(c).php");
            exit();
        } else {
            header("Location: login.php?error=Incorrect User name or Password");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
