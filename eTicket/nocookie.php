<?php

require_once 'config.php';
require_once 'php/function/connection.php';
require_once 'php/function/db.php';
require_once 'php/function/session.php';

startSession();

?>

<!DOCTYPE html>

<html>

	<head>
	
		<meta charset="utf-8">
		
		<title>Error</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/function/function.js"></script>
		
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="style/schema.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		
	</head>
	
	<noscript> Javascript is not enabled, site could not work as aspected!</noscript>
	
	<body class="loggedin" onload="init()">
		
		 <nav class="navtop">
		 
			<div>
			
				<h1>Seat resertvation</h1>
				
			</div>
			
		</nav> 	
			
		<div class="content">
		
			<h2>Error - cookie are not enabled</h2>
			
			<div class="matrix_container">
			
			<h3>This website requires cookies to be enabled on your browser in order to work. Please enable them and reload page to continue.</h3>
		
  			</div>
  			
		</div>
			
	</body>

</html>