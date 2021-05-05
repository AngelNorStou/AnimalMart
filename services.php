<?php
include 'services_controller.php';
$serviceObj = new Service();
$services = $serviceObj->displayService();
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<title>Our Services</title>

</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
	  <li class="nav-item">
	    <a class="nav-link" style="color: lightblue;" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link active" style="color: white;" aria-current="page"  href="">Services Offered</a>
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
	    <a class="nav-link" style="color: white;" href="user_profile.php" tabindex="-1"><?php echo $_SESSION['username']?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php"  tabindex="-1">Logout</a>
	  </li>
	<?php }?>
	
        </ul>
    </div>
</nav>

<div align="left" style="padding-left: 30px;">
	<h3 align="center" style="color: red;">Our Services</h3>
	<p align="center" style="line-height: 0px;padding-bottom: 10px;">_____________________</p>
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link active" id="grooming-tab" data-bs-toggle="tab" data-bs-target="#grooming" type="button" role="tab" aria-controls="grooming" aria-selected="true">Grooming</a>
	  </li>
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab" aria-controls="training" aria-selected="false">Training</a>
	  </li>
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link" id="vet-tab" data-bs-toggle="tab" data-bs-target="#vet" type="button" role="tab" aria-controls="vet" aria-selected="false">Vet</a>
	  </li>
	</ul>
	<div class="tab-content" id="v-pills-tabContent">
	<div class="tab-pane fade show active" id="grooming" role="tabpanel" aria-labelledby="grooming-tab">
		<br>
	<table width="400">
		<?php 

		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	if($service['service_type'] == 'grooming'){

		?>      	
	  <tr style="border-width: 1px;" >
	   	<td align="center" width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'];
	   		?>
	   		<br>
	   	</td>
	   	<td>
	   		 <?php
	   		 	if($service['service_description'] != ''){
			  ?>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $service['service_id'] ?>">
			  More info
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal<?php echo $service['service_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel"><?php echo $service['service_name'] ?></h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <?php  
			        	echo $service['service_description'];
			       	?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
			        <button value="appointments"  type="submit" onclick="location.href = 'appointment.php'" class="btn btn-outline-danger btn-sm">Book an appointment</button>
			      </div>
			    </div>
			  </div>
			</div>
			<br>
			<?php } ?>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php } } } ?>
		</tr>
	      
	</table>
</div>
<div class="tab-pane fade" id="training" role="tabpanel" aria-labelledby="training-tab">
	<br>
	<table width="400">
		<?php 

		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	if($service['service_type'] == 'training'){
		?>      	
	   <tr style="border-width: 1px;" >
	   	<td align="center" width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'];
	   		?>
	   		<br>
	   		</td>
	   	<td>
	   		
	   		 <?php
	   		 	if($service['service_description'] != ''){
			  ?>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $service['service_id'] ?>">
			  More info
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal<?php echo $service['service_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel"><?php echo $service['service_name'] ?></h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <?php  
			        	echo $service['service_description'];
			       	?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
			        <button value="appointments"  type="submit" onclick="location.href = 'appointment.php'" class="btn btn-outline-danger btn-sm">Book an appointment</button>
			      </div>
			    </div>
			  </div>
			</div>
			<?php } ?>
			<br>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php } } } ?>
	</table>
</div>
<div  class="tab-pane fade" id="vet" role="tabpanel" aria-labelledby="vet-tab">
	<br>
	<table width="400">
		<?php 

		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	if($service['service_type'] == 'vet'){
		?>      	
	   <tr style="border-width: 1px;">
	   	<td align="center"  width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo $service['service_name'].'<br>Price: '.$service['service_price'];
	   		?>
	   		<br>
	   	</td>
	   	<td>

	   		<?php
	   		 	if($service['service_description'] != ''){
			  ?>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $service['service_id'] ?>">
			  More info
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal<?php echo $service['service_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel"><?php echo $service['service_name'] ?></h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <?php  
			        	echo $service['service_description'];
			       	?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
			        <button value="appointments"  type="submit" onclick="location.href = 'appointment.php'" class="btn btn-outline-danger btn-sm">Book an appointment</button>
			      </div>
			    </div>
			  </div>
			</div>
			<?php } ?>
			<br>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php } } } ?>
	</table>
	 </div>
	</div>
</div>

<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html>