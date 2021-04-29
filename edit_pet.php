<?php

include 'pets.php';

$petObj = new Pets();
$pet = null;
$id = null;

if(isset($_GET['petEdit']) && !empty($_GET['petEdit'])) {

$id = $_GET['petEdit'];
$pet = $petObj->displayPetById($id);

} 

  if(isset($_POST['update_pet'])) {
    $petObj->updatePet($_POST, $id);
  }
  else 
  {
  	echo "what";
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
	<form action="edit_pet.php" method="POST">
		<div class="row">	
		    <div class="col-sm">
			    <label class="form-label">Pet Name</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_name">
				  <label for="edit_pet_name"><?php echo $pet['pet_name']; ?></label>
				</div>	
		    <div class="">
		    <label class="form-label">Pet Type</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_type" >
				  <label for="edit_pet_type"><?php echo $pet['pet_type']; ?></label>		      		
	    	</div>											    		      		
	    	</div>			    				    				
		</div>
	</div>
	  <div class="row">
		    <div class="col-sm">
		    <label class="form-label">Breed</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_breed">
				  <label for="edit_pet_breed"><?php echo $pet['breed']; ?></label>		      		
	    	</div>				    				    				
		</div>
	  </div>
	  <div class="row">
	  		<label class="form-label">Gender</label>	  	
			<select class="form-select" name="edit_pet_gender" aria-label="edit_pet_gender">
			<?php 
				if ($pet['gender'] == 'M')
				{
					echo "<option selected value=\"M\">Male</option>";
					echo "<option value=\"F\">Female</option>";
				}
				else
				{
					echo "<option value=\"M\">Male</option>";
					echo "<option selected value=\"F\">Female</option>"	;				
				}
			?>			  			  
			</select>     	
	    </div>				    				    				
	  <div class="row">
		    <div class="col-sm">
		    <label class="form-label">Size (cm)</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_size">
				  <label for="edit_pet_size"><?php echo $pet['size']; ?></label>		      		
	    	</div>				    				    				
		</div>
	  </div>
	  <div class="row">
		    <div class="col-sm">
		    <label class="form-label">Weight (kg)</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_weight">
				  <label for="edit_pet_weight"><?php echo $pet['weight']; ?></label>		      		
	    	</div>				    				    				
		</div>
	  </div>
	  <div class="row">
		    <div class="col-sm">
		    <label class="form-label">Age</label>
			    <div class="form-floating">
				  <input type="text" class="form-control"  name="edit_pet_age">
				  <label for="edit_pet_age"><?php echo $pet['age']; ?></label>		      		
	    	</div>				    				    				
		</div>
	  </div>	  	  
	  <div class="row">	  	
  		<button style="float: left;margin: 2%;" value="update_pet" type="submit" class="btn btn-primary">Confirm Changes</button>				  	
	  </div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 