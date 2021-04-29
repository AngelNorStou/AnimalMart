<?php

 include 'users.php';
 include 'pets.php';

$userObj = new Users();
$petObj = new Pets();
$user = null;
$pets = null;

if(isset($_GET['login']) && !empty($_GET['login']))
{
	$user = $userObj->displayRecordByUsername($_GET['login']);
	$pets = $petObj->displayPetsByUsername($_GET['login']);
}
else
{
	//header("Location:login.php");
}

if(isset($_POST['uusername'])) 
{
	$userObj->updateUser($_POST);
}  


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
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="accountDetailsTab" data-bs-toggle="pill" data-bs-target="#accountDetails" type="button" role="tab" aria-controls="accountDetails" aria-selected="true">Account</button>
    <button class="nav-link" id="petDetailsTab" data-bs-toggle="pill" data-bs-target="#petDetails" type="button" role="tab" aria-controls="petDetails" aria-selected="false">Your Pets</button>
    <button class="nav-link" id="passwordEditTab" data-bs-toggle="pill" data-bs-target="#passwordEdit" type="button" role="tab" aria-controls="passwordEdit" aria-selected="false">Change Password</button>
  <a class="nav-link"  style="color: black;" aria-selected="false" href="view_appointments.php">View Appointments</a>   
  <a class="nav-link" style="display: none;" aria-selected="false" href="view_appointments.php">View Employees</a> 
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">			
			<form action="user_profile.php" method="POST">
				<div class="row">
				    <div class="col-3">
			      		<img src="Images/guest.jpg" class="img-thumbnail" alt="...">
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
						  <label for="phoneEdit"><?php echo $user['phone_number']; ?></label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				<label class="form-label">Profile Picture</label>
				<input class="form-control form-control-lg" value="<?php echo $user['profile_picture']; ?>" type="file" />
			  </div>
			  <br/>
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
			  		<button style="float: left;margin: 2%;" value="update" type="submit" class="btn btn-primary">Confirm Changes</button>					  	
				  </div>			  		  		  		  		  	
			</form>	
		</div>
    </div>
    <div class="tab-pane fade" id="petDetails" role="tabpanel" aria-labelledby="petDetailsTab">
	<div class = "row">
		<a class="btn btn-primary" href="add_pet.php?user=<?php echo $_GET['login']; ?>">Add Pet</a> 
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
	  <div class="row">
	  	<label class="form-label">Enter your current password and a new password to confirm the changes.</label>
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
		</div>	
    </div>
  </div>
</div>
</body>
</html> 