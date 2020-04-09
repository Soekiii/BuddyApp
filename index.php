<?php
include_once(__DIR__ . "/classes/Hobby.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Match.php");
include_once(__DIR__ . "/inc/header.inc.php");

    session_start();
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
    } else {
        $userArray = $_SESSION['user_id'];
        $userID = implode(' ', $userArray);
    }

    // if user's hobby = empty --> redirect to hobby.php
    $hobby = new Hobby();
    $hobby->setUserID($userID);
    $count = $hobby->countHobbies($userID);
    if ($count == false) {
        header('Location: hobby.php');
    }

    // calculate user match
    $calcMatch = new Match;
    $userHobby = new Match;
    $othersHobby = new Match;
    $hobbyUser = $userHobby->getUserHobby();
    $hobbyOthers = $othersHobby->getOtherHobby();
    $matchScores = $calcMatch->calcMatch($hobbyUser, $hobbyOthers);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>

    <h5>Potentiële Amigos</h5>

        <div class="matchName"><?php print_r($hobbyOthers) ?></div>
        <div class="matchDe">DESCRIPTION GOES HERE</div>
</head>

<body>

</body>

</html>