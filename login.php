<?php


include './controller/controller_user.php';
//include 'users.php';

$controller_user = new ControllerUser();


?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="CSS/sign_in_out.css" rel="stylesheet" >	

	<title>Login to AnimalMart!</title>	
</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="contact.php">Contact</a>
	  </li>
	</ul>
    </div>
    <div class="mx-auto order-0">
        <a style="font-size: 30px;" class="navbar-brand mx-auto" color="#fff">Welcome To AnimalMart!</a>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ms-auto">
		  <li class="nav-item" >
		    <a class="nav-link active" style="color: white;" aria-current="page" href="" tabindex="-1">Login</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" style="color: red;" href="signup.php" tabindex="-1">Sign Up</a>
		  </li>	
        </ul>
    </div>
</nav>
<div class="container">	
	<form class="userForms" action="login.php" method="POST">
	<h5 class="text-center">Welcome Back!</h5>	
	  <div class="mb-3">
	    <label for="login_username" class="form-label">Username</label>
	    <input type="text" class="form-control" name="login_username" required>
	  </div>		
	  <div class="mb-3">
	    <label for="login_email" class="form-label">Email address</label>
	    <input type="email" class="form-control" name="login_email" required>
	    <div  class="form-text">We'll never share your email with anyone else.</div>
	  </div>
	  <div class="mb-3">
	    <label for="login_password" class="form-label">Password</label>
	    <input type="password" class="form-control" name="login_password" required>
	  </div>		
	  <div class="d-grid gap-2">
			<button value="login"  type="submit" class="btn btn-primary">Login</button>
	  </div>
	<div class="mb-3">	
		<?php
		 	echo $controller_user->verify_login($_POST);
		?>
	</div>  
	  <br>
	  <p>Don't have an account? <a href="signup.php" style="text-decoration: none;"><span style="color: red;">Register Now!</span></a></p>
	</form>	
</div>
<div><p><br></p></div>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html> 
