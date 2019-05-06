<?php

class Post {

// we define 3 attributes
    public $id;
    public $title;
    public $content;
    public $date;
    public $description;
    public $categoryType;
    public $userID;
    public $firstName;
    public $lastName;

    public function __construct($id, $title, $content, $date, $description, $categoryType, $userID, $firstName, $lastName) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->description = $description;
        $this->categoryType = $categoryType;
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function readAll() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('CALL readAllCategoriesbyPost');
//$req = $db->query('SELECT post.postID, post.postTitle, post.postContent, post.postDescription, post.postDate, GROUP_CONCAT(categoryType) FROM category_post LEFT JOIN post ON category_post.postID = post.postID LEFT JOIN category ON category_post.categoryID = category.categoryID GROUP BY postID  ORDER BY post.postDate DESC');
// we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $post) {
            $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], $post['categoryType'], $post['userID'], $post['firstName'], $post['lastName']);
        }
        return $list;
    }

    public static function read($id) {
        $db = Db::getInstance();
//use intval to make sure $id is an integer
        $id = intval($id);
//$req = $db->prepare('SELECT * FROM post WHERE postID = :id');
        $req = $db->prepare('CALL CategorybyPostID(:id)');
//      $req = $db->prepare('SELECT post.postID, post.postTitle, post.postContent, post.postDescription, post.postDate, GROUP_CONCAT(categoryType) AS categoryType FROM category_post LEFT JOIN post ON category_post.postID = post.postID LEFT JOIN category ON category_post.categoryID = category.categoryID GROUP BY postID ');
//the query was prepared, now replace :id with the actual $id value
        $req->execute(array('id' => $id));
        $post = $req->fetch();
        if ($post) {
            return new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], $post['categoryType'], $post['userID'], $post['firstName'], $post['lastName']);
        } else {
//replace with a more meaningful exception
            throw new Exception('This post no longer exists.');
        }
    }

    public static function search() {
        $list = [];
        $db = Db::getInstance();
        if (isset($_POST['search']) && $_POST['search'] != "") {
            $filteredKeyword = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $keyword = "%$filteredKeyword%";
        }
        $sql = $db->prepare("CALL Search(:keyword)");
        $sql->execute(array(':keyword' => $keyword));
        $posts = $sql->fetchAll();
        foreach ($posts as $post) {
            $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], $post['categoryType'], $post['userID'], $post['firstName'], $post['lastName']);
        }
        return $list;
    }

    public static function advancedSearch() {
        $list = [];
        $db = Db::getInstance();
        if (isset($_POST['advancedSearch'])) {
            $filteredKeyword = filter_input(INPUT_POST, 'advancedSearch', FILTER_SANITIZE_SPECIAL_CHARS);
            $keyword = "%$filteredKeyword%";
        }
        if (isset($_POST['category'])) {
            $category = filter_input(INPUT_POST, 'category');
            if (isset($_POST['author'])) {
                $author = filter_input(INPUT_POST, 'author');
            }

            $sql = $db->prepare("select post.userID, post.postID, post.postTitle,post.postDescription, post.postContent, post.postDate, bloguser.firstName,bloguser.lastName, GROUP_CONCAT(categoryType) AS categoryType 
FROM category_post 
LEFT JOIN post 
ON category_post.postID = post.postID 
LEFT JOIN bloguser
ON bloguser.userID=post.userID
LEFT JOIN category 
ON category_post.categoryID = category.categoryID 
Group by postID
HAVING categoryType LIKE concat('%',:category,'%')
AND (post.postTitle LIKE concat('%',:keyword,'%')
OR post.postContent LIKE concat('%',:keyword,'%')
OR post.postDescription LIKE concat('%',:keyword,'%')
OR bloguser.firstName LIKE concat('%',:keyword,'%')
OR bloguser.lastName LIKE concat('%',:keyword,'%'))

");
            $sql->bindParam(':keyword', $keyword);
            $sql->bindParam(':category', $category);

            $sql->execute();
//foreach ($_POST['advancedSearch'])
            $posts = $sql->fetchAll();
            foreach ($posts as $post) {
                $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], $post['categoryType'], $post['userID'], $post['firstName'], $post['lastName']);
            }
            return $list;
        }
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

