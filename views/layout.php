<!DOCTYPE html>
<html>
  <head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico|Pangolin" >
<link rel="stylesheet" href="views/css/styles.css">
<title>WTF - Where's The Food!?</title>
  </head>
  <body>
    <header class="w3-container w3-gray">
      <a href='index.php'>Home</a>
      <a href='?controller=post&action=readAll'>All Posts</a>
      <a href='?controller=post&action=create'>Add Post</a>
    </header>
<div class="w3-container w3-pale-red">
    <?php require_once('routes.php'); ?>
</<div>
<div class="w3-container w3-gray">
    <footer >
        Copyright &COPY; <?= date('Y'); ?>
    </footer>
</div>
  </body>
</html>