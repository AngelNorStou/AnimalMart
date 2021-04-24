<?php


if(isset($_POST['login']))
{
    // Verify data
}


?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="sign_in_out.css" rel="stylesheet" >	

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
	<h5 class="text-center">Welcome Back!</h5>		
	  <div class="mb-3">
	    <label for="vemail" class="form-label">Email address</label>
	    <input type="email" class="form-control" name="vemail">
	    <div  class="form-text">We'll never share your email with anyone else.</div>
	  </div>

	  <div class="mb-3">
	    <label for="vpassword" class="form-label">Password</label>
	    <input type="password" class="form-control" name="vpassword">
	  </div>

	  <div class="d-grid gap-2">
	  	<button value="login" type="submit" class="btn btn-primary">Login</button>
	  </div>
	</form>	
</div>
</body>
</html> 
