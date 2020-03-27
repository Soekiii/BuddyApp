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
        $hobby->hobbyInvullen($_POST);
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
    <h1>Wat zijn je hobbies?</h1>
    <p>Vul deze 5 velden in met je interesses / hobbies.</p>
    <!-- als er een error bestaat -->
    <?php if(isset($error)): ?>
        <div class="error"><p><?php echo $error?></p></div>
    <?php endif; ?>

    <div class="">
        <label for="hobby">Hobby 1</label>
        <input type="text" id="hobby" name="hobby">
    </div>
    <div class="">
        <label for="hobby">Hobby 2</label>
        <input type="text" id="hobby" name="hobby">
    </div>
    <div class="">
        <label for="hobby">Hobby 3</label>
        <input type="text" id="hobby" name="hobby">
    </div>
    <div class="">
        <label for="hobby">Hobby 4</label>
        <input type="text" id="hobby" name="hobby">
    </div>
    <div class="">
        <label for="hobby">Hobby 5</label>
        <input type="text" id="hobby" name="hobby">
    </div>
        
    <div><input type="submit" value="Add!" class="btn"></div>
    </form>
</body>
</html>