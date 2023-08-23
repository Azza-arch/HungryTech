<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="sign-in&up.css">
    <link rel="icon" href="logo.png">
    <title>SIGN-UP</title>
</head>

<body>

<header><h1>NDAT</h1></header>
<div class="login">
    <?php include "connectdb.php";?>
    <form method="POST" action="insert.php" onsubmit="return data_validate();">
    <h4>SIGN-UP</h4>
    
    <input class="isi" type="text"     name="username" id="username" placeholder="Username" required><br>
    <input class="isi" type="text"     name="email" id="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@(gmail|yahoo)\.com$"><br>
    <input class="isi" type="password" name="password" id="password" placeholder="Password" minlength="7" required><br>
    <input class="isi" type="password" name="cpassword" id="cpassword" placeholder="Comfirm Password" minlength="7" required><br>
    <input class="btn1" type="submit" id="submit" value="SIGN-UP" method="POST">
</form>
    </div> 
<!-- <nav>
</nav> -->
<script>
function data_validate() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var cpassword = document.getElementById("cpassword").value;
 
    if (password !== cpassword) {
        alert("Password and confirm password do not match");
        return false; // Prevent form submission
    }
    
    return true; // Allow form submission
}
</script>
</body>
</html>