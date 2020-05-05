<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} 

$userID = $_SESSION['user_id'];

include_once(__DIR__."/classes/User.php");
include_once(__DIR__."/classes/Hobby.php");


if(isset($_POST["muziek"])){
    
    if(!empty($_POST["muziek"] && $_POST['game'] && $_POST['film'] && $_POST['hobby'] && $_POST['locatie'])){
    try{
        $hobby = new Hobby();
        $hobby->setLocatie(htmlspecialchars($_POST['locatie']));
        $hobby->setHobby(htmlspecialchars($_POST['hobby']));
        $hobby->setFilm(htmlspecialchars($_POST['film']));
        $hobby->setGame(htmlspecialchars($_POST['game']));
        $hobby->setMuziek(htmlspecialchars($_POST['muziek']));
        $hobby->setUserID(htmlspecialchars($userID));
        $hobby->hobbyInvullen();
        //$hobby->hobbyInvullen($_POST);

        
       header('Location: index.php');




    }
    catch(throwable $e){
        $error = "Er ging iets mis!";
    }
}else {
    $error = "Vul alle velden in";
}
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profiel</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>

        h1{
            font-size: 1em;
        }
        
    </style>
<body> 
<div class="container-fluid" style="width: 336px">
<div class="d-flex justify-content-center align-items-center text-center" >
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
    <h1>Hey! Vul deze velden in om nog makkelijker een match te vinden!</h1>
    
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="form alert alert-danger"role="alert">
            <?php echo $error?>
        </div>
    <?php endif; ?>
    <div class="dropdown btn-lg text-center" >
    <div class="form ">
        <!--<input type="text" id="locatie" name="locatie">-->
        <select id="locatie" name="locatie" class="form-control mb-4">
            <option value="" class="dropdown-item disabled">Uit welke provincie ben je afkomstig?</option>
            <option value="West-vlaanderen">West-Vlaanderen</option>
            <option value="Oost-Vlaandere">Oost-Vlaanderen</option>
            <option value="Vlaams-Brabant">Vlaams-Brabant</option>
            <option value="Antwerpen">Antwerpen</option>
            <option value="Limburg">Limburg</option>
            <option value="Namen">Namen</option>
            <option value="Henegouwen">Henegouwen</option>
            <option value="Vlaams-brabant">Vlaams-Brabants</option>
            <option value="Luik">Luik</option>
            <option value="Luxemburg">Luxemburg</option>
            <option value="Ander land">Ander land</option>
            </select>
    </div>
    <div class="form">
        <!--<input type="text" id="hobby" name="hobby">-->
        <select id="hobby" name="hobby" class="form-control mb-4" >
            <option value="" class="dropdown-item disabled">Wat is je hobby?</option>
            <option value="Fotografie">Fotografie</option>
            <option value="Dansen">Dansen</option>
            <option value="Koken">Koken</option>
            <option value="Tekenen">Tekenen</option>
            <option value="Coderen">Coderen</option>
            <option value="Gamen">Gamen</option>
            <option value="Sport">Sport</option>
            <option value="Auto's">Auto's</option>
        </select>
    </div>
    <div class="form">
        <!--<input type="text" id="game" name="game">-->
        <select id="game" name="game" class="form-control mb-4">
            <option value="" class="dropdown-item disabled">Welk videospel speel je graag?</option>
            <option value="World of Warcraft">World of Warcraft</option>
            <option value="Call of Duty">Call of Duty</option>
            <option value="Mario Kart">Mario Kart</option>
            <option value="Super Smash bros">Super Smash bros</option>
            <option value="Fortnite">Fortnite</option>
            <option value="Apex Legends">Apex Legends</option>
            <option value="FIFA">FIFA</option>
            <option value="Animal Crossing">Animal Crossing</option>
        </select>
    </div>
    <div class="form">
        <!--<input type="text" id="film" name="film">-->
        <select id="film" name="film" class="form-control mb-4">
            <option value="" class="dropdown-item disabled">Naar welk filmgenre kijk je graag?</option>
            <option value="Horror">Horror</option>
            <option value="Drama">Drama</option>
            <option value="Comedy">Comedy</option>
            <option value="Sciencefiction">Science Fiction</option>
            <option value="Actie">Actie</option>
            <option value="Animatie">Animatie</option>
            <option value="Romantisch">Romantisch</option>
            <option value="Thriller">Thriller</option>
        </select>
    </div>
    <div class="form">
        <!--<input type="text" id="muziek" name="muziek">-->
        <select id="muziek" name="muziek"  class="form-control">
            <option value="" class="dropdown-item disabled">Naar welk muziekgenre luister je graag?</option>
            <option value="Metal">Metal</option>
            <option value="Pop">Pop</option>
            <option value="RnB">RnB</option>
            <option value="Hip-Hop">Hip-Hop</option>
            <option value="Rap">Rap</option>
            <option value="Jazz">Jazz</option>
            <option value="Drum 'n Bass">Drum'n Bass</option>
            <option value="Dance">Dance</option>
        </select>
    </div>
      
    <div class="form-group mt-4">
        <button type="submit" class="btn" style="width: 336px">Voeg eigenschappen toe!</button>
    </div>

 
    </form>
</div>
    </div>





</body>
</html>