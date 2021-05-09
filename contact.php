<?php
include './controller/controller_message.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="CSS/sign_in_out.css" rel="stylesheet">	

	<title>Contact Us</title>
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
	    <a class="nav-link active" style="color: white;" aria-current="page" href="">Contact</a>
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
<div class="header">
	<div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" role="tabpanel">
		<div class="container">		
			<form class="userForms" action="contact.php" method="POST" style="background-color: lightblue; border-color: lightblue;" >
				<h3 align="center">Contact Us</h3>
				<p align="center" style="line-height: 0px;padding-bottom: 10px;">__________________________</p>
				<div class="row g-3">
				  <div class="col">
				  	 <label class="form-label">First Name</label>
				    <input type="text" class="form-control" placeholder="First name" name="firstname" aria-label="First name" required>
				  </div>
				  <div class="col">
				  	 <label class="form-label">Last Name</label>
				    <input type="text" class="form-control" placeholder="Last name" name="lastname" aria-label="Last name" required>
				  </div>
				</div>
				<br>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control" id="email" name="email" placeholder="example@web.ca" required>
						  <label for="email">example@web.ca</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <br>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" id="phone" name="phone" placeholder="999-999-9999" required>
						  <label for="phone">999-999-9999</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <br>
			   <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Message</label>
					<textarea type="text" class="form-control" id="message" name="message" placeholder="Your Message" required></textarea>	    				    				
				</div>
			  </div>
			  <br>
			  	<button id="submit" name="submit" value="submit" type="submit" class="btn btn-danger">Send Message</button>
			  	<input type="hidden" class="form-control" value="<?php echo date("Y-m-d H:i"); ?>"  name="timestamp">
			</form>	
		</div>
    </div>
</div>
</div>
<div>
	<br><br>
</div>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html>