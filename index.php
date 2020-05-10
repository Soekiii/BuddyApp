<?php
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

// ====== ZOEKEN OP NAAM ======
$searchResult = "";
if (isset($_POST['submit'])) {
    $search = htmlspecialchars($_POST['search']);
    if (empty($search)) {
        $searchResult = "";
    } else {
        $searchResult = User::userSearch($search, $_SESSION['email']);
        //var_dump($searchResult);
    }
    // als de array gelijk is aan NULL of O dan geeft die error weer
    if ($searchResult == NULL || $searchResult == 0) {
    } else {
        $result = "Zoekresultaat";
        if (count($searchResult) > 1) {
            $resultCount = "Er zijn " . count($searchResult) . " zoekresultaten gevonden.";
        } else {
            $resultCount = "Er is " . count($searchResult) . " zoekresultaat gevonden.";
        }
    }
}
// ====== ZOEKEN OP EIGENSCHAP ======

// eigenschappen ophalen van de user
$hobby = "";
$film = "";
$game = "";
$muziek = "";
$locatie = "";
$eigenschappen = Hobby::getEigenschappen($userID);
if (!empty($_POST['filter'])) {
    if (isset($_POST['submit'])) {

        $filter = $_POST['filter'];
        $hobby = Hobby::filterHobby($filter, $_SESSION['email']);
        $film = Hobby::filterFilm($filter, $_SESSION['email']);
        $game = Hobby::filterGame($filter, $_SESSION['email']);
        $muziek = Hobby::filterMuziek($filter, $_SESSION['email']);
        $locatie = Hobby::filterLocatie($filter, $_SESSION['email']);
    }
}
// ====== LOKAAL ZOEKEN ======
$lokaal = new User();
$l = $lokaal->lokalen();
if (isset($_POST['submit'])) {
    $lokalen = $_POST['lokaalInfo'];
    $lokaalInfo = $lokaal->lokaalInfo($lokalen);
}



