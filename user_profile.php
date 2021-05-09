<?php
include './model/model_services.php';

include './controller/controller_user.php';
include './model/users.php';
include './view/view_user.php';


include './view/view_pet.php';
include './model/pets.php';

include './controller/controller_appointments.php';

// MVC in OOP for Users
$userObj = new Users();
$controller_user = new ControllerUser($userObj);
$userView = new ViewUser($userObj);

// MVC in OOP for Pets
$petObj = new Pets();
$petView = new ViewPet($petObj);

$serviceObj = new Service();


if (!isset($_SESSION['username'])) // If it is empty
{  

	if(isset($_GET['login']) && !empty($_GET['login']))
	{

		$_SESSION['username'] = $_GET['login'];
		$_SESSION['isAdmin'] = 0;

	}
	else
	{
		header("Location:login.php");
	}
}


$updateError = $controller_user->verify_update($_POST);
$passwordError = $controller_user->verify_passwordChange($_POST);

$app = new ControllerAppointment();
$appointments = $app->getAppointments($_SESSION['username']);

?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="CSS/account.css" rel="stylesheet" >		

	<title>View Account</title>	
</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;"  href="services.php">Services Offered</a>
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
	    <a class="nav-link active" style="color: white;" href="user_profile.php?login=<?php echo $_SESSION['username']?>" aria-current="page" tabindex="-1"><?php echo $_SESSION['username']?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php" tabindex="-1">Logout</a>
	  </li>
	
        </ul>
    </div>
