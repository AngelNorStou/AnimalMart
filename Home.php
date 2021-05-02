<?php


?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<title>Animal Mart</title>

</head>
<body>
<div  style="background-color: lightblue;">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link active" style="color: darkblue;" aria-current="page" href="#">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="contact.php">Contact</a>
	  </li>
	  <li class="nav-item" >
	    <a class="nav-link" style="color: red;" href="login.php" tabindex="-1">Login</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="signup.php" tabindex="-1">Sign Up</a>
	  </li>
	</ul>	
</div>	
<div align="center" class="header">
	<h3 style="background-color: darkblue; color: #fff;padding:5px;">Welcome To AnimalMart !</h3>
</div>
<div align="center">
	<div id="carouselExampleCaptions" class="carousel carousel-dark slide" data-bs-ride="carousel">
	  <div class="carousel-indicators">
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
	  </div>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="./Images/pet_store.jpg" class="d-block w-75" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h5>First slide label</h5>
	        <p>Some representative placeholder content for the first slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="./Images/pet_store1.jpg" class="d-block w-75" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h5>Second slide label</h5>
	        <p>Some representative placeholder content for the second slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="./Images/pet_store2.jpg" class="d-block w-75" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h5>Third slide label</h5>
	        <p>Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	  </div>
	  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Previous</span>
	  </button>
	  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Next</span>
	  </button>
	</div>
	<div align="center" class="header">
	<h4 style="background-color: darkblue; color: #fff;padding:10px;">Reviews from our customers!</h4>
</div>
	<div class="card-group">
		<p style="width: 200px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4" >
	      <img src="..." alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Customer 1</h5>
	        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	        <p class="card-text"><small class="text-muted">Service: </small></p>
	      </div>
	    </div>
	</div>
	</div>
	<p style="width: 10px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4">
	      <img src="..." alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Customer 2</h5>
	        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	        <p class="card-text"><small class="text-muted">Service: </small></p>
	      </div>
	    </div>
	  </div>
	</div>
	<p style="width: 10px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4">
	      <img src="..." alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Customer 3</h5>
	        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	        <p class="card-text"><small class="text-muted">Service: </small></p>
	      </div>
	    </div>
	  </div>
	</div>
	<p style="width: 200px;">
</div>

<footer style="background-color: lightblue;">Address</footer>
</div>
</body>
</html>