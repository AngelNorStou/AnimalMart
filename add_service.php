<?php
include 'model_services.php';
session_start();
$serviceObj = new Service();
$services = $serviceObj->getServiceType();

	if(isset($_POST['addService'],$_POST['service_type']))
	{
	    $val = $serviceObj->addService($_POST);
	    if($val == 1){
	    	header("Location: services.php");
	    }
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

	<title>Add a Service!</title>
</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link active" style="color: white;" aria-current="page"  href="services.php">Services Offered</a>
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
	 	<a class="nav-link" style="color: white;" href="user_profile.php" tabindex="-1"><?php echo $_SESSION['username']?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php"  tabindex="-1">Logout</a>
	  </li>
	
        </ul>
    </div>
</nav>
<div>
	<div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" role="tabpanel">
		<div class="container">		
			<form class="userForms" action="add_service.php" method="POST" style="background-color: lightblue; border-color: lightblue;" >
				<h3 align="center">Add a service</h3>
				<p align="center" style="line-height: 0px;padding-bottom: 10px;">__________________________</p>
				<div class="row g-3">
				   <div class="col">
				  	 <label class="form-label">Service Type</label>
				    <select name="service_type" id="inputState" class="form-select" required="required">
				      <option value="choose" selected>Choose...</option>
				      <?php foreach($services as $service){ ?>
				      <option name="<?php echo $service['service_type']; ?>"><?php echo $service['service_type']; ?></option>
				      <?php }?>
				    </select>
				  </div>
				<div class="col">
				    <label class="form-label">Service Name</label>
				    	<input type="text" class="form-control" id="name" name="name" placeholder="">	    				    				
				</div>
			  </div>
			  <br>
			  <div class="row">
				<div class="col-sm">
				    <label class="form-label">Service Description</label>
				    	<textarea type="textarea" class="form-control" id="desc" name="desc" placeholder="description of the service offered (optional)"></textarea> 	    				    				
				</div>
			  </div>
			  <br>
			  <div class="row">
				<div class="col">
					<label class="form-label">Length</label>
					  <input type="text" class="form-control" id="length" name="length" placeholder="">  				    				
				</div>
				 <div class="col">
				    <label class="form-label">Price</label>
					 <input type="text" class="form-control" id="price" name="price" placeholder="">	    				    				
				</div>
			  </div>
			  <br>
			  	<button id="addService" value="addService" name="addService" value="submit" type="submit" class="btn btn-danger">Add</button>
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