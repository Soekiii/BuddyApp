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
    <title>Login | Amigos</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <h2>Login Amigos</h2>	
    <!-- error message weergeven -->
    <?php if(isset($error)): ?>
        <div class="error"><p><?php echo $error?></p></div>
        <div class="emailError"><p><?php echo $emailError?></p></div>
    <?php endif; ?>
	 <div class="container">
			<div class="container1">
                <label for="email">Email</label>
                <input type="text" id="Email" name="email">
                <!-- error message weergeven -->
                <div class="error">
                <?php echo $errors['email'] ?? '' ?>
                </div>
			</div>
			<div class="container2">
				<label for="Password">Password</label>
                <input type="password" id="Password" name="password">
                <!-- error message weergeven -->
                <div class="error">
                <?php echo $errors['password'] ?? '' ?>
                </div>
			</div>
			<div class="container3">
				<input type="submit" value="Sign in" class="btn">	
			</div>
		<p>geen account? </p><a href="register.php" class="link">registreer hier!</a>
		</div>
	</form>
</body>
</html>