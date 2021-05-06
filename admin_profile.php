<?php

 include 'users.php';
 include 'pets.php';
 include 'employees.php';

$userObj = new Users();
$empObj = new Employees();
$user = null;
$user_name = null;

//session_start();
if (!isset($_SESSION['username'])) {  

	if(isset($_GET['login']) && !empty($_GET['login']))
	{
		$user_name = $_GET['login'];
		$user = $userObj->displayRecordByUsername($_GET['login']);

		$_SESSION['username'] = $user['username'];

	}
	else
	{
		header("Location:login.php");
	}
}

if(isset($_POST['uusername'],$_POST['upassword'])) 
{
	$userObj->updateUser($_POST);
	
} 


if(isset($_POST['new_password'],$_POST['current_password'],$_POST['current_user'] )) 
{
	$userObj->changePassword($_POST);
	
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
<div  style="background-color: lightblue;">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" aria-current="page" href="Home.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="contact.php">Contact</a>
	  </li>
	  <li class="nav-item" >
	    <a class="nav-link active" style="color: darkblue;" href="user_profile.php?login=<?php echo $_GET['login']; ?>" tabindex="-1"><?php echo $user['first_name']; ?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="Home.php" tabindex="-1">Log Out</a>
	  </li>
	</ul>	
</div>	
<div class="container" style="padding-top: 16px;">	
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="accountDetailsTab" data-bs-toggle="pill" data-bs-target="#accountDetails" type="button" role="tab" aria-controls="accountDetails" aria-selected="true">Account</button>
    <button class="nav-link" id="passwordEditTab" data-bs-toggle="pill" data-bs-target="#passwordEdit" type="button" role="tab" aria-controls="passwordEdit" aria-selected="false">Change Password</button>
     <button class="nav-link" id="employeesEditTab" data-bs-toggle="pill" data-bs-target="#employeesEdit" type="button" role="tab" aria-controls="employeesEdit" aria-selected="false">Employees</button>   
  <a class="nav-link"  style="color: black;" aria-selected="false" href="change_picture.php?profile=<?php echo $user['username']; ?>" >Change Profile Picture</a>  
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">			
			<form id="userProfile"  action="admin_profile.php" method="POST" >
				<div class="row">
				    <div class="col-3">
			      		<img src="<?php echo $user['profile_picture']; ?>" class="img-thumbnail" alt="No Picture Found.">
			    	</div>	
				    <div class="col-sm">
					    <label class="form-label">First Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ufirstname">
						  <label for="firstNameEdit"><?php echo $user['first_name']; ?></label>
						</div>	
				    <div class="">
				    <label class="form-label">Last Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ulastname" >
						  <label for="lastNameEdit"><?php echo $user['last_name']; ?></label>		      		
			    	</div>											    		      		
			    	</div>			    				    				
				</div>
			</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control"  name="uemail">
						  <label for="emailEdit"><?php echo $user['email']; ?></label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">City</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"   name="ucity">
						  <label for="cityEdit"><?php echo $user['city']; ?></label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
			  	<div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control"  name="uphone">
					  <label for="phoneEdit"><?php echo $user['phone_number']; ?></label>	 </div>     		
			    	</div>				    				    				
			  </div>
			  <div class="row">
			  	<label class="form-label">Enter your current username and password to confirm the changes.</label>
				    <div class="col-sm">
				    <label class="form-label">Username</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" name="uusername">
						  <label for="usernameEdit"><?php echo $user['username']; ?></label>		      		
			    		</div>	
			    	</div>			    				    				
				</div>
				<div class="col-sm">
				    <label class="form-label">Password</label>
					    <div class="form-floating">
						  <input type="password" class="form-control"  name="upassword">
						  <label for="passwordEdit"></label>		      		
			    		</div>		    									  				  	
			  </div>
				  <div class="row">
			  		<button style="float: left;margin: 2%;" name="update"  value="update" type="submit" class="btn btn-primary updatePicture">Confirm Changes</button>					  	
				  </div>			  		  		  		  		  	
			</form>	
		</div>
    </div>
    <div class="tab-pane fade" id="passwordEdit" role="tabpanel" aria-labelledby="passwordEditTab">
		 <form id="changePass"  action="admin_profile.php" method="POST">
		 	  <div class="row">
			  	<label class="form-label">Enter your current password and username to add a new password.</label>
				    <div class="row">
				    	<div class="col-sm">
				    	<label class="form-label">Current Username</label>
						    <div class="form-floating">
							  <input type="text" class="form-control" name="current_user">
							  <label for="current_username"><?php echo $user['username']; ?></label>		      		
				    		</div>
			    		</div>	
			    	</div>			  	
				    <div class="row">
					    <label class="form-label">Current Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="current_password">
							  <label for="current_password"></label>		      		
				    		</div>		      		
			    	</div>
			    	<br/>
				    <div class="row">
					    <label class="form-label">New Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="new_password">
							  <label for="new_password"></label>		      		
				    		</div>		      		
			    		</div>
				    <div class="row">
			      		<button style="float: left;margin-top: 2%;" value="changePassword" type="submit" class="btn btn-primary">Confirm Changes</button>		
			    	</div>	 	    			    			
			    </div>	
		 </form>   				    				    				
		</div>
    <div class="tab-pane fade" id="employeesEdit" role="tabpanel" aria-labelledby="employeesEditTab">
 	<a class="btn btn-primary" href="add_emp.php?user=<?php echo $user_name;?>">Add an Employee Here!</a>   	
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>First Name</th>
	        <th>Last Name</th>        
	        <th>Start Date</th>
	        <th>End Date</th>
	      </tr>
	    </thead>
	    <tbody>
	        <?php 

				$employees = $empObj->displayEmployees();	

			  	foreach ($employees as $emp) 
			  	{
	        ?>
	        <tr>
	          <td><?php echo $emp['first_name'] ?></td>
	          <td><?php echo $emp['last_name'] ?></td>
	          <td><?php echo $emp['start_date'] ?></td>          
	          <td><?php echo $emp['end_date'] ?></td>
	          <td>
	            <a href="edit_emp.php?editId=<?php echo $emp['employee_id'] ?>" style="color:green">Edit?</a>
	            </a>
	          </td>
	        </tr>
	      <?php } ?>
	    </tbody>
	  </table>  				    				    				
	</div>	
	</div>		
    </div>
  </div>
</div>
</body>
</html> 