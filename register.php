<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
include_once (__DIR__ . "/classes/Db.php");




if(isset($_POST["register"])){
    
    $validation = new Validate(($_POST));  //nieuw object aanmaken & constructor opvullen
    $errorMessage =$validation->Emailvalidator(); //stuur errors door naar variabele

    if(empty($errorMessage)){ // als variabele leeg is 

        $email = htmlspecialchars($_POST['email']);
        $user=new User();
        $dumpen= $user->checkValidEmail($email);
        //var_dump($dumpen);
       echo $dumpen['email'];
    } 
 
}

//---> Dit adres mag nog niet bestaan, dubbele accounts aanmaken mag dus niet mogelijk zijn,
//                      ---> Toon een fout als het email adres reeds in gebruik is
// voornaam:            ---> check of voornaam is ingevuld! + melding indien niet ingevuld
// achternaam:          ---> check of achternaam is ingevuld! + melding indien niet ingevuld
// Password: 
//                      ---> password (veilig bewaard via bcrypt!)     
//       check password ---> als het niet lang genoeg is

// alles ok?   alles in de database bewaren en afsluiten en daarna ---> doorverwijzen naar home

// zorg voor een foutmelding indien het aanmaken van een account niet lukt
// valideer al wat kan mislopen in dit formulier via PHP en toon gebruiksvriendelijke foutmeldingen




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
<h1>Registreer je hier</h1>
        <form action="register.php" method="post">
            
            <div class="form__field">
            <label for="email">Emailadres</label>
            <input type="text"id="email" name="email" type="text"> <br>
            
            <div class="errorMessage">
                <?php echo $errorMessage['email'] ?? '' ?>
                </div>
            
            </div>

            <div class="form__field" >
            <label for="firstName">Voornaam</label>
            <input type="text" id="firstName" name="firstName" type="text"  ><br>
            
            <div class="errorMessage">
                <?php echo $errors['password'] ?? '' ?>
                </div>
            </div>

            <div class="form__field">
            <label for="lastName">Naam</label>
            <input type="text" id="lastName" name="lastName" type="text"><br>
            <div class="errorMessage">
                <?php echo $errors['password'] ?? '' ?>
                </div>
            </div>
            
            <div class="form__field">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password"><br>
            <div class="errorMessage">
                <?php echo $errors['password'] ?? '' ?>
                </div>
            </div>
            <div class="form__field">
            <input type="submit" id="register" name="register" value="register" >
            </div>
        </form>
</body>
</html>