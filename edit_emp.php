<?php

include './view/view_emp.php';
include './model/employees.php';
include './controller/controller_emp.php';

session_start();


// MVC in OOP for Employees
$empObj = new Employees();
$empView = new ViewEmp($empObj);
$controller_emp = new ControllerEmployee($empObj);

if(!isset($_GET['editUser']) or !isset($_SESSION['username']) ) 
{

	header("Location:login.php");

} 


$controller_emp->verify_editEmp($_POST,$_SESSION['username']);



?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="CSS/account.css" rel="stylesheet" >	

	<title>Edit Employee</title>	
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
		Change an employee's information.
	</div>	
	<form action="edit_emp.php?editUser=$_GET['editUser']" method="POST">
	    <div class="row">
		    <label class="form-label">UserName</label>
			<input type="text" class="form-control" name="emp_editusername" value="<?php echo $_GET['editUser']; ?>" readonly>	
		</div>
	    <div class="row">
	    	<label class="form-label">Start Date</label>
			<input class="form-control" value= "<?php echo $empView->displayItem($_GET['editUser'],'start_date'); ?>" name="emp_date_start" type="date" required="">
		</div>
	    <div class="row">
	    	<label class="form-label">End Date</label>
			<input class="form-control" value= "<?php echo $empView->displayItem($_GET['editUser'],'end_date'); ?>" name="emp_date_end" type="date">
		</div>					    				    				
	  <div class="row">
			<fieldset class="form-group" required="">
			    <legend>Give them Admin powers?</legend>
			    <div class="form-check">
			      <label class="form-check-label">			      	
			        <?php 
						echo $empView->displayAdminPower($_GET['editUser']);
					?>				       
			  </fieldset>				
		</div> 	  
	  <div class="row">	 	    	   	
  		<button style="float: left;margin-top: 2%;" value="EditEmp" type="submit" class="btn btn-primary">Confirm Changes</button> 
  	</div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 