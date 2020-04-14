<?php
include_once (__DIR__ . "/classes/User.php");
if(isset($_GET['token'])){
    $token = $_GET['token'];
    $id = $_GET['userID'];

    $user = new User();
    $user->activate($token, $id);
}

?>