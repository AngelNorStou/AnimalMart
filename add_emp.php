<?php

include 'employees.php';

$empObj = new Employees();
$user = null;

if(isset($_GET['user']) && !empty($_GET['user'])) {

$user = $_GET['user'];


} 


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//echo $_POST['emp_username']. $_POST['emp_date']. $_POST['adminOption'];

	$empObj->insertEmp($_POST, $user);
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
		Add a new Employee
	</div>	
	<form action="add_emp.php" method="POST">
	    <div class="row">
		    <label class="form-label">UserName</label>
			<input type="text" class="form-control" name="emp_username"  required="">
			<div  class="form-text">Make sure that the user has created an account.</div>		
		</div>
	    <div class="row">
	    	<label class="form-label">Start Date</label>
			<input class="form-control" name="emp_date" type="date">
		</div>			    				    				
	  <div class="row">
			<fieldset class="form-group">
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
  	</div>			  		  		  		  		  	
	</form>
	</div>		
</div>
</body>
</html> 