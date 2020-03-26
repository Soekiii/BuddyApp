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
                $_SESSION['user_id'] = $user->getUserId($email);
                
                header('Location: index.php');
            } else {
                $error = "Email en passwoord komen niet overeen.";       
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
        <h2>Leer hier je nieuwe imd amigos kennen.</h2>
    </div>
    </div>
    <div class="col-md-6 col-md-3 no-gutters">
    <div class="container-right d-flex justify-content-center align-items-center">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="justify-content-center">
<div class="form-group">
    <h2>Login Amigos</h2>	

</div>
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="form-group alert alert-danger" role="alert">
            <?php echo $error?>
        </div>
    <?php endif; ?>
        <?php if(!isset($error)): ?>
        <div class="form-group" style="width: 336px">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="Email" name="email" placeholder="email">
        </div>
        <?php else: ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control is-invalid" id="Email" name="email" placeholder="email">
            <div class="invalid-feedback">
            <?php echo $errors['email'] ?? '' ?>
            </div>
        </div>
        <?php endif; ?>
            
        <?php if(!isset($error)): ?>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control" id="Password" name="password" placeholder="password">
        </div>
        <?php else: ?>
            <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control is-invalid" id="Password" name="password" placeholder="password">
            <div class="invalid-feedback">
            <?php echo $errors['password'] ?? '' ?>
            </div>
        </div>
        <?php endif; ?>
            
        <div class="d-flex justify-content-between">
        <div class="form-group">
            <button type="submit" class="btn">Log in</button>
        </div>
		<a href="register.php" class="link mt-2 mr-0">registreer hier!</a>
        </div>
       
    </form>
    </div>
    </div>
    </div>
    
</body>
</html>