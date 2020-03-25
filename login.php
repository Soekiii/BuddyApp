<?php
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Validate.php");

    // Wanneer er op het formulier word gedrukt voort men deze if uit
    if (!empty($_POST)) {
        $user = new User();
        $validation = new Validate(($_POST));
        $errors = $validation->validateForm();
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
            if ($user->canILogin($email, $password)) {
                session_start();
                $_SESSION['email'] = $email;
                
                header('Location: index.php');
            } else {
                $error = "Emailadress en passwoord komen niet overeen, probeer opnieuw.";       
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

<div class="form-row no-gutters">
    <div class="col-md-6 no-gutters">
    <div class="container-left d-flex justify-content-center align-items-center">
        <h2>Leer hier je nieuwe IMD amigos kennen.</h2>
    </div>
    </div>
    <div class="col-md-6 col-md-3 no-gutters">
    <div class="container-right d-flex justify-content-center align-items-center">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="justify-content-center">
    <h2>Login Amigos</h2>	
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="alert alert-danger col-30" role="alert"><p><?php echo $error?></p></div>
    <?php endif; ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="Email" name="email">
        </div>
            <!-- error message weergeven -->
            <div class="error">
            <?php echo $errors['email'] ?? '' ?>
            </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control" id="Password" name="password">
        </div>
            <!-- error message weergeven -->
            <div class="error">
            <?php echo $errors['password'] ?? '' ?>
            </div>
        <div class="form-group mb-2">
            <button type="submit" class="btn">Log in</button>
        
		<a href="register.php" class="link">registreer hier!</a>
       
       
    </form>
    </div>
    </div>
    </div>
    
</body>
</html>