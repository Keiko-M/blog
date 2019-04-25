<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../controllers/loginout_controller.js"></script>
    
    <body>
        <div class="container">
            <div class="row">
                <h1>User Profile <br><small>#London #Japanese #restaurant </small></h1>
                <!-- Contenedor -->
                <ul id="accordion" class="accordion">
                <li>

                <div class="username">
                <h2>Hi <small>Your username is <?php echo $_SESSION['username']; ?><i class="fa fa-map-marker"></i> Japan </small></h2>
                </div>
            </div>

                <ul class="submenu" id="logout">
		<li><a href="../../controllers/login_controller.php?action=logout" class="btn btn-default btn-sm">
                    Logout
                    </a>
                    </li>
                </ul>
        </div>
    </body>
</html>