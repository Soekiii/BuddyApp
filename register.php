<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
include_once (__DIR__ . "/classes/Db.php");


if(isset($_POST["register"])){

       if (!empty($_POST)) {
            try {
                $user = new User();
                $validate = new Validate($_POST);
                //eerst checken of de email al bestaat voor je alle variabelen vult
                $user->setEmail(htmlspecialchars($_POST['email']));
             //   $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT, ["cost" => 12]);
                $user->setPassword(htmlspecialchars($_POST['password']));
                $user->setFirstname(htmlspecialchars($_POST['firstName']));
                $user->setLastname(htmlspecialchars($_POST['lastName']));
                    // hier alle gegevens verzamelen voor inloggen en data bewaren op db
                $validate->Emailvalidator();
                $errorMessage=$validate->getErrors();
                
                if (empty($errorMessage)){ //als er geen errorkes zijn
                    $mailok=$validate->checkValidEmail(); //kijk na of de email al bestaat
                    $errorMessage=$validate->getErrors(); //kijk terug even na of er nog errors zijn?

                    if($mailok==true){
                       
                        $statement= $user->registerNewUser();
                        if ($statement===true){
                            header('Location: index.php');
                            }   
    
                    }

                }
                
                
           
            } catch (\Throwable $t) { 
                  
               
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
<h1>Go Go Amigos, Registreer je hier! </h1>
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
                <?php echo $errorMessage['firstName'] ?? '' ?>
                </div>
            </div>

            <div class="form__field">
            <label for="lastName">Naam</label>
            <input type="text" id="lastName" name="lastName" type="text"><br>

            <div class="errorMessage">
                <?php echo $errorMessage['lastName'] ?? '' ?>
                </div>
            </div>
            
            <div class="form__field">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password"><br>
            <div class="errorMessage">
                <?php echo $errorMessage['password'] ?? '' ?>
                </div>
            </div>
            <div class="form__field">
            <input type="submit" id="register" name="register" value="Registreer" >
            </div>
        </form>
</body>
</html>