<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");
    // Wanneer er op het formulier word gedrukt voort men deze if uit
if ($_POST){
    if (!empty($_POST)) {
        
            $user = new User();
            $validate = new Validate($_POST);
            $errors = $validate->validateForm();
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setPassword(htmlspecialchars($_POST['password']));
            if(empty($errors)){
                if($user->canILogin() == true){
                session_start();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['user_id'] = $user->getUserId();
                header('Location: index.php');
                } else {
                $error = "Email en passwoord komen niet overeen."; 
                }
            } else {
                $error = "Email en passwoord komen niet overeen.";  
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
            <button type="submit" class="btn left">Aanmelden</button>
            <p class="text-center mt-4"><a href="paswoord-vergeten.php" class="link mt-2 mr-0">Passwoord vergeten?</a></p>
        </div>
        
        <p class="text-center mt-4">Nog geen account? <a href="register.php" class="link">Registreer hier!</a></p>
        
    </form>
    </div>
    
</div>
</body>
</html>