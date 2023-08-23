<?php
session_start();
unset($_SESSION["cashier_email"]);
header("Location:login.php");
?>