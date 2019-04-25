<?php

class Post {

// we define 3 attributes
    public $id;
    public $title;
    public $content;
    public $date;
    public $description;

    public function __construct($id, $title, $content, $date, $description) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->description = $description;
    }

    public static function readAll() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM post');
// we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $post) {
            $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription']);
        }
        return $list;
    }

    public static function read($id) {
        $db = Db::getInstance();
//use intval to make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM post WHERE postID = :id');
//the query was prepared, now replace :id with the actual $id value
        $req->execute(array('id' => $id));
        $post = $req->fetch();
        if ($post) {
            return new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription']);
        } else {
//replace with a more meaningful exception
            throw new Exception('This post no longer exists.');
        }
    }

    public static function search($keyword) {
        $list = [];
        $db = Db::getInstance();
        if (isset($_POST['search']) && $_POST['search'] != "") {
            $filteredKeyword = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $keyword = "%$filteredKeyword%";
        }
        $sql = $db->prepare("SELECT * FROM post WHERE postTitle LIKE :keyword OR postContent LIKE :keyword");
        $sql->execute(array(':keyword' => $keyword));
        $posts = $sql->fetchAll();
        foreach ($posts as $post) {
            $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription']);
        }
        return $list;
    }

    public static function update($id) {
        $db = Db::getInstance();
        $req = $db->prepare("Update post set postTitle=:title, postContent=:content, postDescription=:description where postID=:id");
        $req->bindParam(':id', $id);
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':description', $description);

// set name and price parameters and execute
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $filteredTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['content']) && $_POST['content'] != "") {
            $filteredContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['description']) && $_POST['description'] != "") {
            $filteredDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $title = $filteredTitle;
            $content = $filteredContent;
            $description = $filteredDescription;
            $req->execute();

//upload product image if it exists
            if (!empty($_FILES[self::InputKey]['title'])) {
                Post::uploadFile($title);
            }
        }
    }

    public static function create() {
        $db = Db::getInstance();
        $req = $db->prepare("Insert into post(postTitle, postContent, postDescription, postDate) values (:title, :content, :description, NOW())");
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':description', $description);

// set parameters and execute
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $filteredTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['content']) && $_POST['content'] != "") {
            $filteredContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST['description']) && $_POST['description'] != "") {
            $filteredDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $title = $filteredTitle;
        $content = $filteredContent;
        $description = $filteredDescription;
        $req->execute();

//upload product image
        Post::uploadFile($title);
    }

    const AllowedTypes = ['image/jpeg', 'image/jpg'];
    const InputKey = 'myUploader';

//die() function calls replaced with trigger_error() calls
//replace with structured exception handling
    public static function uploadFile(string $title) {

        if (empty($_FILES[self::InputKey])) {
//die("File Missing!");
            trigger_error("File Missing!");
        }

        if ($_FILES[self::InputKey]['error'] > 0) {
            trigger_error("Handle the error! " . $_FILES[self::InputKey]['error']);
        }


        if (!in_array($_FILES[self::InputKey]['type'], self::AllowedTypes)) {
            trigger_error("Handle File Type Not Allowed: " . $_FILES[self::InputKey]['type']);
        }

        $tempFile = $_FILES[self::InputKey]['tmp_name'];
        $path = "C:/xampp/htdocs/MVC_Skeleton/views/images/";
        $destinationFile = $path . $title . '.jpeg';

        if (!move_uploaded_file($tempFile, $destinationFile)) {
            trigger_error("Handle Error");
        }

//Clean up the temp file
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    }

    public static function delete($id) {
        $db = Db::getInstance();
//make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('delete FROM post WHERE postID = :id');
// the query was prepared, now replace :id with the actual $id value
        $req->execute(array('id' => $id));
    }

}

//public function unpublish($id)
?>