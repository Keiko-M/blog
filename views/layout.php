<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="views/css/styles.css" rel="stylesheet" type="text/css"/>
        <title>WTF - Where's The Food!?</title>
    </head>
    <body>
        <header>
            <?php
            if (isset($_SESSION['usename']) == true) {
                require_once('loggedInHeader.php');
            } else {
                require_once('header.php');
            }
            ?>;
            <div class="container" id='title'>
                <h1>Where's The Food!?!</h1>
            </div>
        </header>
        <div>
            <?php require_once('routes.php'); ?>
        </div>
        <div>
            <footer >
                Copyright &COPY; <?= date('Y'); ?>
            </footer>
        </div>
    </body>
</html>