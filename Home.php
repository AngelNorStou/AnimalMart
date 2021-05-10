
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
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link active" style="color: white;" aria-current="page" href="#">Home</a>
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
             <?php
		if (!isset($_SESSION['username'])) {  
			
		?>
		  <li class="nav-item" >
		    <a class="nav-link" style="color: red;" href="login.php" tabindex="-1">Login</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" style="color: red;" href="signup.php" tabindex="-1">Sign Up</a>
		  </li>
		<?php } else{?>
	  <li class="nav-item" >
	  	 <?php
		if ($_SESSION['isAdmin'] == 1) {  
			
		?>
	    <a class="nav-link" style="color: white;" href="admin_profile.php" tabindex="-1"><?php echo $_SESSION['username']?></a>
	    <?php } else{?>
	    	 <a class="nav-link" style="color: white;" href="user_profile.php" tabindex="-1"><?php echo $_SESSION['username']?></a>
	    <?php } ?>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php" tabindex="-1">Logout</a>
	  </li>
	<?php }?>
	
        </ul>
    </div>
</nav>
<div style="background-color: lightblue;">
	<table align="center">
		<tr>
			<td align="center" width="600" style="background-color: lightblue; padding-left: 30px;">
				<table align="center">
					<th style="font-size: 30px;color: darkblue;">TRAINING!</th>
					<tr>
						<td style="font-size: 20px;color:red;font-weight: bold;"><br>Explore our new group training sessions offered!</td>
					</tr>
					<tr>
						<td style="font-size: 20px;color: darkblue;font-weight: normal;">
							<br>Sign up or Login now &amp;<br> Book your appointment!
						</td>
					</tr>
				</table>
			</td>
			<td align="center" style="font-size: 30px;color:red;font-weight: normal;">
				Take care of your pet's needs, all in one place.
				<img width="750" height="400" src="./Images/pet_store1.jpg" alt="Animal">
			</td>
			<td  width="550" style="background-color: lightblue; padding-right: 5px;padding-left: 15px;">
					<table align="center">
					<th style="font-size: 30px;color: darkblue;">GROOMING!</th>
					<tr>
						<td style="font-size: 20px;color:red;font-weight: bold;"><br> Explore all our grooming services for every pet!<td>
					</tr>
					<tr>
						<td style="font-size: 20px;color: darkblue;font-weight: normal;">
							<br>Sign up or Login now &amp;<br> Book your appointment!
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<div style="background-color: red;"  align="center">
	<h4 style="background-color: darkblue; color: #fff;padding:10px;">Reviews from our customers!</h4>
	<div class="card-group">
		<p style="width: 150px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4" >
	      <img src="./Images/dog.jpg" width="120" height="100" style="padding-top: 2px;" alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Mary Owen</h5>
	        <p class="card-text">Great local shop! The staff is always happy to help and are all knowledgable when it comes to pet care. My dog loves going to AnimalMart!</p>
	        <p class="card-text"><small class="text-muted">Service: Grooming</small></p>
	      </div>
	    </div>
	</div>
	</div>
	<p style="width: 10px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4">
	      <img src="./Images/bunny.jpg" width="120" height="100" style="padding-top: 2px;"  alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Maxim Party</h5>
	        <p class="card-text">Fantastic team, fantastic service. My bunny was dealing with a digestive issue and employee team gave me great advices. Purchase all your pets needs here!</p>
	        <p class="card-text"><small class="text-muted">Service: Vet </small></p>
	      </div>
	    </div>
	  </div>
	</div>
	<p style="width: 10px;">
	<div class="card mb-3">
	  <div class="row g-0">
	    <div class="col-md-4">
	      <img src="https://lh5.googleusercontent.com/p/AF1QipOSd-S225TZD4cM3CYqb4GC0k67udzJ_vBU5-RT=w100-h100-p-n-k-no" alt="...">
	    </div>
	    <div class="col-md-8">
	      <div class="card-body">
	        <h5 class="card-title">Becca Maurice</h5>
	        <p class="card-text">Banjo has been doing amazing! Banjo has quite a few health issues so I am always grateful for the advice they give me. Customer service is always top notch.</p>
	        <p class="card-text"><small class="text-muted">Service: Vet</small></p>
	      </div>
	    </div>
	  </div>
	</div>
	<p style="width: 150px;"></p>
</div>

<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</div>
</body>
</html>