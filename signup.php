<?php



?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="account.css" rel="stylesheet" >	

	<title>Login to AnimalMart!</title>	
</head>
<body>
<div class="container">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link active" aria-current="page" href="#">Active</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="#">Link</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="#">Link</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
	  </li>
	</ul>	
</div>	
<div class="container">		
	<form class="userForms">
	<h5 class="text-center">Create an Account</h5>	
	<div class="row">	
	  <div class="mb-3 col">
	    <label class="form-label">First Name</label>
	    <input type="text" class="form-control" id="firstNameSignUp">
	  </div>
	  <div class="mb-3 col">
	    <label class="form-label">Last Name</label>
	    <input type="text" class="form-control" id="lastNameSignUp">
	  </div>	  
	</div>

	  <div class="mb-3">
	    <label class="form-label">Username</label>
	    <input type="text" class="form-control" id="usernameSignUp">
	  </div>	

	  <div class="mb-3">
	    <label class="form-label">Email address</label>
	    <input type="email" class="form-control" id="emailSignUp">
	    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
	  </div>

	  <div class="mb-3">
	    <label class="form-label">Password</label>
	    <input type="password" class="form-control" id="passwordSignUp">
	  </div>

	  <div class="mb-3">
	    <label class="form-label">City</label>
	    <input type="text" class="form-control" id="citySignUp">
	  </div>

	  <div class="mb-3">
	    <label class="form-label">Phone Number</label>
	    <input type="tel" class="form-control" id="phoneSignUp">
	  </div>

	  <div class="mb-3">
		<label  class="form-label">Profile Picture</label>
		<input class="form-control form-control-lg" id="picSignUp" type="file" />
	  </div>		  		  		  

	  <div class="d-grid gap-2">
	  	<button id="signUpButton" type="submit" class="btn btn-primary">Join us!</button>
	  </div>
	</form>	
</div>
</body>
</html> 
