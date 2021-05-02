<?php

include 'users.php';

$userObj = new Users();
/*
if(isset($_POST['firstname'] , $_POST['lastname'], $_POST['username'],
		$_POST['email'] ,$_POST['password'], $_POST['city'],
		$_POST['phone'],$_FILES['profilepic']['name']) )
{
    $userObj->insertUser($_POST,$_FILES);
} 
*/
if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $userObj->insertUser($_POST);
}


?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="CSS/sign_in_out.css" rel="stylesheet">	

	<title>Join AnimalMart!</title>	
</head>
<body>
<div style="background-color: lightblue;">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="contact.php">Contact</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="login.php" tabindex="-1">Login</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link active" style="color: darkblue;" aria-current="page" href="#" tabindex="-1">Sign Up</a>
	  </li>
	</ul>	
</div>
<div class="container">		
	<form class="userForms" action="signup.php" method="POST" enctype="multipart/form-data">
	<h5 class="text-center">Create an Account</h5>	
	<div class="row">	
	  <div class="mb-3 col">
	    <label for="firstname" class="form-label">First Name</label>
	    <input type="text" class="form-control" name="firstname" >
	  </div>
	  <div class="mb-3 col">
	    <label for="lastname" class="form-label">Last Name</label>
	    <input type="text" class="form-control" name="lastname" >
	  </div>	  
	</div>

	  <div class="mb-3">
	    <label for="username" class="form-label">Username</label>
	    <input type="text" class="form-control" name="username" >
	  </div>	

	  <div class="mb-3">
	    <label for="email" class="form-label">Email address</label>
	    <input type="email" class="form-control" name="email">
	    <div  class="form-text">We'll never share your email with anyone else.</div>
	  </div>

	  <div class="mb-3">
	    <label for="password" class="form-label">Password</label>
	    <input type="password" class="form-control" name="password">
	  </div>

	  <div class="mb-3">
	    <label for="city" class="form-label">City</label>
	    <input type="text" class="form-control" name="city">
	  </div>

	  <div class="mb-3">
	    <label for="phone" class="form-label">Phone Number</label>
	    <input type="tel" class="form-control" name="phone">
	  </div>

	  <div class="mb-3">
		<label for="profilepic" class="form-label">Profile Picture</label>
		<input class="form-control form-control-lg" name="profilepic" type="file" />
	  </div>		  		  		  

	  <div class="d-grid gap-2">
	  	<button value="signUp" type="submit" class="btn btn-primary">Join us!</button>
	  </div>
	  <br>
	  <p>Already have an account? <a href="signup.php" style="text-decoration: none;"><span style="color: red;">Sign In!</span></a></p>
	</form>	
</div>
</body>
</html> 
