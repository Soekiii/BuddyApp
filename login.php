<?php
include_once (__DIR__ . "/classes/User.php");

    // Wanneer er op het formulier word gedrukt voort men deze if uit
    if (!empty($_POST)) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $user = new User();

        if ($user->canILogin($email, $password)) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['loggedin'] = true;
            
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
    <title>Login</title>
</head>
<body>
<form action="" method="post" >
    <h2>Login Amigos</h2>	
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="error"><p><?php echo $error?></p></div>
    <?php endif; ?>
	 <div class="container">
			<div class="container1">
                <label for="email">Email</label>
				<input type="text" id="Email" name="email">
			</div>
			<div class="container2">
				<label for="Password">Password</label>
				<input type="password" id="Password" name="password">
			</div>
			<div class="container3">
				<input type="submit" value="Sign in" class="btn">	
			</div>
		<p>geen account? </p><a href="register.php" class="link">registreer hier!</a>
		</div>
	</form>
</body>
</html>