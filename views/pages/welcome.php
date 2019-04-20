<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}Else{
echo "welcome to our page.<br>";    
echo "Your username is ". $_SESSION["username"];    

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>

<body>
    <br>
    <a href="http://localhost:8080/blog/models/logout.php">Log out</a><br>
    <a href="http://localhost:8080/blog/models/resetPassword.php">Reset Password</a>

</body>

</html>