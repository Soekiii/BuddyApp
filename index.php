<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} 

$userID = $_SESSION['user_id'];
include_once(__DIR__ . "/classes/Hobby.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Buddy.php");
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/Forum.php");



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

// ====== LOKAAL ZOEKEN ======
$lokaal = new User();
$l = $lokaal->lokalen();
    if(isset($_POST['submit-lokaal'])){
    $lokalen = $_POST['lokaalInfo'];
    $lokaalInfo = $lokaal->lokaalInfo($lokalen);
}




// ====== SENDING BUDDY REQUESTS ======
// when button "send buddy request" is clicked
if (!empty($_POST['request'])) {
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
$displayGetal = new User();
$userNumbers = $displayGetal->AllUsers();

// functie om gematchte buddies te displayen
$matchedBuddiesNumber = $displayGetal->AllMatchedBuddies();

// haal bestaande forum posts
$fetchPosts = new Forum();
$posts = $fetchPosts->fetchPosts();

// fetch input from new post and submit into database
if (!empty($_POST)) {
    $newPost = new Forum();
    $newPost->setUserID($userID);
    $postTxt = $_POST['postTxt'];
    $newPost->setPostTxt($postTxt);
    $createPost = $newPost->newPost($userID, $postTxt);
    header("Refresh:0");
    //header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!--hier probeersel om code terug te krijgen van User.php - zelfde ook doen op andere pagina whoAreBuddies.php  -->
    <div class="container">
    <div class="d-flex justify-content-center row mt-4">   
    <div class="col-3">
    <p class="alert alert-primary text-center" role="alert">Geregistreerde gebruikers: <span class="badge"><?php echo $userNumbers['numbersOfUsers']; ?></span></p>
    </div>
    <div class="col-3">
    <p class="alert alert-primary text-center" role="alert">Gematchte buddies: <span class="badge"><?php echo $matchedBuddiesNumber['numbersOfMatchedBuddies']; ?></span></p>
    </div>
    </div>

    <!-- zoekbalk met 1 zoekveld en 2 dropdowns-->
    <div class="row m-4"> 

    <!-- zoekveld -->
    
    <div class="col-3"> 
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input class="form-control" type="text" name="search" placeholder="search">
    
    <!-- zoekveld error -->
    <?php if(isset($error)): ?>
        <div class="error" style="color: red"><?php echo $error; ?></div>
    <?php endif; ?>
    
    </div>

    <!-- eigenschappen filter -->
    
    <div class="col-3">
    
        <select name="filter" id="input-order" class="form-control">
        <!-- eigenschappen uitlezen van de user in een dropdown -->
        <option value="">Filter op eigen intresse</option>
        <option value="<?php echo $eigenschappen['hobby']; ?>"><?php echo $eigenschappen['hobby']; ?></option>
        <option value="<?php echo $eigenschappen['film']; ?>"><?php echo $eigenschappen['film']; ?></option>
        <option value="<?php echo $eigenschappen['game']; ?>"><?php echo $eigenschappen['game']; ?></option>
        <option value="<?php echo $eigenschappen['muziek']; ?>"><?php echo $eigenschappen['muziek']; ?></option>
        <option value="<?php echo $eigenschappen['locatie']; ?>"><?php echo $eigenschappen['locatie']; ?></option>
        </select>
   
    </div>
    

    <!-- lokaal-vinder -->
    <div class="col-3">   
   
        <select name="lokaalInfo" id="input-order" class="form-control mb-4">
        <!-- lokalen uitlezen in een dropdown -->
        <option class="dropdown-item disabled" value="">Vind een lokaal.</option>
        <?php
            if (! empty($lokaal)) {
                 foreach ($l as $key => $value) {
                     echo '<option value="' . $l[$key]['location'] . '">' . $l[$key]['location'] . '</option>';
                 }
             }
        ?>
        </select>
        </div>

        <!-- zoekknop -->
        <div class="col-3">
        <button class="btn btn-light" type="submit" name="submit-lokaal">Zoeken</button>
        </div>
    </form>
    
    
    </div>
    
    <!-- lokalen info laten zien aan de gebruiker -->
    
    <div class="row">
    <?php if(!empty($lokaalInfo)) {
        foreach($lokaalInfo as $info): ?>
    <div class="alert alert-dark" role="alert">
    <p><?php echo $info; ?></p>
    </div>
    <?php endforeach; } ?>
    </div>
    <div class="row">
    <div class="col-8">
    <h5>Forum</h5>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postBtn">Maak nieuwe post</button>

            <div class="modal fade" id="postBtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Nieuwe post</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="newPost">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Stel je vraag hier:</label>
                                    <textarea class="form-control" id="message-text" name="postTxt"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Post" name="newPost" id="submit" class="btn btn-success">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php foreach ($posts as $post) : ?>
                <div class="posts">
                    <div>
                        <a href="topic.php?id=<?php echo $post['postID'] ?>"><?php echo $post['postTxt']; ?></a>
                    </div>
                </div>
            <?php endforeach ?>
    </div>
    <div class="col-4">
        <div class="matches">
            <h5>Potentiële Amigos</h5>
            <?php if ($available != "1") {
                foreach ($hobbyOthers as $hobbyOther) : ?>
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
                        if ($score >= 10) { ?>
                            <div class="matchName"><?php echo $hobbyOther['firstname'] . " " . $hobbyOther['lastname']; ?></div>
                            <div class="matchDesc">
                                <?php
                                if ($hobbyUser['hobby'] == $hobbyOther['hobby']) {
                                    echo "jullie zijn allebei dol op " . lcfirst($hobbyOther['hobby']);
                                }

                                if ($hobbyUser['hobby'] == $hobbyOther['hobby'] && $hobbyUser['game'] == $hobbyOther['game']) {
                                    echo " en " . $hobbyOther['game'];
                                } else if ($hobbyUser['game'] == $hobbyOther['game']) {
                                    echo "jullie zijn allebei dol op " . $hobbyOther['game'];
                                } else {
                                }

                                if (($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game']) || $hobbyUser['film'] == $hobbyOther['film']) {
                                    echo " en " . $hobbyOther['film'];
                                } else if ($hobbyUser['film'] == $hobbyOther['film']) {
                                    echo "jullie zijn allebei dol op " . $hobbyOther['film'];
                                } else {
                                }

                                if (($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game'] || $hobbyUser['film'] == $hobbyOther['film']) && $hobbyUser['muziek'] == $hobbyOther['muziek']) {
                                    echo " en " . $hobbyOther['muziek'];
                                } else if ($hobbyUser['muziek'] == $hobbyOther['muziek']) {
                                    echo "jullie zijn allebei dol op " . $hobbyOther['muziek'];
                                } else {
                                }

                                if (($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game'] || $hobbyUser['film'] == $hobbyOther['film'] || $hobbyUser['muziek'] == $hobbyOther['muziek']) && $hobbyUser['locatie'] == $hobbyOther['locatie']) {
                                    echo " en wonen in " . $hobbyOther['locatie'];
                                } else if ($hobbyUser['locatie'] == $hobbyOther['locatie']) {
                                    echo "jullie wonen allebei in " . $hobbyOther['locatie'];
                                } else {
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
            <?php endforeach;
            } ?>
        </div>
    </div>
        </div>
            
    </div>
</body>

</html>