<?php

class PostController {

    public function readAll() {
        // we store all the posts in a variable
        $posts = Post::readAll();
        require_once('views/posts/readAll.php');
    }

    public function read() {
        // we expect a url of form ?controller=posts&action=show&id=x
        // without an id we just redirect to the error page as we need the post id to find it in the database
        if (!isset($_GET['id']))
            return call('pages', 'error');

        try {
            // we use the given id to get the correct post
            $post = Post::read($_GET['id']);
            require_once('views/posts/read.php');
        } catch (Exception $ex) {
            return call('pages', 'error');
        }
    }

    public function search() {
        if (isset($_POST) == true) {

            $posts = Post::search($_POST['search']);
            require_once('views/posts/searchResults.php');
        }
            if (empty($posts)) {
                echo "<h4>No results found</h4>";
        }
    }

    public function create() {
        // we expect a url of form ?controller=products&action=create
        // if it's a GET request display a blank form for creating a new product
        // else it's a POST so add to the database and redirect to readAll action
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once('views/posts/create.php');
        } else {
            Post::create();

            $posts = Post::readAll(); //$products is used within the view
            require_once('views/posts/readAll.php');
        }
    }

    public function update() {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET['id']))
                return call('pages', 'error');

            // we use the given id to get the correct product
            $post = Post::read($_GET['id']);

            require_once('views/posts/update.php');
        }
        else {
            $id = $_GET['id'];
            Post::update($id);

            $posts = Post::readAll();
            require_once('views/posts/readAll.php');
        }
    }

    public function delete() {
        Post::delete($_GET['id']);

        $posts = Post::readAll();
        require_once('views/posts/readAll.php');
    }

}

?>