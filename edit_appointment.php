<?php

include './model/pets.php';
include './model/users.php';
include './controller/controller_appointments.php';
include './controller/controller_services.php';

$petObj = new Pets();
$usersObj = new Users();

if (!isset($_SESSION['username'])) {  
	header("Location: login.php");
}
else{
	//TO BE CHANGED USING CALL METHOD
	$pets = $petObj->displayPetsByUsername($_SESSION['username']);
	$user = $usersObj->displayRecordByUsername($_SESSION['username']);
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

	<title>Edit appointment</title>
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
			<form class="userForms" action="edit_appointment.php" method="POST" style="background-color: lightblue; border-color: lightblue;" >
				<h3 align="center">Edit an appointment</h3>
				<p align="center" style="line-height: 0px;padding-bottom: 10px;">_________________________________________</p>
				<div class="row g-3">
				  <div class="col">
				  	 <label class="form-label">First Name</label>
				    <input type="text" class="form-control" placeholder="First Name" value="<?php echo $user['first_name'] ?>" aria-label="First name">
				  </div>
				  <div class="col">
				  	 <label class="form-label">Last Name</label>
				    <input type="text" class="form-control" placeholder="Last name"  value="<?php echo $user['last_name'] ?>"  aria-label="Last name">
				  </div>
				</div>
				<br>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
						  <input type="email" class="form-control" id="emailEdit"  value="<?php echo $user['email'] ?>"  placeholder="example@web.ca">
						    			    				    				
				</div>
			  </div>
			  <br>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Phone Number</label>
						  <input type="tel" class="form-control" id="phoneEdit"  value="<?php echo $user['phone_number'] ?>"  placeholder="999-999-9999">
							      						    				
				</div>
			  </div>
			  <br>
			 <div class="row g-3">
				  <div class="col">
				  	 <label class="form-label">Pet</label>
				    <select name="pet_id" id="inputState" class="form-select" required="required">
				      <option value="choose" >Choose...</option>
				      <?php foreach($pets as $pet){ 
				      	if($pet['pet_id'] == $appointment['pet_id']){?>
				     	 <option value="<?php echo $pet['pet_id']; ?>" selected><?php echo $pet['pet_name']; ?></option>
				      <?php } else{ ?>
				      	<option value="<?php echo $pet['pet_id']; ?>"><?php echo $pet['pet_name']; ?></option>
				      <?php } } ?>
				    </select>
				  </div>
				  <div class="col">
				  	 <label class="form-label">Service</label>
				   <select name="service_id" id="inputState" class="form-select" required="required">
				      <option value="choose">Choose...</option>
				      <?php foreach($services as $service){
					      if($service['service_id'] == $appointment['service_id']){ ?>
				     	 <option value="<?php echo $service['service_id']; ?>" selected><?php echo $service['service_name']; ?></option>
				      <?php } else { ?>
				      	<option value="<?php echo $service['service_id']; ?>"><?php echo $service['service_name']; ?></option>
				      <?php } } ?>
				    </select>
				  </div>
			 <div class="col">
				    <div class="col-sm">
				    <label class="form-label">Date</label>
					<input type="datetime-local" class="form-control" name="appointment_date" value="<?php echo $appointment['appointment_datetime']; ?>" id="appointment_date" placeholder="">	      		
			    				    				    				
				</div>
			  </div>
			</div>
			  <br>
			  	<button id="editAppointment" value="" name="editAppointment" value="submit" type="submit" class="btn btn-danger">Save Changes</button>
			  	<input type="hidden" class="form-control" value="<?php echo $appointment['appointment_id']; ?>"  name="appointment_id">	
			</form>	
		</div>
    </div>
</div>
</div>
<div><p><br></p></div>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html>