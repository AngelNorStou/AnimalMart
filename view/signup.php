<?php

include '../controller/controller_user.php';
include '../model/users.php';

$controller_user = new ControllerUser(new Users());

$controller_user->verify_insert($_POST);




?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="../CSS/sign_in_out.css" rel="stylesheet">	

	<title>Join AnimalMart!</title>	
</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="services.php?page=1">Services Offered</a>
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
		    <a class="nav-link" style="color: red;" href="login.php" tabindex="-1">Login</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" style="color: white;" aria-current="page" href="" tabindex="-1">Sign Up</a>
		  </li>	
        </ul>
    </div>
</nav>
<div class="container">		
	<form class="userForms" action="signup.php" method="POST" enctype="multipart/form-data" style="background-color: lightblue; border-color: lightblue;">
	<h5 class="text-center">Create an Account</h5>	
	<div class="row">	
	  <div class="mb-3 col">
	    <label for="firstname" class="form-label">First Name</label>
	    <input type="text" class="form-control" name="firstname" maxlength='30'  required="">
	  </div>
	  <div class="mb-3 col">
	    <label for="lastname" class="form-label">Last Name</label>
	    <input type="text" class="form-control" name="lastname" maxlength='100'  required="">
	  </div>	  
	</div>

	  <div class="mb-3">
	    <label for="username" class="form-label">Username</label>
	    <input type="text" class="form-control" name="username" maxlength='32'  required="">
	    <div  class="form-text">Choose Wisely, it cannot be changed.</div>
	  </div>	

	  <div class="mb-3">
	    <label for="email" class="form-label">Email address</label>
	    <input type="email" class="form-control" name="email" maxlength='128'  required="">
	    <div  class="form-text">We'll never share your email with anyone else.</div>
	  </div>

	  <div class="mb-3">
	    <label for="password" class="form-label">Password</label>
	    <input type="password" class="form-control" name="password" maxlength='64' required="">
	  </div>

	  <div class="mb-3">
	    <label for="city" class="form-label">City</label>
	    <input type="text" class="form-control" name="city" maxlength='85' required="">
	  </div>

	  <div class="mb-3">
	    <label for="phone" class="form-label">Phone Number</label>
	    <input type="tel" class="form-control" name="phone" maxlength='14'>
	  </div>

	  <div class="mb-3">
		<label for="profilepic" class="form-label">Profile Picture</label>
		<input class="form-control form-control-lg" name="profilepic" type="file" />
	  </div>		  		  		  

	  <div class="d-grid gap-2">
	  	<button value="signUp" type="submit" class="btn btn-primary">Join us!</button>
	  </div>
	  <br>
	  <p>Already have an account? <a href="login.php" style="text-decoration: none;"><span style="color: red;">Sign In!</span></a></p>
	</form>	
</div>
<div><p><br></p></div>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html> 