// ====== SENDING BUDDY REQUESTS ======
// when button "send buddy request" is clicked
if (!empty($_POST['sendRequest'])) {
    $request = new Buddy();
    // 1. retrieve buddyID value from $_POST
    $buddyID = $_POST['buddyID'];
    // 2. insert userID, buddyID and status=0 in db (buddy table)
    $request->setUserID($userID);
    $request->setBuddyID($buddyID);
    $buddyName = $request->buddyData($buddyID);
    $sendRequest = $request->buddyRequest($userID, $buddyID);
    $succes = "Buddy verzoek is verstuurd naar " . $buddyName['firstname'] . " " . $buddyName['lastname'];
    header("Location: index.php");
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
if (!empty($_POST['newPost'])) {
    $newPost = new Forum();
    $newPost->setUserID($userID);
    $postTxt = $_POST['postTxt'];
    $newPost->setPostTxt($postTxt);
    $createPost = $newPost->newPost($userID, $postTxt);
    header("Location: index.php");
} else {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>
    <!-- <style>
        .my-container {
            border: 1px solid green;
        }

        .my-row {
            border: 3px solid red;
        
        }

        .my-col {
            border: 3px dotted blue;
        }
    </style> -->
</head>

<body>
    <div class="container my-container">
        <!--hier probeersel om code terug te krijgen van User.php - zelfde ook doen op andere pagina whoAreBuddies.php  -->

        <div class="row justify-content-center row mt-4">
            <div class="col-md-4">
                <p class="alert alert-primary text-center" role="alert">Geregistreerde gebruikers: <span class="badge"><?php echo $userNumbers['numbersOfUsers']; ?></span></p>
            </div>
            <div class="col-md-4">
                <p class="alert alert-primary text-center" role="alert">Gematchte buddies: <span class="badge"><?php echo $matchedBuddiesNumber['numbersOfMatchedBuddies']; ?></span></p>
            </div>
        </div>

        <!-- ====== ZOEKBALk MET 3 ZOEKVELDEN ====== -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="filter-form my-md-5">
            <div class="row my-row">
                <!-- zoekveld -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="zoeken">Zoeken</label>
                        <input class="form-control" type="text" name="search" placeholder="search">
                        <!-- zoekveld error -->
                        <?php if (isset($error)) : ?>
                            <div class="error" style="color: red"><?php echo $error; ?></div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- eigenschappen filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="eigenschap">Eigenschap: </label>
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
                </div>

                <!-- lokaal-vinder -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lokaalZoeken">Lokaal: </label>
                        <select name="lokaalInfo" id="input-order" class="form-control">
                            <!-- lokalen uitlezen in een dropdown -->
                            <option class="dropdown-item disabled" value="">Zoek een lokaal</option>
                            <?php
                            if (!empty($lokaal)) {
                                foreach ($l as $key => $value) {
                                    echo '<option value="' . $l[$key]['location'] . '">' . $l[$key]['location'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- zoekknop -->
                <div class="col-md-3 mt-md-4">
                    <div class="form-group">

                        <button class="btn btn-light form-control" type="submit" name="submit">Zoeken</button>
                    </div>
                </div>




            </div>
        </form>
        <!-- ====== ZOEKRESULTAAT OP NAAM OUTPUT ====== -->
        <?php if (isset($result)) : ?>
            <div class="result">
                <h2><?php echo $result; ?></h2>
            </div>
        <?php endif; ?>
        <?php if (isset($resultCount)) : ?>
            <div class="row my-row">
                <div class="col-8">

                    <p2><?php echo $resultCount; ?></p2>

                </div>
            </div>

        <?php endif; ?>

        <?php if (isset($_POST['submit'])) { ?>
            <div class="row my-row">
                <!-- lokalen info laten zien aan de gebruiker -->



                <?php if (!empty($lokaalInfo)) {
                    foreach ($lokaalInfo as $info) : ?>
                        <div class="col my-col">
                            <div class="form-group">
                                <div class="alert alert-primary" role="alert">
                                    <p><?php echo $info; ?></p>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                } ?>



                <!-- zoekresultaten uitlezen als er iets inzit-->



                <?php if (empty($search)) {
                } else {
                    //if (is_array($searchResult) || is_object($searchResult)) {
                    foreach ($searchResult as $r) : ?>

                        <div class="col-md-3 my-col">
                            <div class="form-group">


                                <div class="bold"><?php echo htmlspecialchars($r['firstname'] . " " . $r['lastname']); ?></div>
                                <p><?php echo htmlspecialchars($r['bio']); ?></p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <?php foreach ($hobbyOthers as $hobbyOther) : ?>
                                        <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                        <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <?php endforeach; ?>
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>


                            </div>
                        </div>
                <?php endforeach;
                } ?>



                <!-- ====== FILTER OUTPUT ====== -->
                <!-- filter hobby uitlezen als er iets inzit-->

                <?php if (is_array($hobby) || is_object($hobby)) {
                    foreach ($hobby as $h) : ?>
                        <div class="col-md-3 my-col">
                            <div class="form-group">

                                <div class="bold"><?php echo ($h['firstname'] . " " . $h['lastname']); ?></div>
                                <p><?php echo $h['hobby']; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                    <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>

                            </div>
                        </div>
                <?php endforeach;
                } ?>

                <!-- filter film uitlezen als er iets inzit-->

                <?php if (is_array($film) || is_object($film)) {
                    foreach ($film as $f) : ?>
                        <div class="col-md-3 my-col">
                            <div class="form-group">
                                <div class="bold"><?php echo ($f['firstname'] . " " . $f['lastname']); ?></div>
                                <p><?php echo $f['film']; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                    <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>
                            </div>
                        </div>
                <?php endforeach;
                } ?>

                <!-- filter game uitlezen als er iets inzit-->

                <?php if (is_array($game) || is_object($game)) {
                    foreach ($game as $g) : ?>
                        <div class="col-md-3 my-col">
                            <div class="form-group">
                                <div class="bold"><?php echo ($g['firstname'] . " " . $g['lastname']); ?></div>
                                <p><?php echo $g['game']; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                    <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>
                            </div>
                        </div>

                <?php endforeach;
                } ?>

                <!-- filter muziek uitlezen als er iets inzit-->

                <?php if (is_array($muziek) || is_object($muziek)) {
                    foreach ($muziek as $m) : ?>
                        <div class="col-md-3 my-col">
                            <div class="form-group">
                                <div class="bold"><?php echo ($m['firstname'] . " " . $m['lastname'] . " " . $m['muziek']); ?></div>
                                <p><?php echo $m['muziek']; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                    <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>
                            </div>
                        </div>

                <?php endforeach;
                } ?>

                <!-- filter film locatie als er iets inzit-->

                <?php if (is_array($locatie) || is_object($locatie)) {
                    foreach ($locatie as $l) : ?>
                        <div class="col-md-3 my-col">
                            <div class="form-group">
                                <div class="bold"><?php echo ($l['firstname'] . " " . $l['lastname'] . " " . $l['locatie']); ?></div>
                                <p><?php echo $l['locatie']; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                    <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                    <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                </form>
                            </div>
                        </div>

                <?php endforeach;
                } ?>

            </div>


        <?php } ?>
        <!-- ====== FORUM ====== -->



        <div class="row mt-md-5 my-row">
            <div class="col-md-8 my-col">
                <div class="form-group">
                    <div class="mb-4">
                        <h3 class="mb-4">Forum</h3>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postBtn">Plaats een nieuw bericht</button>
                    </div>
                    <div class="modal fade" id="postBtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">Nieuw bericht</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="newPost">
                                        <div class="form-group">
                                            <label for="message-text" class="control-label">Stel hier je vraag:</label>
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
                        <div class="row my-row">
                            <div class="col my-col">
                                <div class="card">
                                    <div class="card-body ">
                                        <?php echo htmlspecialchars($post['firstname'] . " " . $post['lastname'] . ":"); ?>

                                        <input type="hidden" value="<?php echo $post['postID'] ?>">
                                        <a href="topic.php?id=<?php echo $post['postID'] ?>" class="">
                                            <?php echo $post['postTxt']; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>




            <!-- ====== POTENTIELE AMIGOS(MATCHES) ====== -->

            <div class="col-md-4 my-col">
                <div class="form-group">
                    <h3 class="mb-4">Potentiële Amigos</h3>

                    <!-- vriendverzoek verzonden  -->
                    <?php if (!empty($succes)) { ?>
                        <div class="col my-col">

                            <div class="alert alert-primary" role="alert">
                                <p><?php echo $succes; ?></p>
                            </div>

                        </div>
                    <?php }  ?>

                    <?php if ($available != "1") {
                        foreach ($hobbyOthers as $hobbyOther) : ?>
                            <div class="row my-row">
                                <div class="col my-col">
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
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title"><?php echo $hobbyOther['firstname'] . " " . $hobbyOther['lastname'] . ":"; ?></div>

                                                <div class="card-text">
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

                                                    if (($hobbyUser['hobby'] == $hobbyOther['hobby'] || $hobbyUser['game'] == $hobbyOther['game']) && $hobbyUser['film'] == $hobbyOther['film']) {
                                                        echo " en " . $hobbyUser['film'];
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
                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                        <input type="hidden" name="userID" id="" value="<?php echo $userID ?>">
                                                        <input type="hidden" name="buddyID" class="buddyID" id="" value="<?php echo $hobbyOther['userID'] ?>">
                                                        <input type="submit" class="request btn btn-primary mt-4" value="stuur verzoek" name="sendRequest">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>
                            </div>
                    <?php endforeach;
                    } ?>
                </div>
            </div>
        </div>
    </div> <!-- container -->

</body>

</html>