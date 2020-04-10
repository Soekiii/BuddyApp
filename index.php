<?php
include_once(__DIR__ . "/classes/Hobby.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Buddy.php");
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

    // get current user's hobby's
    $user = new Buddy();
    $hobbyUser = $user->setHobbyUser();

    // get other users' hobby's
    $others = new Buddy();
    $hobbyOthers = $others->setHobbyOthers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>

    <h5>Potentiële Amigos</h5>
    <?php foreach($hobbyOthers as $hobbyOther): ?>
    <div class="match">
        <?php
            $scores = [];
            $score = 0;

            // if they share an interests, add 10 points to score
            if ($hobbyUser['game'] == $hobbyOther['game']) {
                $score += 10;
                $equal = 1;
            }

            if ($hobbyUser['hobby'] == $hobbyOther['hobby']) {
                $score += 10;
            }

            if ($hobbyUser['film'] == $hobbyOther['film']) {
                $score += 10;
            }

            if ($hobbyUser['muziek'] == $hobbyOther['muziek']) {
                $score += 10;
            }

            if ($hobbyUser['locatie'] == $hobbyOther['locatie']) {
                $score += 10;
            }

            // convert hobbyOther from array to string
            $otherID = $hobbyOther['userID'];

            // place score in scores array of matching user
            $scores[$otherID] = $score;

            // als score niet 0 is, print de naam en leg uit waarom users matchen
            if($score >= 10){ ?>
                <div class="matchName"><?php echo $hobbyOther['firstname'] . " " . $hobbyOther['lastname']; ?></div>
                <div class="matchDesc">
                    <?php
                        if($hobbyUser['hobby'] == $hobbyOther['hobby']){
                            echo "jullie zijn allebei dol op " . lcfirst($hobbyOther['hobby']);
                        }
                    
                        if($hobbyUser['hobby'] == $hobbyOther['hobby'] && $hobbyUser['game'] == $hobbyOther['game']){
                            echo " en " . $hobbyOther['game'];
                        } else if($hobbyUser['game'] == $hobbyOther['game']){
                            echo "jullie zijn allebei dol op " . $hobbyOther['game'];
                        } else{
                        }

                        if(($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game']) || $hobbyUser['film'] == $hobbyOther['film']){
                            echo " en " . $hobbyOther['film'];
                        } else if($hobbyUser['film'] == $hobbyOther['film']){
                            echo "jullie zijn allebei dol op " . $hobbyOther['film'];
                        } else{
                        }

                        if(($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game'] || $hobbyUser['film'] == $hobbyOther['film']) && $hobbyUser['muziek'] == $hobbyOther['muziek']){
                            echo " en " . $hobbyOther['muziek'];
                        } else if($hobbyUser['muziek'] == $hobbyOther['muziek']){
                            echo "jullie zijn allebei dol op " . $hobbyOther['muziek'];
                        } else{
                        }

                        if(($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game'] || $hobbyUser['film'] == $hobbyOther['film'] || $hobbyUser['muziek'] == $hobbyOther['muziek']) && $hobbyUser['locatie'] == $hobbyOther['locatie']){
                            echo " en wonen in " . $hobbyOther['locatie'];
                        } else if($hobbyUser['locatie'] == $hobbyOther['locatie']){
                            echo "jullie wonen allebei in " . $hobbyOther['locatie'];
                        } else{
                        }
                    ?>
                    <button class="matchBtn" name="request">stuur verzoek</button>
                </div>
            <?php } ?>
    </div>
    <?php endforeach; ?>
</head>

<body>

</body>

</html>