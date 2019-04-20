<?php

require_once "../connection.php";
//DB::getInstance();

//Define variables and initialise with empty values
$username = $password = $confirmPassword = "";
$usernameErr = $passwordErr = $confirmPasswordErr = "";

//processing form data when form is submitted / Checks the method = post
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //validate username
    if(empty(trim($_POST["username"]))){ //trim: Strip whitespace & empty: Determine whether a variable is empty
        $usernameErr = "Pleaes enter a username.";
    }else{
        //prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            //bind variables to the prepared statement as parmeters
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR); //DO::PARAM_STR Represents the SQL CHAR, VARCHAR, or other string data type.

            
            //set parameters
            $paramUsername = trim($_POST["username"]);
            
            //Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $usernameErr = "This username is already taken.";
                }else{
                    $username = trim($_POST["username"]);
                }
            }else{
                    echo "Something went wrong. Please try again later.";
            }
        }
        //close statement
        unset($stmt);    
    }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $passwordErr = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $passwordErr = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPasswordErr = "Please confirm password.";
    }else{
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($passwordErr) && ($password != $confirmPassword)){
            $confirmPasswordErr = "Password did not match.";
        }
    }    
    
    //checkput errors before inserting into the database
    if(empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr)){
    //    prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

    //    bind the parameters
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR);
            $stmt->bindParam(":password", $paramPassword, PDO::PARAM_STR);
           //       set the parameters
            $paramUsername = $username;
            $paramPassword = password_hash($password, PASSWORD_DEFAULT); // creates a new password hash using a strong one-way hashing bcrypt algorithm
        
        //attempt to execute
        if($stmt->execute()) {
            //redirect to login page
              header("location: login.php");
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        //close statement
        unset($stmt);
    }
    //close connection 
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($usernameErr)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $usernameErr; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($passwordErr)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirmPasswordErr)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control" value="<?php echo $confirmPassword; ?>">
                <span class="help-block"><?php echo $confirmPasswordErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