</nav>
<div class="container" style="padding-top: 16px;">		
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="accountDetailsTab" data-bs-toggle="pill" data-bs-target="#accountDetails" type="button" role="tab" aria-controls="accountDetails" aria-selected="true">Account</button>
    <button class="nav-link" id="petDetailsTab" data-bs-toggle="pill" data-bs-target="#petDetails" type="button" role="tab" aria-controls="petDetails" aria-selected="false">Your Pets</button>
    <button class="nav-link" id="viewAppointmentsTab" data-bs-toggle="pill" data-bs-target="#viewAppointments" type="button" role="tab" aria-controls="viewAppointments" aria-selected="false">View Appointments</button> 
    <button class="nav-link" id="passwordEditTab" data-bs-toggle="pill" data-bs-target="#passwordEdit" type="button" role="tab" aria-controls="passwordEdit" aria-selected="false">Change Password</button>
  <a class="nav-link"  style="color: black;" aria-selected="false" href="change_picture.php?profile=<?php echo $_SESSION['username']; ?>" >Change Profile Picture</a> 
  
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">		
		<h3 align="center" style="color: darkblue;">Actions</h3>
			<table align="center">
				<tbody>
					<tr>
						<td>
							<button class="btn btn-outline-info" onclick="window.location.href='services.php'" >View Services</button>		
						</td>
						<td>
							<button class="btn btn-outline-danger" onclick="window.location.href='appointment.php'" >Book appointment</button>		
						</td>
						<td>
							<button class="btn btn-outline-info" onclick="window.location.href='contact.php'">Contact Us</button>		
						</td>
					</tr>
				</tbody>
			</table>
			<div>
				<br><br>
			</div>	
			<form id="userProfile"  action="user_profile.php?login=<?php echo $_SESSION['username']?>" method="POST" >
				<div class="row">
				    <div class="col-3">
			      		<?php echo $userView->displayPictureSource($_SESSION['username']); ?>
			    	</div>	
				    <div class="col-sm">
					    <label class="form-label">First Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ufirstname" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'first_name'); ?>
						</div>	
				    <div class="">
				    <label class="form-label">Last Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ulastname" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'last_name'); ?>      		
			    	</div>											    		      		
			    	</div>			    				    				
				</div>
			</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control"  name="uemail" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'email'); ?>         		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">City</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"   name="ucity" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'city'); ?>        		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
			  	<div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control"  name="uphone">
					  	  <?php echo $userView->displayItem($_SESSION['username'],'phone_number'); ?>   	 
						</div>     		
			    	</div>				    				    				
			  </div>
			  <div class="row">
			  	<label class="form-label">Enter your current username and password to confirm the changes.</label>
				    <div class="col-sm">
				    <label class="form-label">Username</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" name="uusername" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'username'); ?>   	      		
			    		</div>	
			    	</div>			    				    				
				</div>
				<div class="col-sm">
				    <label class="form-label">Password</label>
					    <div class="form-floating">
						  <input type="password" class="form-control"  name="upassword" required>
						  <label></label>		      		
			    		</div>		    									  				  	
			  </div>
				  <div class="row">
			  		<button style="float: left;margin: 2%;" name="update"  value="update" type="submit" class="btn btn-primary updatePicture">Confirm Changes</button>	
					<?php
					 								
						echo $updateError;
					?>			  						  	
				  </div>			  		  		  		  		  	
			</form>	
		</div>
    </div>
    <div class="tab-pane fade" id="petDetails" role="tabpanel" aria-labelledby="petDetailsTab">
	<div class = "row">
		<a class="btn btn-primary" href="add_pet.php?user=<?php echo $_SESSION['username']; ?>">Add Pet</a> 
	</div>    	
	 <div class="row row-cols-3">   	
		<?php 

		echo $petView->displayPets($_SESSION['username']);

		?>	
	  </div>    				
    </div>
    <div class="tab-pane fade" id="passwordEdit" role="tabpanel" aria-labelledby="passwordEditTab">
		 <form id="changePass"  action="user_profile.php?login=<?php echo $_SESSION['username']?>" method="POST">
		 	  <div class="row">
			  	<label class="form-label">Enter your current password and username to add a new password.</label>
				    <div class="row">
				    	<div class="col-sm">
				    	<label class="form-label">Current Username</label>
						    <div class="form-floating">
							  <input type="text" class="form-control" name="current_user" required>
							  <?php echo $userView->displayItem($_SESSION['username'],'username'); ?> 		      		
				    		</div>
			    		</div>	
			    	</div>			  	
				    <div class="row">
					    <label class="form-label">Current Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="current_password" required>
							  <label for="current_password"></label>		      		
				    		</div>		      		
			    	</div>
			    	<br/>
				    <div class="row">
					    <label class="form-label">New Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="new_password" required>
							  <label for="new_password"></label>		      		
				    		</div>		      		
			    		</div>
				    <div class="row">
			      		<button style="float: left;margin-top: 2%;margin-bottom: 2%" value="changePassword" type="submit" class="btn btn-primary">Confirm Changes</button>

					<?php
					 	echo $passwordError;
					?>				      				
			    	</div>	 	    			    			
			    </div>	
		 </form>   				    				    				
		</div>	
		 <div class="tab-pane fade" id="viewAppointments" role="tabpanel" aria-labelledby="viewAppointmentsTab">  	
		 <table class="table table-borderless table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Appointment Date</th>
		      <th scope="col">Pet</th>
		      <th scope="col">Service</th>
		      <th scope="col">Actions</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach((array)$appointments as $appt) {
		  		
		  	 ?> 
		    <tr style="<?php if(date("Y-m-d H:i") >= $appt['appointment_datetime']){?>color: red;<?php }?>" >
		      <td scope="row"><?php echo $appt['appointment_datetime']; ?></td>
		      <td><?php $pet = $petObj->displayPetById($appt['pet_id']); echo $pet['pet_name']; ?></td>
		      <td><?php $service = $serviceObj->displayServiceById($appt['service_id']); echo $service['service_name']; ?></td>
		      <?php if(date("Y-m-d H:i") < $appt['appointment_datetime']){?>
		      <td><a href="edit_appointment.php?appt_id=<?php echo $appt['appointment_id']; ?>" style="color:green">Edit</a></td>
		       <?php }?>
		      <td><a href="delete_appointment.php?appt_id=<?php echo $appt['appointment_id']; ?>" onclick="confirm('Are you sure want to cancel this appointment ?')" style="color:red">
		      		 <?php if(date("Y-m-d H:i") < $appt['appointment_datetime']){?> Cancel <?php } else { ?> Delete <?php } ?>
		      	</a>
		      </td>
		    </tr>
		<?php } ?>
		  </tbody>
		</table>  				
    </div>		    				    				
	</div>		
    </div>
  </div>
</div>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html> 