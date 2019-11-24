<nav class="navtop">
		 
			<div>
			
				<h1>Seat resertvation</h1>
				
	 
				<?php if(!isset($_SESSION['loggedin'])):?>
				
					<a href="index.php"><i class="fas fa-home"></i>Home</a>
					
    				<a href="login.php"><i class="fas fa-sign-in-alt"></i>Login</a> 
    					
				<?php endif; ?>
				
				<?php if(isset($_SESSION['loggedin'])):?>
				
    				<a class="pull-right" href="logout.php" ><i class="fas fa-sign-out-alt"></i>Logout</a> 
    					
				<?php endif; ?>
				
			</div>
</nav> 	