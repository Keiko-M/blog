<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link href="../css/styles.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../controllers/loginout_controller.js"></script>
<body>
<!--    <H1><?php print_r($_SESSION); ?></H1>-->
    <H1>Please Login</H1>

    <div class="container" >
        <div class="row box" id="login-box">
            <div class="col-md-6 col-md-offset-3" >
                <div class="panel panel-login" >
                    <div class="panel-body" >
                        <div class="row " >
                            <div class="col-lg-12" >
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">...</div>
                                <form id="loginForm" name="loginForm" role="form" style="display: block;" method="post">
                                    <div class="form-group">
                                        <input type="email" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value=""  required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required> 
                                    </div>
                                    <div class="col-xs-12 form-group pull-right">     
                                        <button type="submit" name="loginSubmit" id="loginSubmit" tabindex="3" class="form-control btn btn-warning">
                                        <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Log In
                                        </button>
                                    </div>
                                </form>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>