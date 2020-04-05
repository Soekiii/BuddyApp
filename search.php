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

$hobby = "";
// eigenschappen ophalen van de user
$eigenschappen = Hobby::getEigenschappen($userID);
if(!empty($_POST['filter'])){
    if(isset($_POST['filter'])){
    
        $filter = $_POST['filter'];
        $hobby = Hobby::filterHobby($filter, $_SESSION['email']);

       
        
}
}
    

$searchResult = "";
        if(isset($_POST['submit-search'])){
            $search = htmlspecialchars($_POST['search']);
            $searchResult = User::userSearch($search,$email);
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
        <select name="filter" id="input-order" class="form-control">
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

    <!-- zoekresultaten uitlezen als er iets inzit-->
    <div class="result-container">
    <?php if (is_array($searchResult) || is_object($searchResult)) {
        foreach($searchResult as $r): ?>
        <h3><?php echo($r['firstname'] . " " . $r['lastname']); ?></h3>
        <?php endforeach; }?>
    </div>

     <!-- filter hobby uitlezen als er iets inzit-->
     <div class="filter-container">
    <?php if (is_array($hobby) || is_object($hobby)) { 
        foreach($hobby as $h): ?>
        <img src="avatars/<?php echo $h['avatar']; ?>" alt="" style="height:100px">
        <h3><?php echo($h['firstname'] . " " . $h['lastname'] . " " . $h['hobby']); ?></h3>
        <?php endforeach; } ?>
       
    </div>

</body>
</html>