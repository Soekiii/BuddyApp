<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
    // Wanneer er op het formulier word gedrukt voort men deze if uit
  session_start();
if ( !isset($_SESSION['pogingen']) ){   
    $_SESSION['pogingen']=4;
} 
if ($_SESSION['pogingen'] <=0 ){   
    $_SESSION['pogingen']=4;
} 

if ($_POST){
  
    
    if (!empty($_POST)) {
            $_SESSION['pogingen'] = $_SESSION['pogingen']-1;
            $user = new User();
            $validate = new Validate($_POST);
            $errors = $validate->validateForm();
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setPassword(htmlspecialchars($_POST['password']));
            if(empty($errors)){
            if($user->canILogin() == true){
           
                } else {

                        $error = 'Email en passwoord komen niet overeen. nog '.$_SESSION['pogingen'].' pogingen'; 
        
                }
            } else {
                    // error om aan te geven dat je 3 pogingen hebt en anders 10s moet wachten. 
                    $error = 'De gegevens die je invoerde zijn niet correct. <br> 
                    Na 3 verkeerde pogingen, moet je 10 seconden wachten. <br> 
                    Je hebt nog '.$_SESSION['pogingen'].' pogingen';  
              
            }
        }
    }
        
        
      
            
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Amigos</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
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
<!-- Second Half -->
<div class="col-md-6 p-0 bg-white h-md-100 loginarea">
		<div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="border rounded p-5">
<div class="form-group mb-4">
    <h2>Log in op Amigos</h2>	
</div>
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="form-group alert alert-danger" role="alert">
            <?php echo $error?>
        </div>
    <?php endif; ?>
       
        <div class="form-group mb-4">
            <label for="email">Emailadres</label>
        <?php if(!isset($error)): ?>
            <input type="text" class="form-control" id="Email" name="email" placeholder="email">
        <?php else: ?>
            <input type="text" class="form-control is-invalid" id="Email" name="email" placeholder="email">
            <div class="invalid-feedback">
            <?php echo $errors['email'] ?? '' ?>
            </div>
        <?php endif; ?>
        </div>
        <div class="form-group mb-4">
            <label for="Password">Passwoord</label>
        <?php if(!isset($error)): ?>
            <input type="password" class="form-control" id="Password" name="password" placeholder="passwoord">
        <?php else: ?>
            <input type="password" class="form-control is-invalid" id="Password" name="password" placeholder="password">
            <div class="invalid-feedback">
            <?php echo $errors['password'] ?? '' ?>
            </div>
        <?php endif; ?>
        </div>
        
            
        
        <div class="form-group mb-4 d-flex justify-content-between">
            <button type="submit"  id="btn" class="btn left">Aanmelden</button>
        </div>
        
        <p class="text-center mt-4">Nog geen account? <a href="register.php" class="link">Registreer hier!</a></p>
        
    </form>
    </div>
    
</div>
    </div>
    </div>
    <script>

    // JS voor gebruik van functie om Brute force Attacking te bemoeilijken. 
    var button;
    var aantalkeer;
    var msg;
            //initialiseer functie om sessie gebruiken (server sided) via JS-AJAX (client sided). 
            //Wanneer sessie wordt gestart krijg je 3 pogingen om in te loggen. 
            //nadien wordt button geblokkeerd voor 10 seconden. 
    function init() {
        

    }
    
      if ((msg = <?php echo json_encode($_SESSION['pogingen'])?>) === 0){ 
        //php.net: JSON_encode Returns a string containing the JSON representation of the supplied value
        wachten();
     }
 
     function myFunction() {
     document.getElementById('btn').disabled = false;
      
     }


     function wachten(){ 
        document.getElementById('btn').disabled = true;

        setTimeout(myFunction, 10000)
     }

    // van zodra de pagina wordt herladen de functie 'init' aanroepen. 
    window.addEventListener("load", init);
    

    </script>

</body>
</html>