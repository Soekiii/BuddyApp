<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
include_once (__DIR__ . "/classes/Db.php");

$conn= Db::getConnection(); // database connectie



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Register | Amigos</title>
</head>
<body>
<h1>Registreer je hier</h1>
        <form action="register.php" method="post">
            
            <div class="form__field">
            <label for="email">Emailadres</label>
            <input type="text"id="email" name="email" type="text"><br>
            </div>

            <div class="form__field">
            <label for="firstName">Voornaam</label>
            <input type="text" id="firstName" name="firstName" type="text"><br>
            </div>

            <div class="form__field">
            <label for="lastName">Naam</label>
            <input type="text" id="lastName" name="lastName" type="text"><br>
            </div>
            
            <div class="form__field">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password"><br>
            </div>
            <div class="form__field">
            <input type="submit" name="register" value="Registreer"></button>
            </div>
        </form>
</body>
</html>