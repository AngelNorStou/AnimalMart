<?php include '../controller/controller_services.php'; 


$serviceModel = new Service();
$serviceObj = new ControllerService(); 
$searchStr = $serviceObj->search();

if (!isset ($_GET['page']) ) 
{ 
    $page = 1;  
} else 
{  
    $page = $_GET['page'];  

} 

$results_per_page = 4;  
$page_first_result = ($page-1) * $results_per_page;  

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
		  <li class="nav-item">
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
	    <a class="nav-link" style="color: white;" href="admin_profile.php?login=<?php echo $_SESSION['username']?>" tabindex="-1"><?php echo $_SESSION['username']?></a>
	    <?php } else{?>
	    	 <a class="nav-link" style="color: white;" href="user_profile.php?login=<?php echo $_SESSION['username']?>" tabindex="-1"><?php echo $_SESSION['username']?></a>
	    <?php } ?>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php"  tabindex="-1">Logout</a>
	  </li>
	<?php }?>
	
        </ul>
    </div>
</nav>
	
<div align="left" style="font-family: 'Verdana'; padding-left: 100px;padding-right: 100px;">

	<h3 align="center" style="color: red;padding-top: 30px;line-height: 16px;">Our Services</h3>
	<?php
	if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {  
		?>
		<a href="add_service.php" ><button type="button" style="float: right;" class="btn btn-outline-danger btn-sm" >
			Add a Service
		</button></a>
	<?php }?>
	<div style="float: right;">
		<form action="services.php" method="GET" >
		<div class="input-group input-group-sm mb-3" >
				<input type="text" name="searchInput" name="searchInput" id="searchInput" class="form-control">
			
			<button type="submit" value="search" class="btn btn-outline-danger" > Search </button>
			<button type="button" onclick="window.location.href = 'services.php?page=1'" value="search" class="btn btn-outline-danger" > Clear </button>
		</div>
		</form>
	</div>
		
	<table width="420" style="float:top;">
		<?php 

		if ($searchStr != null)
		{
		  foreach ($searchStr as $service) 
		  {
		  	
		?>      	
	   <tr style="border-width: 1px;" >
	   	<td align="center" width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo 'Type of service: '.$service['service_type'].'<br>'.$service['service_name'].'<br>Price: $'.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo 'Type of service: '.$service['service_type'].'<br>'.$service['service_name'].'<br>Price: $'.$service['service_price'];
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
			<?php } else{ ?>
				<button type="button" class="btn btn-outline-danger btn-sm" type="submit" onclick="location.href = 'appointment.php'" >
			  Book Appointment
			</button>

			<?php } 
				if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {  
					?>
					<div style="padding-top: 5px;">
						<a  href= "edit_service.php?service=<?php echo $service['service_id']; ?>"><button type="submit" class="btn btn-outline-danger btn-sm" >
							Edit Service
						</button></a>
					</div>
				<?php }?>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php } }  ?>
	</table>
<!-- <! -- 
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link active"  id="grooming-tab" data-bs-toggle="tab" data-bs-target="#grooming" type="button" role="tab" aria-controls="grooming" aria-selected="true">Grooming</a>
	  </li>
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab" aria-controls="training" aria-selected="false">Training</a>
	  </li>
	  <li class="nav-item">
	    <a style="color: blue;" class="nav-link" id="vet-tab" data-bs-toggle="tab" data-bs-target="#vet" type="button" role="tab" aria-controls="vet" aria-selected="false">Vet</a>
	  </li>
	</ul>  -->
