<?php

include '../controller/controller_pet.php';
include '../model/pets.php';

$controller_pet = new ControllerPet(new Pets());

session_start();


if (!isset($_SESSION['username']) || (!isset($_GET['user']) && empty($_GET['user'])) ) // If it is empty
{  

	header("Location:login.php");
	
}


$addError = $controller_pet->verify_addPet($_POST);




?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="../CSS/account.css" rel="stylesheet" >	

	<title>Add Pet</title>	
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
	<div class="row">
		<h3>Add your pet !</h3>
	</div>	
	<form action="add_pet.php?user=<?php echo $_SESSION['username']; ?>" method="POST">
	    <div class="row">
		    <label class="form-label">Pet Name</label>
			<input type="text" class="form-control" name="pet_name" maxlength='30'  required="">	
		</div>
	    <div class="row">
	    	<label class="form-label">Pet Type</label>
			<input type="text" class="form-control"  name="type" maxlength='30' required="">
		</div>			    				    				
	  <div class="row">
		    <label class="form-label">Breed</label>
			<input type="text" class="form-control"  name="breed" maxlength='64' required="">	    				
		</div>
	  <div class="row">
	  		<label class="form-label">Gender</label>	  	
			<select class="form-select" name="gender" aria-label="gender" required="">
				<option selected value="M">Male</option>				
				<option value="F">Female</option>			  			  
			</select>     	
	    </div>				    				    				
	  <div class="row">
		    <label class="form-label">Size (cm)</label>
			<input type="text" class="form-control" v name="size" required="">      					    				    		
		</div>
	  <div class="row">
		    <label class="form-label">Weight (kg)</label>
			<input type="text" class="form-control" name="weight" required="">				    				  		
	  </div>
	  <div class="row">
		    <label class="form-label">Age</label>
			<input type="text" class="form-control"  name="age"  required="">	    		
		</div>	  	  
	  <div class="row">	 	    	   	
  		<button style="float: left;margin-top: 2%;" value="add" type="submit" class="btn btn-primary">Confirm Changes</button>
  		<?php echo $addError ?>
  		<input type="hidden" class="form-control" value="<?php echo $_SESSION['username']; ?>"  name="user">	 
  	</div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 