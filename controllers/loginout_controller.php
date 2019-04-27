<?php
session_start();
require_once '../models/user.php';

$params = $_REQUEST;
$action = $params['action'] !='' ? $params['action'] : '';

$user = new User($_POST['username'], $_POST['password']);

switch($action) {
    case 'login':
        echo $user->login();
        break;
    
    case 'logout':
        echo $user->logout(); 
        break;

    default:
    return;
    
}


?>