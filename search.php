<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} 

$userID = $_SESSION['user_id'];
include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Hobby.php");
include_once(__DIR__."/classes/User.php");


$user = new User();
$email = $user->getEmail();

$hobby = "";
$film = "";
$game = "";
$muziek = "";
$locatie = "";
// eigenschappen ophalen van de user
$eigenschappen = Hobby::getEigenschappen($userID);
var_dump($userID);
var_dump($eigenschappen['hobby']);
if(!empty($_POST['filter'])){
    if(isset($_POST['filter'])){
    
        $filter = $_POST['filter'];
        $hobby = Hobby::filterHobby($filter, $_SESSION['email']);
        $film = Hobby::filterFilm($filter, $_SESSION['email']);
        $game = Hobby::filterGame($filter, $_SESSION['email']);
        $muziek = Hobby::filterMuziek($filter, $_SESSION['email']);
        $locatie = Hobby::filterLocatie($filter, $_SESSION['email']);

       
        
}
}
$searchResult = "";
        if(isset($_POST['submit-search'])){
            $search = htmlspecialchars($_POST['search']);
            $searchResult = User::userSearch($search,$_SESSION['email']);
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
    <title>Zoeken | Amigos</title>
</head>
<body>
    <div class="container-fluid" style="width: 336px">
    <div class="d-flex justify-content-center align-items-center text-center" >
    <div class="dropdown btn-lg text-center" >
    <!-- search form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="search" placeholder="search">
    <button type="submit" name="submit-search">Search</button>
    <!-- search error -->
    <?php if(isset($error)): ?>
        <div class="error" style="color: red"><?php echo $error; ?></div>
    <?php endif; ?>
    </form>
    <!-- dropdown form -->
    
    <div class="form">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
        <select name="filter" id="input-order" class="form-control mb-4">
        <!-- eigenschappen uitlezen van de user in een dropdown -->
        <option value="">Filter op eigen intresse</option>
        <option value="<?php echo $eigenschappen['hobby']; ?>"><?php echo $eigenschappen['hobby']; ?></option>
        <option value="<?php echo $eigenschappen['film']; ?>"><?php echo $eigenschappen['film']; ?></option>
        <option value="<?php echo $eigenschappen['game']; ?>"><?php echo $eigenschappen['game']; ?></option>
        <option value="<?php echo $eigenschappen['muziek']; ?>"><?php echo $eigenschappen['muziek']; ?></option>
        <option value="<?php echo $eigenschappen['locatie']; ?>"><?php echo $eigenschappen['locatie']; ?></option>
        </select>
        <button type="submit" name="filter-search">Search</button>
   
    </form>
    
    <!-- zoekresultaat hits -->
    <?php if(isset($result)): ?>
        <div class="result"><h2><?php echo $result; ?></h2></div>
    <?php endif; ?>
    <?php if(isset($resultCount)): ?>
        <div class="resultCount"><p2><?php echo $resultCount; ?></p2></div>
    <?php endif; ?>
    </div>
    </div>
    </div>
    </div>
    <!-- zoekresultaten uitlezen als er iets inzit-->
    <div class="d-flex justify-content-center align-items-center text-center" >
    <div class="container">
    <div class="row card-deck">
    
    <?php if (is_array($searchResult) || is_object($searchResult)) {
        foreach($searchResult as $r): ?>
    
    <div class="col-md-3">
    <div class="card" style="height: 200px">
        <div class="card-body"><img src="avatars/<?php echo $r['avatar']; ?>" alt="" class="img-fluid">
        <h3 class="card-title"><?php echo($r['firstname'] . " " . $r['lastname']); ?></h3>
        <p><?php echo $r['bio']; ?></p>
        </div>
        </div>
        </div>
        <?php endforeach; }?>
        </>
    </div>
    </div>

     <!-- filter hobby uitlezen als er iets inzit-->
     <div class="filter-container">
    <?php if (is_array($hobby) || is_object($hobby)) { 
        foreach($hobby as $h): ?>
        <img src="avatars/<?php echo $h['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($h['firstname'] . " " . $h['lastname'] . " " . $h['hobby']); ?></h3>
        <?php endforeach; } ?>
    </div>
    <!-- filter film uitlezen als er iets inzit-->
    <div class="filter-container">
    <?php if (is_array($film) || is_object($film)) { 
        foreach($film as $f): ?>
        <img src="avatars/<?php echo $f['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($f['firstname'] . " " . $f['lastname'] . " " . $f['film']); ?></h3>
        <?php endforeach; }?>
    </div>
     <!-- filter game uitlezen als er iets inzit-->
     <div class="filter-container">
     <?php if (is_array($game) || is_object($game)) { 
        foreach($game as $g): ?>
        <img src="avatars/<?php echo $g['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($g['firstname'] . " " . $g['lastname'] . " " . $g['game']); ?></h3>
        <?php endforeach; }?>
    </div>
     <!-- filter muziek uitlezen als er iets inzit-->
     <div class="filter-container">
     <?php if (is_array($muziek) || is_object($muziek)) { 
        foreach($muziek as $m): ?>
        <img src="avatars/<?php echo $m['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($m['firstname'] . " " . $m['lastname'] . " " . $m['muziek']); ?></h3>
        <?php endforeach; }?>
    </div>
     <!-- filter film locatie als er iets inzit-->
     <div class="filter-container">
     <?php if (is_array($locatie) || is_object($locatie)) { 
        foreach($locatie as $l): ?>
        <img src="avatars/<?php echo $l['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($l['firstname'] . " " . $l['lastname'] . " " . $l['locatie']); ?></h3>
        <?php endforeach; }?>
    </div>


    
    
</body>
</html>