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
<<<<<<< HEAD
<div class="form-row no-gutters">
    <div class="col-md-6 no-gutters">
    <div class="container-left d-flex justify-content-center align-items-center">
        <h2>Leer hier je nieuwe imd amigos kennen.</h2>
    </div>
    </div>
    <div class="col-md-6 col-md-3 no-gutters">
    <div class="container-right d-flex justify-content-center align-items-center">
=======
<h1>Go Go Amigos, Registreer je hier! </h1>
>>>>>>> feature1
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
            
<<<<<<< HEAD
            <div class="errorMessage">
                <?php echo $errorMessage['email'] ?? '' ?>
                </div>
            </div>

            <div class="form-group">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password" class="form-control" placeholder="Paswoord"><br>
=======
            <div class="form__field">
            <label for="password">Paswoord</label>
            <input type="password" id="password" name="password" type="password"><br>
>>>>>>> feature1
            <div class="errorMessage">
                <?php echo $errorMessage['password'] ?? '' ?>
                </div>
            </div>
<<<<<<< HEAD

            <div class="d-flex justify-content-between">
            <div class="form-group mb-4">
            <button type="submit" class="btn" style="width: 150px" id="register" name="register">Registreren</button>
=======
            <div class="form__field">
            <input type="submit" id="register" name="register" value="Registreer" >
>>>>>>> feature1
            </div>
        </div>
        <p class="text-center mt-4">Hebt u al een account? <a href="login.php" class="link">Log in hier!</a></p>
        </form>
</body>
</html>