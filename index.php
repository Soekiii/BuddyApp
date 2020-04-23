<?php
session_start();

include_once(__DIR__ . "/classes/Hobby.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Buddy.php");
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/Forum.php");


$userID = "";
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
} else {
    $userArray = $_SESSION['user_id'];
    $userID = implode(" ", $userArray);
}

    // if user's hobby = empty --> redirect to hobby.php
    $hobby = new Hobby();
    $hobby->setUserID($userID);
    $count = $hobby->countHobbies($userID);
    

    // ====== MATCHING USERS WITH BUDDY'S ======
    // get current user's hobby's
    $user = new Buddy();
    $hobbyUser = $user->setHobbyUser($userID);
    // get other users' hobby's
    $others = new Buddy();
    $hobbyOthers = $others->setHobbyOthers($userID);

    $buddyAvailable = new Buddy();
    $available = $buddyAvailable->buddyAvailable($userID);

    // ====== SENDING BUDDY REQUESTS ======
    // when button "send buddy request" is clicked
    if(!empty($_POST['request'])){
        $request = new Buddy();
        // 1. retrieve buddyID value from $_POST
        $buddyID = $_POST['buddyID'];
        // 2. insert userID, buddyID and status=0 in db (buddy table)
        $request->setUserID($userID);
        $request->setBuddyID($buddyID);
        $sendRequest = $request->buddyRequest($userID, $buddyID);
        echo "Request sent to userID ";

        echo $buddyID;
    }
    
    // functie om users te displayen
    $displayGetal= new User();
    $userNumbers= $displayGetal->AllUsers();
    
    
    // functie om gematchte buddies te displayen
    $matchedBuddiesNumber= $displayGetal->AllMatchedBuddies();
    
    // haal bestaande forum posts & de bijhorende comments op
    $retrievePosts = new Forum();
    $posts = $retrievePosts->retrievePosts();    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>

    <!--hier probeersel om code terug te krijgen van User.php - zelfde ook doen op andere pagina whoAreBuddies.php  -->
    
    <div>
        <p>Geregistreerde gebruikers: <span class="badge"><?php echo $userNumbers['numbersOfUsers'];?></span></p><br>
        <p>Gematchte buddies: <span class="badge"><?php echo $matchedBuddiesNumber['numbersOfMatchedBuddies'];?></span></p> 
    </div>

    <h5>Potentiële Amigos</h5>
    <?php if($available != "1"){
        foreach($hobbyOthers as $hobbyOther): ?>
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
                        <form action="" method="post">
                            <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                            <input type="hidden" name="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                            <input type="submit" value="stuur verzoek" name="request">
                        </form>
                </div>
                <?php } ?>
        </div>
        <?php endforeach; } ?>

        <div>
            <h5>Forum</h5>

            <?php foreach($posts as $post): ?>
                <div class="tests">
                    <?php echo $post['postTxt']; ?>
                </div>
            <?php endforeach ?>
        </div>
</head>

<body>

</body>

</html>

