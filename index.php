<?php 
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
include_once(__DIR__."/classes/Hobby.php");
include_once(__DIR__."/classes/User.php");

$hobby = new Hobby();
$count = $hobby->countHobbies($userID);
if($count == false){
    echo "no";
    //header('Location: hobby.php');
}
else{
    echo "yes";
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>
</head>
<body>
<a href="logout.php" class="link">logout <?php echo $_SESSION['email'] ?></a>
</body>
</html>