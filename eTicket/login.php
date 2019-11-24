<?php 

require_once 'php/function/connection.php';


?>

<!DOCTYPE html>

<html>

	<head>
	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Profile Page</title>
		
		<link href="style/schema.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="style/login.css" type="text/css"> 
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/function/function.js"></script>
		
		
		
	</head>
	
	<noscript> Javascript is not enabled, site could not work as aspected!</noscript>
	
	<body class="loggedin" onload="init()" >
	
	<?php require_once 'php/visual/navbar.php';?>
		
		<div class="login">
		
			<h1>Login</h1>
			
			<form id="loginForm" method="post" action="authentication.php" onsubmit="return checkForm();" >
				
				<label for="username"><i class="fas fa-user"></i> </label>
				
				<input type="text" name="username" placeholder="Username" id="username" required >
				
				<label for="password"><i class="fas fa-lock"></i></label>
				
				<input type="password" name="password" placeholder="Password" id="password" required>
				
				<input type="submit" name="type" value="Login">
				
				<input id="register" type="submit" name="type" value="Register">
				
			</form>
			
		</div>
	
	</body>
	
</html>