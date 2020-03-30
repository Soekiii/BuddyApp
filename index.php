<?php 
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
include_once(__DIR__."/classes/Hobby.php");
include_once(__DIR__."/classes/User.php");

$userArray = $_SESSION['user_id'];
$userID = implode(" ", $userArray);

$hobby = new Hobby();
$hobby->setUserID($userID);
$count = $hobby->countHobbies($userID);
if($count != $userID){
    header('Location: hobby.php');
}


$searchResult = "";
        if(isset($_POST['submit-search'])){
            $search = htmlspecialchars($_POST['search']);
            $searchResult = User::userSearch($search);
            // als de array gelijk is aan NULL of O dan geeft die error weer
            if($searchResult == NULL || $searchResult == 0){
                $error = "geen zoekresultaten gevonden.";
            } else {
                $result = "Zoekresultaat";
                if(count($searchResult) > 1) {
                    $resultCount = "Er zijn " . count($searchResult) . " zoekresultaten gevonden.";
                }else {
                    $resultCount = "Er is " . count($searchResult) . " zoekresultaat gevonden.";
                }
        }

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
    <div><a href="edit_profile.php" class="link">Edit profile</a></div>
    <!-- search form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="search" placeholder="search">
    <button type="submit" name="submit-search">Search</button>
    <!-- search error -->
    <?php if(isset($error)): ?>
        <div class="error" style="color: red"><?php echo $error; ?></div>
    <?php endif; ?>
    </form>
    <!-- zoekresultaat hits -->
    <?php if(isset($result)): ?>
        <div class="result"><h2><?php echo $result; ?></h2></div>
    <?php endif; ?>
    <?php if(isset($resultCount)): ?>
        <div class="resultCount"><p2><?php echo $resultCount; ?></p2></div>
    <?php endif; ?>

    <!-- zoekresultaten uitlezen als er iets inzit-->
    <div class="result-container">
    <?php if (is_array($searchResult) || is_object($searchResult)) {
        foreach($searchResult as $r): ?>
        <h3><?php echo($r['firstname'] . " " . $r['lastname']); ?></h3>
        <?php endforeach; }?>
    </div>
</body>
</html>