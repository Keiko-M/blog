<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WTF-Where's The Food?</title>
    </head> 
    <body>
        <!--Nav bar starts here-->
        <nav class="navbar navbar-default navbar-fixed-top masthead" id="navbar">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->               
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="?controller=pages&action=home" class="navbar-brand img-responsive"><img id="logo" src="views/images/standard/logo.png" width="120" alt="">
                    </a> 
                    <!-- Collection of nav links and other content for toggling -->
                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="?controller=post&action=readAll">All Posts</a></li>
                            <li><a href="?controller=post&action=create">Add a new post</a></li>
                            <li><a href="#">My Posts</a></li>
                            <li><a href="#">Category</a></li>
                            <li><a href="#">Authors</a></li>
                            <li><a href="#">Subscribe</a></li>
                            <li><a href="#">Contact us</a></li>
                            <li><a href="#">About us</a></li>
                            <li class="smallNav"><a style='float:left' href="#">Login</a></li>
                            <li class="smallNav"><a style='float:left' href='#'>Register</a></li>
                        </ul>
                    </div>  
                    <div id='search'>
                        <form class="form-inline" action="#" method="get">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="float:right">Go</button>
                            <div style="overflow: hidden; padding-right:.5em">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            </div>
                        </form>
                        <ul class="nav navbar-nav">
                            <li class="smallNav"><a href="#">Advanced Search</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </body>

</html>                            