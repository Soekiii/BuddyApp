<?php 
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Hobby.php");
include_once(__DIR__."/classes/User.php");

$userArray = $_SESSION['user_id'];
$userID = implode(" ", $userArray);

$hobby = new Hobby();
$hobby->setUserID($userID);
$count = $hobby->countHobbies($userID);
if($count == false){
    header('Location: hobby.php');
}

$match = new User();
$myName= $match->calcMatch();




?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>
</head>
<body>
    
</body>
</html>