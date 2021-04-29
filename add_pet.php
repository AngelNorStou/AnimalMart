<?php

include 'pets.php';

$petObj = new Pets();
$user = null;

if(isset($_GET['user']) && !empty($_GET['user'])) {

$user = $_GET['user'];


} 

  if($_SERVER['REQUEST_METHOD'] == 'POST') 
  {

    $petObj->insertPet($_POST);
  }
  else 
  {
  	echo "Empty fields?";
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

	<title>Add Pet</title>	
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
	<div class="row">
		Add your pet !
	</div>	
	<form action="add_pet.php" method="POST">
	    <div class="row">
		    <label class="form-label">Pet Name</label>
			<input type="text" class="form-control" name="pet_name"  required="">	
		</div>
	    <div class="row">
	    	<label class="form-label">Pet Type</label>
			<input type="text" class="form-control"  name="type" required="">
		</div>			    				    				
	  <div class="row">
		    <label class="form-label">Breed</label>
			<input type="text" class="form-control"  name="breed" required="">	    				
		</div>
	  <div class="row">
	  		<label class="form-label">Gender</label>	  	
			<select class="form-select" name="gender" aria-label="gender">
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
  		<input type="text" class="form-control" value="<?php echo $user; ?>"  name="user">	 
  	</div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 