<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

include_once(__DIR__."/classes/User.php");
include_once(__DIR__."/classes/Hobby.php");

$userArray = $_SESSION['user_id'];
$userID = implode(" ", $userArray);

if(!empty($_POST)){
    try{
        $hobby = new Hobby();
        $hobby->setLocatie(htmlspecialchars($_POST['locatie']));
        $hobby->setHobby(htmlspecialchars($_POST['hobby']));
        $hobby->setFilm(htmlspecialchars($_POST['film']));
        $hobby->setGame(htmlspecialchars($_POST['game']));
        $hobby->setMuziek(htmlspecialchars($_POST['muziek']));
        $hobby->setUserID(htmlspecialchars($userID));
        $statement=$hobby->hobbyInvullen($locatie,$hobby,$film,$game,$muziek,$userID);
        //$hobby->hobbyInvullen();
        //$hobby->hobbyInvullen($_POST);
        header('Location: index.php');
    }
    catch(throwable $e){
        $error = "Iets is mis gegaan.";
    }
}
else{
    $error = "Vul alle velden in";
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profiel</title>
</head>
<style>

        h1{
            font-size: 1em;
        }
        
    </style>
<body> 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" > 
    <h1>Hey! Vul deze velden in om nog makkelijker een match te vinden!</h1>
    <!-- als er een error bestaat -->
    <?php if(isset($error)): ?>
        <div class="error"><p><?php echo $error?></p></div>
    <?php endif; ?>

    <div class="">
        <label for="locatie">Vanwaar ben je?</label>
        <input type="text" id="locatie" name="locatie">
    </div>
    <div class="">
        <label for="hobby">Wat is je hobby?</label>
        <input type="text" id="hobby" name="hobby">
    </div>
    <div class="">
        <label for="game">Welk spel speel je graag?</label>
        <input type="text" id="game" name="game">
    </div>
    <div class="">
        <label for="film">Naar wat voor gerne filmen kijk je graag?</label>
        <input type="text" id="film" name="film">
    </div>
    <div class="">
        <label for="muziek">Naar wat voor gerne muziek luister je graag?</label>
        <input type="text" id="muziek" name="muziek">
    </div>
        
    <div><input type="submit" value="Add!" class="btn"></div>
    </form>
</body>
</html>