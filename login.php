<html>
<?php 
include "connectdb.php";
session_start();
 ?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="sign-in&up.css">
    <link rel="icon" href="logo.png">
    <title>SIGN-IN</title>
</head>
<body>
<header><h1>NDAT</h1></header>
<div class="login">
    <form action="retrieve.php" method="POST" onsubmit="return data_validate();">
    <h4>SIGN-IN</h4>
    <input class="isi" type="text" name="email" id="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@(gmail|yahoo)\.com$"><br>
    <input class="isi" type="password" name="password" id="password" minlength="7" placeholder="Password" required>
    <input class="btn1" type="submit" method="GET" value="LOGIN">
    <a href="signup.php" class="create">Create acc</a>
</form>
    </div>
    <!-- <script>
    function data_validate() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var msg = "";

    if (email.length == 0 || password.length == 0) {
        msg = msg + "Fill in the form";
    } else {
        msg = msg + "Your data have been save";
    } 
    alert(msg); // Display the message in an alert box

}
</script> -->
<!-- <nav>
</nav> -->
</body>
</html>