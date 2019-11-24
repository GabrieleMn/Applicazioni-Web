<?php

require_once 'config.php';
require_once 'php/function/connection.php';
require_once 'php/function/db.php';
require_once 'php/function/session.php';

startSession();

if (isset($_SESSION['loggedin'])) {
    
    if (isLogged() == false) {

        header('Location: logout.php');
    }
}

?>

<!DOCTYPE html>

<html>

	<head>
	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Home Page</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/function/function.js"></script>
		
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style/home.css" rel="stylesheet" type="text/css">
		<link href="style/schema.css" rel="stylesheet" type="text/css">
	
		
	</head>
	
	<noscript> Javascript is not enabled, site could not work as aspected!</noscript>
	
	<body class="loggedin" onload="init()">
		
		<?php require_once 'php/visual/navbar.php';?>
			
		<div class="content">
		
			<h2>Home Page</h2>
			
			<p>Welcome  <?php if(isset($_SESSION['name'])){
			                 $secure_name=sanitize($_SESSION['name']);
			                 echo "<strong>".$secure_name."</strong>"." ";
			             }
			                  else
			                     echo "<strong>visitor</strong>, please login to book your seats";
			             ?>!
			</p>
			
			<div class="matrix_container">
			
			
			<?php require_once 'php/visual/sidebar.php';?>
			
   			<?php get_map(); ?>
   				
			</div>
			
		</div>	
		
		<footer> Created by Gabriele Minì, s257117</footer>
	</body>

</html>