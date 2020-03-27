<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
include_once (__DIR__ . "/classes/Db.php");




if(isset($_POST["register"])){
    
    $validation = new Validate(($_POST));  //nieuw object aanmaken & constructor opvullen
    $errorMessage =$validation->Emailvalidator(); //stuur errors door naar variabele
//var_dump($errorMessage);


    if(empty($errorMessage)){ // als variabele leeg is 

        $email = htmlspecialchars($_POST['email']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT, ["cost" => 12]);

        $gelukt= $validation->checkValidEmail($email); //---> Toon een fout als het email adres reeds in gebruik is
      if ($gelukt=false){$errorMessage ['email']="Howla, je mailadres is reeds bekend, ga naar inloggen aub";}
        if ($gelukt=true){

            // hier alle gegevens verzamelen voor inloggen en data bewaren op db
           $user= new user; 
           $statement= $user->registerNewUser($firstName, $lastName, $email, $password);
           if ($statement===true){
            header('Location: index.php');
           }
        }

       
    } 
 
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Registreer | Amigos</title>
</head>
<body>
<div class="form-row no-gutters">
    <div class="col-md-6 no-gutters">
    <div class="container-left d-flex justify-content-center align-items-center">
        <h2>Leer hier je nieuwe imd amigos kennen.</h2>
    </div>
    </div>
    <div class="col-md-6 col-md-3 no-gutters">
    <div class="container-right d-flex justify-content-center align-items-center">
        <form action="register.php" method="post">
    <div class="form-group mb-4">
        <h2>Registreer je hier op Amigos</h2>
    </div>
        <div class="row">
            <div class="col" >
            <label for="firstName">Voornaam</label>
        <?php if(isset($gelukt)): ?>
            <input type="text" id="firstName" name="firstName" type="text" class="form-control" placeholder="Voornaam">
        <?php else: ?>  
            <input type="text" id="firstName" name="firstName" type="text" class="form-control is-invalid" placeholder="Voornaam">
            <div class="invalid-feedback">
            <?php echo $errorMessage['firstName'] ?? '' ?>
            </div>
        <?php endif; ?>
            </div>

            <div class="col">
            <label for="lastName">Achteraam</label>
            <input type="text" id="lastName" name="lastName" type="text" class="form-control" placeholder="Achternaam"><br>

            <div class="errorMessage">
                <?php echo $errorMessage['lastName'] ?? '' ?>
                </div>
            </div>
        </div>
            <div class="form-group mb-1 ">
            <label for="email">Emailadres</label>
            <input type="text"id="email" name="email" type="text" class="form-control" placeholder="Email"> <br>
            
            <div class="errorMessage">
                <?php echo $errorMessage['email'] ?? '' ?>
                </div>
            </div>

            <div class="form-group">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password" class="form-control" placeholder="Paswoord"><br>
            <div class="errorMessage">
                <?php echo $errorMessage['password'] ?? '' ?>
                </div>
            </div>

            <div class="d-flex justify-content-between">
            <div class="form-group mb-4">
            <button type="submit" class="btn" style="width: 150px" id="register" name="register">Registreren</button>
            </div>
        </div>
        <p class="text-center mt-4">Hebt u al een account? <a href="login.php" class="link">Log in hier!</a></p>
        </form>
</body>
</html>