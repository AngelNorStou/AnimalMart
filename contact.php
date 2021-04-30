<?php

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<title>Contact Us</title>
</head>
<body>
<div class="container">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link " href="home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link active"  aria-current="page" href="#">Contact</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link " href="login.php" tabindex="-1">Login</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link " href="signup.php" tabindex="-1">Sign Up</a>
	  </li>
	</ul>	
</div>
<div class="header" align="center">
	<h3>Contact Us</h3>
</div>
	<div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">		
			<form>
				<div class="row g-3">
				  <div class="col">
				  	 <label class="form-label">First Name</label>
				    <input type="text" class="form-control" placeholder="First name" aria-label="First name">
				  </div>
				  <div class="col">
				  	 <label class="form-label">Last Name</label>
				    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
				  </div>
				</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control" id="emailEdit" placeholder="example@web.ca">
						  <label for="emailEdit">example@web.ca</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control" id="phoneEdit" placeholder="999-999-9999">
						  <label for="phoneEdit">999-999-9999</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			   <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Message</label>
					<textarea type="text" class="form-control" id="phoneEdit" placeholder="Your Message"></textarea>	    				    				
				</div>
			  </div>
			  <br>
			  	<button id="updateButton" type="submit" href="" class="btn btn-primary">Send</button>
			</form>	
		</div>
    </div>
</div>
</div>
</body>
</html>