<div class="tab-content" id="v-pills-tabContent">

	<div class="tab-pane fade show active" id="grooming" role="tabpanel" aria-labelledby="grooming-tab">

		<br>
		<div id="header" style="width:100%;">
    		<div style='float:left;padding-right:20px;'>
        		<img src="../Images/grooming.jpg"/>
    		</div>
		</div>

	<table width="420" style="margin-right:30%;float:top;">
		<?php 
		$services =$serviceObj->getServices($results_per_page,$page_first_result);


		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	

		?>      	
	  <tr style="border-width: 1px;" >
	   	<td align="center" width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo 'Type of service: '.$service['service_type'].'<br>'.$service['service_name'].'<br>Price: $'.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo 'Type of service: '.$service['service_type'].'<br>'.$service['service_name'].'<br>Price: $'.$service['service_price'];
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
			<?php } else{ ?>
				<button type="button" class="btn btn-outline-danger btn-sm"  type="submit" onclick="location.href = 'appointment.php'" >
			  Book Appointment
			</button>
			<?php } 
				if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {  
					?>
					<div style="padding-top: 5px;">
						<a  href= "edit_service.php?service=<?php echo $service['service_id']; ?>"><button type="submit" class="btn btn-outline-danger btn-sm" >
							Edit Service
						</button></a>
					</div>
				<?php }?>

	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php  } } ?>
	   	<td>	
	   		<div align="right">
			<?php 
				echo $serviceObj->displayPagination($results_per_page);
			?>
			</div>
	   	</td>
		</tr>
	</table>
	

</div>
		<div class="tab-pane fade fade" id="training" role="tabpanel" aria-labelledby="training-tab">
	
		<br>
			<div id="header" style="width:100%;">
    		<div style='float:right'>
        		<img src="../Images/training.jpg" width="600" height="350"  alt="test" style="padding-top: 16px; margin-right:15%;margin-top:5%"/>
    		</div>
		</div>
	<table width="420" style="margin-right:30%;float:top;">
		<?php 

		$services = $serviceObj->getServices('training',$results_per_page,$page_first_result);


		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	
		?>      	
	   <tr style="border-width: 1px;" >
	   	<td align="center" width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo $service['service_name'].'<br>Price: $'.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo $service['service_name'].'<br>Price: $'.$service['service_price'];
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
			<?php } else{ ?>
				<button type="button" class="btn btn-outline-danger btn-sm" type="submit" onclick="location.href = 'appointment.php'" >
			  Book Appointment
			</button>

			<?php } 
				if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {  
					?>
					<div style="padding-top: 5px;">
						<a  href= "edit_service.php?service=<?php echo $service['service_id']; ?>"><button type="submit" class="btn btn-outline-danger btn-sm" >
							Edit Service
						</button></a>
					</div>
				<?php }?>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php  } } ?>
	</table>
	<?php 
		echo $serviceObj->displayPagination($results_per_page);
	?>

</div>
<div  class="tab-pane fade" id="vet" role="tabpanel" aria-labelledby="vet-tab">
	<br>
	<div id="header" style="width:100%;">
    		<div style='float:right'>
        		<img src="../Images/vet.jpg" width="500" height="350" alt="test" style="padding-top: 16px; margin-right:15%;margin-top:5%"/>
    		</div>
		</div>
		
	<table width="420" style="margin-right:30%;float:top;">
		<?php 

		$services = $serviceObj->getServices('vet',$results_per_page,$page_first_result);


		if ($services != null)
		{
		  foreach ($services as $service) 
		  {
		  	
		?>      	
	   <tr style="border-width: 1px;">
	   	<td align="center"  width="250" class="form-label card-text">
	   		<?php 
	   			if($service['service_length'] != '')
	   				echo $service['service_name'].'<br>Price: $'.$service['service_price'].'<br>Length: '.$service['service_length'].' minutes';
	   			else
	   				echo $service['service_name'].'<br>Price: $'.$service['service_price'];
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
			<?php } else{ ?>
				<button type="button"  type="submit" onclick="location.href = 'appointment.php'"  class="btn btn-outline-danger btn-sm">
			  Book Appointment
			</button>
			<?php } 
				if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {  
					?>
					<div style="padding-top: 5px;">
						<a  href= "edit_service.php?service=<?php echo $service['service_id']; ?>"><button type="submit" class="btn btn-outline-danger btn-sm" >
							Edit Service
						</button></a>
					</div>
			<?php }?>
	   	</td>
	   	<tr><td><br></td></tr>
	   	<?php  } } ?>
	   </tr>
	</table>
	<?php 
		echo $serviceObj->displayPagination($results_per_page);
	?>
	 </div>
	</div>
</div>
</body>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</html>