//delete current category/ies
            $postCategories = $db->prepare('DELETE FROM category_post WHERE postID = :id');
            $postCategories->bindParam(':id', $id);
            $postCategories->execute();

// get the categories from the form
            $categories = $_POST['category'];

            $statement = $db->prepare('SELECT category.categoryID FROM category WHERE category.categoryType = :categoryType ');
            $statement->bindParam(':categoryType', $category);
            foreach ($categories as $category) {
                $statement->execute();
                $categoriesID[] = $statement->fetch(PDO::FETCH_ASSOC);
            }

//fetch all as an array

            foreach ($categoriesID as $row => $categoryID) {
                foreach ($categoryID as $keys => $value) {
                    $req = $db->prepare('INSERT INTO category_post (postID, categoryID) values (:postID, :categoryID)');
                    $req->bindParam(':postID', $id);
                    $req->bindParam(':categoryID', $value);
                    $req->execute();
                }
            }


//upload product image if it exists
            if (!empty($_FILES[self::InputKey]['id'])) {
                Post::uploadFile($id);
            }
        }
    }

    public static function create() {
        $db = Db::getInstance();
        $req = $db->prepare("Insert into post(postTitle, postContent, postDescription, postDate, userID) values (:title, :content, :description, NOW(), :userID)");
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':description', $description);
        $req->bindParam(':userID', $userID);

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

        $userID = $_SESSION['userID'];
        $title = $filteredTitle;
        $content = $filteredContent;
        $description = $filteredDescription;
        $req->execute();

//select postID
        $stmt = $db->prepare('SELECT * FROM post WHERE postTitle = :title AND postDescription =  :description');
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

//create an object for a post with those attributes
        $stmt->execute();
        $post = $stmt->fetch();
        if ($post) {
            $selectCategory = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], null, $userID, null, null);
        }
// get the categories from the form
        $categories = $_POST['category'];

        $statement = $db->prepare('SELECT category.categoryID FROM category WHERE category.categoryType = :categoryType ');
        $statement->bindParam(':categoryType', $category);
        foreach ($categories as $category) {
            $statement->execute();
            $categoriesID[] = $statement->fetch(PDO::FETCH_ASSOC);
        }

//fetch all as an array

        foreach ($categoriesID as $row => $categoryID) {
            foreach ($categoryID as $keys => $value) {
                $req = $db->prepare('INSERT INTO category_post (postID, categoryID) VALUES (:postID, :categoryID)');
                $req->bindParam(':postID', $selectCategory->id);
                $req->bindParam(':categoryID', $value);
                $req->execute();
            }
        }


//upload product image
        Post::uploadFile($selectCategory->id);
    }

    const AllowedTypes = ['image/jpeg', 'image/jpg'];
    const InputKey = 'myUploader';

//die() function calls replaced with trigger_error() calls
//replace with structured exception handling
    public static function uploadFile($name) {
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
        $path = "C:/xampp/htdocs/blog/views/images/";
        $destinationFile = $path . $name . '.jpeg';
        if (!move_uploaded_file($tempFile, $destinationFile)) {
            trigger_error("Handle Error");
        }

//Clean up the temp file
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    }

    public static function readMyPosts($userID) {
        $list = [];
        $db = Db::getInstance();

        $sql = $db->prepare('CALL readMyPosts(:userID)');
        $sql->execute(array(':userID' => $userID));
        $posts = $sql->fetchAll();
        foreach ($posts as $post) {
            $list[] = new Post($post['postID'], $post['postTitle'], $post['postContent'], $post['postDate'], $post['postDescription'], $post['categoryType'], $post['userID'], $post['firstName'], $post['lastName']);
        }
        return $list;
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

?>
