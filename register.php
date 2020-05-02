<?php
session_start();
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
include_once (__DIR__ . "/classes/Db.php");

// email veld nakijken
if(isset($_POST["email"])){
 
 $searchEmail = trim($_POST["email"]);
 $e = new User();
 //$test = $e->searchEmail($searchEmail);
 echo $e->searchEmail($searchEmail);
 //var_dump($test);
}


if(isset($_POST["register"])){

       if (!empty($_POST)) {
            try {
                $user = new User();
                $validate = new Validate($_POST);
                //eerst checken of de email al bestaat voor je alle variabelen vult
                $user->setEmail(htmlspecialchars($_POST['email']));
                $user->setPassword(htmlspecialchars($_POST['password']));
                $user->setFirstname(htmlspecialchars($_POST['firstName']));
                $user->setLastname(htmlspecialchars($_POST['lastName']));
                $user->setBuddy(htmlspecialchars($_POST['buddy'])); // ben ik buddy of zoek ik buddy?
                    // hier alle gegevens verzamelen voor inloggen en data bewaren op db
                $validate->Emailvalidator();
                $errorMessage=$validate->getErrors();
                
                if (empty($errorMessage)){ //als er geen errorkes zijn
                    $mailok=$validate->checkValidEmail(); //kijk na of de email al bestaat
                    $errorMessage=$validate->getErrors(); //kijk terug even na of er nog errors zijn?

                    if($mailok==true){
                        
                        $statement= $user->registerNewUser();
                        if ($statement===true){
                            
                            //header('Location: index.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Registreer | Amigos</title>
</head>
<body>
<div class="d-md-flex h-md-100 align-items-center">
<!-- First Half -->

<div class="col-md-6 p-0 bg-indigo h-md-100">
    <div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
        <div class="logoarea pt-5 pb-5">
        <img class="mb-3" src="avatars/Logophp_final_wit.svg" width="50%">
        <h2>Leer hier je nieuwe imd amigos kennen.</h2>
        </div>
    </div>
</div>

<div class="col-md-6 p-0 bg-white h-md-100 loginarea">
		<div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center">
        <form action="register.php" method="post" class="border rounded p-5">
    <div class="form-group my-4">
        <h2>Registreer je hier op Amigos</h2>
    <!-- succes message -->
    <?php if(isset($_SESSION['succes'])){
        echo '<div class="alert alert-success" role="alert">';
        echo $_SESSION['succes'];
        echo '</div>';
        unset($_SESSION['succes']);
    } ?>
    </div>
        <div class="row mb-3">
            <div class="col">
            <label for="firstName">Voornaam</label>
        <?php if(empty($errorMessage['firstName'])): ?>
            <input type="text" id="firstName" name="firstName" type="text" class="form-control" placeholder="Voornaam">
        <?php else: ?>  
            <input type="text" id="firstName" name="firstName" type="text" class="form-control is-invalid" placeholder="Voornaam">
            <div class="invalid-feedback">
            <?php echo $errorMessage['firstName'] ?? '' ?>
            </div>
        <?php endif; ?>
            </div>

            <div class="col">
            <label for="lastName">Achternaam</label>
        <?php if(empty($errorMessage['lastName'])): ?>
            <input type="text" id="lastName" name="lastName" type="text" class="form-control" placeholder="Achternaam">
        <?php else: ?>     
            <input type="text" id="lastName" name="lastName" type="text" class="form-control is-invalid" placeholder="Achternaam">
            <div class="invalid-feedback">
            <?php echo $errorMessage['lastName'] ?? '' ?>
            </div>
        <?php endif; ?>
            </div>
        </div>
            <div class="form-group mb-3">
            <label for="email">Emailadres</label>
        <?php if(empty($errorMessage['email'])): ?>
            <input type="text" id="email" name="email" type="text" class="form-control" placeholder="Email"> 
            <div id="emailGebruik"></div>
            
        <?php else: ?>  
            <input type="text"id="email" name="email" type="text" class="form-control is-invalid" placeholder="Email">
            <div class="invalid-feedback">
            <div id="emailGebruik"></div>
            <?php echo $errorMessage['email'] ?? '' ?>
            </div>
        <?php endif; ?>
            </div>

            <div class="form-group mb-4">
            <label for="password">Paswoord</label>

            
        <?php if(empty($errorMessage['password'])): ?>
            <input type="password" id="password"  name="password" type="password" class="form-control" placeholder="Paswoord" oninput="schuifbalk()">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"> % safe password
                </div>
            </div>
        <?php else: ?>  
            
            <input type="password" id="password tekst" name="password" type="password" class="form-control is-invalid" placeholder="Paswoord" oninput="schuifbalk()" > 
            <div class="invalid-feedback">
            
            </div>
                <?php echo $errorMessage['password'] ?? '' ?>
                </div>
                
        <?php endif; ?>
            </div>
            <div class="form-group mb-4 d-flex justify-content-between">
                <div class="radio">
            <input type="radio" id="seekBuddy" name="buddy" checked value="0"> <label> Ik zoek een buddy </label>
                </div>
                <div class="radio">
            <input type="radio" id="iAmBuddy" name="buddy" value="1">
            <label> Ik ben een buddy </label>
                </div>
            </div>
            
            <div class="form-group mb-4">
            <button type="submit" class="btn" style="width: 150px" id="register" name="register">Registreren</button>
            </div>
    
        <p class="text-center mt-4">Hebt u al een account? <a href="login.php" class="link">Log in hier!</a></p>
        </form>
        </div>
</div>
<script src="emailChecker.js"></script>
<script>
 function schuifbalk() { 
     
            var  progressBar  =  $('.progress-bar');                                                       
            var mijnText = 0;
            mijnText= document.getElementById('password').value;
            var lengteString = mijnText.length;
            console.log(lengteString);

            progressBar.css('width', (lengteString * 10)  +  '%');                
            progressBar.attr('aria-valuenow', (lengteString * 10)); 
            document.getElementById('progress-bar').innerHTML = (lengteString*10) + '%';
            if (lengteString>=10){
                document.getElementById('progress-bar').innerHTML = 'safe password';                

            }
            
        


        }

</script>
</body>
</html>