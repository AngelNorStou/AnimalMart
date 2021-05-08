<?php
include 'model_services.php';
include './controller/controller_user.php';
include './controller/controller_pet.php';
include './controller/controller_appointments.php';

$userObj = new Users();
$petObj = new Pets();
$serviceObj = new Service();
$user = null;
$pets = null;
$user_name = null;

session_start();
if (!isset($_SESSION['username'])) {  

	if(isset($_GET['login']) && !empty($_GET['login']))
	{
		$user_name = $_GET['login'];
		$user = $userObj->displayRecordByUsername($_GET['login']);
		$pets = $petObj->displayPetsByUsername($_GET['login']);

		$_SESSION['username'] = $user['username'];
		$_SESSION['isAdmin'] = 0;

	}
	else
	{
		header("Location:login.php");
	}
}
else{
	$user = $userObj->displayRecordByUsername($_SESSION['username']);
	$pets = $petObj->displayPetsByUsername($_SESSION['username']);
}

if(isset($_POST['uusername'],$_POST['upassword'])) 
{
	$userObj->updateUser($_POST);
	
} 


if(isset($_POST['new_password'],$_POST['current_password'],$_POST['current_user'] )) 
{
	$userObj->changePassword($_POST);
	
} 

$appointments = $app->getAppointmentsByUsername($_SESSION['username']);

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
	    <a class="nav-link active" style="color: white;" href="user_profile.php" aria-current="page" tabindex="-1"><?php echo $_SESSION['username']?></a>
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
    <button class="nav-link" id="passwordEditTab" data-bs-toggle="pill" data-bs-target="#passwordEdit" type="button" role="tab" aria-controls="passwordEdit" aria-selected="false">Change Password</button>
  <a class="nav-link"  style="color: black;" aria-selected="false" href="change_picture.php?profile=<?php echo $user['username']; ?>" >Change Profile Picture</a> 
  <button class="nav-link" id="viewAppointmentsTab" data-bs-toggle="pill" data-bs-target="#viewAppointments" type="button" role="tab" aria-controls="viewAppointments" aria-selected="false">View Appointments</button> 
  <a class="nav-link" style="display: none;" aria-selected="false" href="view_appointments.php">View Employees</a> 
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">			
			<form id="userProfile"  action="user_profile.php" method="POST" >
				<div class="row">
				    <div class="col-3">
			      		<img src="<?php echo $user['profile_picture']; ?>" class="img-thumbnail" alt="No Picture Found.">
			    	</div>	
				    <div class="col-sm">
					    <label class="form-label">First Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ufirstname">
						  <label for="firstNameEdit"><?php echo $user['first_name']; ?></label>
						</div>	
				    <div class="">
				    <label class="form-label">Last Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ulastname" >
						  <label for="lastNameEdit"><?php echo $user['last_name']; ?></label>		      		
			    	</div>											    		      		
			    	</div>			    				    				
				</div>
			</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control"  name="uemail">
						  <label for="emailEdit"><?php echo $user['email']; ?></label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">City</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"   name="ucity">
						  <label for="cityEdit"><?php echo $user['city']; ?></label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
			  	<div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control"  name="uphone">
					  <label for="phoneEdit"><?php echo $user['phone_number']; ?></label>	 </div>     		
			    	</div>				    				    				
			  </div>
			  <div class="row">
			  	<label class="form-label">Enter your current username and password to confirm the changes.</label>
				    <div class="col-sm">
				    <label class="form-label">Username</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" name="uusername">
						  <label for="usernameEdit"><?php echo $user['username']; ?></label>		      		
			    		</div>	
			    	</div>			    				    				
				</div>
				<div class="col-sm">
				    <label class="form-label">Password</label>
					    <div class="form-floating">
						  <input type="password" class="form-control"  name="upassword">
						  <label for="passwordEdit"></label>		      		
			    		</div>		    									  				  	
			  </div>
				  <div class="row">
			  		<button style="float: left;margin: 2%;" name="update"  value="update" type="submit" class="btn btn-primary updatePicture">Confirm Changes</button>					  	
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

		if ($pets != null)
		{
		  foreach ($pets as $pet) 
		  {

		?>      	
	    <div class="card col" style="width: 18rem;margin: 2%;">	
		  <div class="card-body">	  	
			  <div class="row" style="margin-bottom: 3%;">
				<label  class="form-label card-text"><?php echo "Name: ".$pet['pet_name']; ?></label>
				<label  class="form-label card-text"><?php echo "Type: ".$pet['pet_type']; ?></label>
				<label  class="form-label card-text"><?php echo "Breed: ".$pet['breed']; ?></label>
				<label  class="form-label card-text"><?php echo "Gender: ".$pet['gender']; ?></label>
				<label  class="form-label card-text"><?php echo "Size: ".$pet['size']." cm"; ?></label>
				<label  class="form-label card-text"><?php echo "Weight: ".$pet['weight']." kg"; ?></label>
				<label  class="form-label card-text"><?php echo "Age: ".$pet['age'] ." years old"; ?></label>						
			  </div>  	
				<a class="btn btn-primary" href="edit_pet.php?petEdit=<?php echo $pet['pet_id']; ?>">Edit</a> 
		  </div>    
		</div>	
	      <?php } } ?>	
	  </div>    				
    </div>
    <div class="tab-pane fade" id="passwordEdit" role="tabpanel" aria-labelledby="passwordEditTab">
		 <form id="changePass"  action="user_profile.php" method="POST">
		 	  <div class="row">
			  	<label class="form-label">Enter your current password and username to add a new password.</label>
				    <div class="row">
				    	<div class="col-sm">
				    	<label class="form-label">Current Username</label>
						    <div class="form-floating">
							  <input type="text" class="form-control" name="current_user">
							  <label for="current_username"><?php echo $user['username']; ?></label>		      		
				    		</div>
			    		</div>	
			    	</div>			  	
				    <div class="row">
					    <label class="form-label">Current Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="current_password">
							  <label for="current_password"></label>		      		
				    		</div>		      		
			    	</div>
			    	<br/>
				    <div class="row">
					    <label class="form-label">New Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="new_password">
							  <label for="new_password"></label>		      		
				    		</div>		      		
			    		</div>
				    <div class="row">
			      		<button style="float: left;margin-top: 2%;" value="changePassword" type="submit" class="btn btn-primary">Confirm Changes</button>		
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
		    <tr>
		      <td scope="row"><?php echo $appt['appointment_datetime']; ?></td>
		      <td><?php $pet = $petObj->displayPetById($appt['pet_id']); echo $pet['pet_name']; ?></td>
		      <td><?php $service = $serviceObj->displayServiceById($appt['service_id']); echo $service['service_name']; ?></td>
		      <td><a href="edit_appointment.php?appt_id=<?php echo $appt['appointment_id']; ?>" style="color:green">Edit</a></td>
		      <td><a href="delete_appointment.php?appt_id=<?php echo $appt['appointment_id']; ?>" style="color:red">Cancel</a></td>
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