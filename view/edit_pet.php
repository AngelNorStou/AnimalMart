<?php

include '../controller/controller_pet.php';
include '../model/pets.php';
include '../view/view_pet.php';

$petObj = new Pets();
$controller_pet = new ControllerPet($petObj);
$petView = new ViewPet($petObj);
$id = null;

session_start();


if( isset($_GET['petEdit']) or isset($_SESSION['username']) ) 
{
	$id = $_GET['petEdit'];
	
} 
else
{
	header("Location:login.php");
}


$editError = $controller_pet->verify_editPet($_POST);



?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="../CSS/account.css" rel="stylesheet" >
	<link href="../CSS/sign_in_out.css" rel="stylesheet">	

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
	    <a class="nav-link" style="color: lightblue;"  href="services.php?page=1">Services Offered</a>
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
<div class="container">
	<form class="userForms" action="edit_pet.php?petEdit=<?php echo $id; ?>" method="POST" style="background-color: lightblue; border-color: lightblue;">
		<div class="row">
		<h3 align="center">Edit your pet !</h3>
	</div>	
	    <div class="row">
		    <label class="form-label">Pet Name</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'pet_name'); ?>"  
			name="edit_pet_name"  required="" maxlength='30'>	
		</div><br>
	    <div class="row">
	    	<label class="form-label">Pet Type</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'pet_type'); ?>" 
			name="edit_pet_type" required="" maxlength='30'>
		</div>	<br>		    				    				
	  <div class="row">
		    <label class="form-label">Breed</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'breed'); ?>" 
			name="edit_pet_breed" required="" maxlength='64'>	    				
		</div><br>
	  <div class="row">
	  		<label class="form-label">Gender</label>	  	
			<select class="form-select" name="edit_pet_gender" aria-label="edit_pet_gender">
			<?php 
 				echo $petView->displayGender($id); 
			?>			  			  
			</select>     	
	    </div>	<br>			    				    				
	  <div class="row">
		    <label class="form-label">Size (cm)</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'size'); ?>" 
			name="edit_pet_size" required="">      					    				    		
		</div><br>
	  <div class="row">
		    <label class="form-label">Weight (kg)</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'weight'); ?>"  
			name="edit_pet_weight" required="">				    				  		
	  </div><br>
	  <div class="row">
		    <label class="form-label">Age</label>
			<input type="text" class="form-control" 
			value="<?php echo $petView->displayItem($id,'age'); ?>"  
			name="edit_pet_age"  required="">	      						    				
		</div>	<br>  	  
	  <div class="row">	 	    	   	
  		<button style="float: left;margin-top: 2%;" value="update_pet" type="submit" class="btn btn-primary">Confirm Changes</button>
  		<?php echo $editError ?>
  		<input type="hidden" class="form-control" value="<?php echo $id; ?>"  name="edit_pet_id">						  	
	  </div>			  		  		  		  		  	
	</form>
	</div>		
</div>
<div><p><br><br></p></div>
</body>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</html> 