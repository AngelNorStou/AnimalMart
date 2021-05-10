<?php

include '../model/employees.php';
include '../controller/controller_emp.php';

session_start();

$empObj = new Employees();
$controller_emp = new ControllerEmployee($empObj);

if(!isset($_GET['user']) or !isset($_SESSION['username'] )) 
{

	header("Location:login.php");

} 

$addError = $controller_emp->verify_addEmp($_POST, $_SESSION['username']);



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
	    <a class="nav-link active" style="color: white;" href="admin_profile.php?login=<?php echo $_SESSION['username']; ?>" aria-current="page" tabindex="-1"><?php echo  $_SESSION['username']; ?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php" tabindex="-1">Logout</a>
	  </li>
	
        </ul>
    </div>
</nav>
<div class="container">
	<div class="row">
		Add a new Employee
	</div>	
	<form action="add_emp.php?user=<?php echo $_SESSION['username'];?>" method="POST">
	    <div class="row">
		    <label class="form-label">UserName</label>
			<input type="text" class="form-control" name="emp_username"  maxlength='32' required="">
			<div  class="form-text">Make sure that the user has created an account.</div>		
		</div>
	    <div class="row">
	    	<label class="form-label">Start Date</label>
			<input class="form-control" name="emp_date" type="date" required="">
		</div>			    				    				
	  <div class="row">
			<fieldset class="form-group" required="">
			    <legend>Give them Admin powers?</legend>
			    <div class="form-check">
			      <label class="form-check-label">
			        <input type="radio" class="form-check-input" name="adminOption"  value="0" checked>
			       No
			      </label>
			    </div>
			    <div class="form-check">
			    <label class="form-check-label">
			        <input type="radio" class="form-check-input" name="adminOption"  value="1">
			        YES
			      </label>
			    </div>
			  </fieldset>				
		</div> 	  
	  <div class="row">	 	    	   	
  		<button style="float: left;margin-top: 2%;" value="addEmp" type="submit" class="btn btn-primary">Confirm Changes</button> 
  		<?php echo $addError ?>
  	</div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 