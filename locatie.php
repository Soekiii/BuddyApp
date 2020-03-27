<?php
session_start();
if (empty($_SESSION['email'])) {
    header('Location: login.php');
}

include_once(__DIR__."/classes/User.php");
include_once(__DIR__."/classes/Hobby.php");

//als post ingevuld is

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
    <h1>Vanwaar ben je?</h1>
    <?php if(isset($error)): ?>
        <div class="error"><p><?php echo $error?></p></div>
    <?php endif; ?>
        <form action="submit" method="post">
            <input type="text" id="locatie" name="locatie" placeholder="locatie">
            <input type="submit" value="Next" class="btn">
        </form>


</body>
</html>