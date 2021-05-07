<?php

include 'employees.php';

$empObj = new Employees();
$emp = null;
$emp_username = null;

if(isset($_GET['editId']) && !empty($_GET['editId'])) {

$emp_username  = $_GET['editId'];
$emp = $empObj->selectEmployee($emp_username);

} 


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{

	$empObj->updateEmp($_POST);
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

	<title>Edit Employee</title>	
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
		Change an employee's information.
	</div>	
	<form action="edit_emp.php" method="POST">
	    <div class="row">
		    <label class="form-label">UserName</label>
			<input type="text" class="form-control" name="emp_editusername" value= "<?php echo $emp_username ?>" readonly>	
		</div>
	    <div class="row">
	    	<label class="form-label">Start Date</label>
			<input class="form-control" value= "<?php echo $emp['start_date'] ?>" name="emp_date_start" type="date">
		</div>
	    <div class="row">
	    	<label class="form-label">End Date</label>
			<input class="form-control" value= "<?php echo $emp['end_date'] ?>" name="emp_date_end" type="date">
		</div>					    				    				
	  <div class="row">
			<fieldset class="form-group">
			    <legend>Give them Admin powers?</legend>
			    <div class="form-check">
			      <label class="form-check-label">
			      	
			         	<?php 
						if ($emp['isAdmin'] == 0)
						{
							echo "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"0\" checked > No";
						}
						else
						{
							echo "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"0\"> No";
						}
					?>	
			       
			      </label>
			    </div>
			    <div class="form-check">
			    <label class="form-check-label">
			        
			        <?php 
						if ($emp['isAdmin'] == 1)
						{
							echo "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"1\" checked> YES";
						}
						else
						{
							echo "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"1\"> YES";
						}
					?>
			        
			      </label>
			    </div>
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