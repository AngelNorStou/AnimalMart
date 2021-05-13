<?php

include '../model/model_services.php';

include '../controller/controller_user.php';
include '../model/users.php';
include '../view/view_user.php';


include '../view/view_emp.php';
include '../model/employees.php';
include '../controller/controller_emp.php';
include '../controller/controller_message.php';

session_start();


// MVC in OOP for Users
$userObj = new Users();
$controller_user = new ControllerUser($userObj);
$userView = new ViewUser($userObj);

// MVC in OOP for Employees
$empObj = new Employees();
$empView = new ViewEmp($empObj);
$controller_emp = new ControllerEmployee($empObj);

$serviceObj = new Service();



if (!isset($_SESSION['username'])) // If it is empty
{  

	if(isset($_GET['login']) && !empty($_GET['login']))
	{

		$_SESSION['username'] = $_GET['login'];
		$_SESSION['isAdmin'] = 1;

	}
	else
	{
		header("Location:login.php");
	}
}


$deleteError = $controller_emp->verify_delete($_GET);


$updateError = $controller_user->verify_update($_POST);
$passwordError = $controller_user->verify_passwordChange($_POST);

$messageObj = new ControllerMessage();
$messages = $messageObj->display();
$deleteMessage = $messageObj->delete($_GET);

?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<link href="../CSS/account.css" rel="stylesheet" >		

	<title>View Account</title>	
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
<div class="container" style="padding-top: 16px;">	
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="accountDetailsTab" data-bs-toggle="pill" data-bs-target="#accountDetails" type="button" role="tab" aria-controls="accountDetails" aria-selected="true">Account</button>
     <button class="nav-link" id="employeesEditTab" data-bs-toggle="pill" data-bs-target="#employeesEdit" type="button" role="tab" aria-controls="employeesEdit" aria-selected="false">Employees</button> 
      <button class="nav-link" id="messagesTab" data-bs-toggle="pill" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Messages</button>   
       <button class="nav-link" id="passwordEditTab" data-bs-toggle="pill" data-bs-target="#passwordEdit" type="button" role="tab" aria-controls="passwordEdit" aria-selected="false">Change Password</button>
  <a class="nav-link"  style="color: black;" aria-selected="false" href="change_picture.php?profile=<?php echo $_SESSION['username']; ?>" >Change Profile Picture</a>  
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">	
			<h3 align="center" style="color: darkblue;">Update your account information!</h3>
			<form id="userProfile"  action="admin_profile.php?login=<?php echo $_SESSION['username']?>" method="POST" >
				<div class="row">
				    <div class="col-3">
						<?php echo $userView->displayPictureSource($_SESSION['username']); ?>
			    	</div>	
				    <div class="col-sm">
					    <label class="form-label">First Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  name="ufirstname" maxlength='30'>
						 <?php echo $userView->displayItem($_SESSION['username'],'first_name'); ?>
						</div>	
				    <div class="">
				    <label class="form-label">Last Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" maxlength='100'  name="ulastname" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'last_name'); ?>		      		
			    	</div>											    		      		
			    	</div>			    				    				
				</div>
			</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control" maxlength='128' name="uemail" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'email'); ?> 	      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">City</label>
					    <div class="form-floating">
						  <input type="text" class="form-control"  maxlength='85' name="ucity" required>
						  <?php echo $userView->displayItem($_SESSION['username'],'city'); ?>	      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
			  	<div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control"  name="uphone" maxlength='14'>
					  <?php echo $userView->displayItem($_SESSION['username'],'phone_number'); ?>
					  	 </div>     		
			    	</div>				    				    				
			  </div>
			  <div class="row">
			  	<label class="form-label">Enter your current username and password to confirm the changes.</label>
				    <div class="col-sm">
				    <label class="form-label">Username</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" name="uusername" maxlength='32'required>
						  <?php echo $userView->displayItem($_SESSION['username'],'username'); ?>	      		
			    		</div>	
			    	</div>			    				    				
				</div>
				<div class="col-sm">
				    <label class="form-label">Password</label>
					    <div class="form-floating">
						  <input type="password" class="form-control"  name="upassword" required maxlength='64'>
						  <label ></label>		      		
			    		</div>		    									  				  	
			  </div>
				  <div class="row">
			  		<button style="float: left;margin: 2%;" name="update"  value="update" type="submit" class="btn btn-primary updatePicture">Confirm Changes</button>	
					<?php
					 								
						echo $updateError;
					?>				  						  	
				  </div>			  		  		  		  		  	
			</form>
		</div>
    </div>
    <div class="tab-pane fade" id="passwordEdit" role="tabpanel" aria-labelledby="passwordEditTab">
		 <form id="changePass"  action="admin_profile.php?login=<?php echo $_SESSION['username']?>" method="POST">
		 	  <div class="row">
			  	<label class="form-label">Enter your current password and username to add a new password.</label>
				    <div class="row">
				    	<div class="col-sm">
				    	<label class="form-label">Current Username</label>
						    <div class="form-floating">
							  <input type="text" class="form-control" name="current_user" maxlength='32'>
							  <?php echo $userView->displayItem($_SESSION['username'],'username'); ?>	      		
				    		</div>
			    		</div>	
			    	</div>			  	
				    <div class="row">
					    <label class="form-label">Current Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="current_password" maxlength='64'>
							  <label for="current_password"></label>		      		
				    		</div>		      		
			    	</div>
			    	<br/>
				    <div class="row">
					    <label class="form-label">New Password</label>
						    <div class="form-floating">
							  <input type="password" class="form-control"  name="new_password" maxlength='64'>
							  <label for="new_password"></label>		      		
				    		</div>		      		
			    		</div>
				    <div class="row">
			      		<button style="float: left;margin-top: 2%;" value="changePassword" type="submit" class="btn btn-primary">Confirm Changes</button>
					<?php
					 	echo $passwordError;
					?>				      				
			    	</div>	 	    			    			
			    </div>	
		 </form>   				    				    				
		</div>
		<?php
		 								
			echo $deleteError;
		?>		
    <div class="tab-pane fade" id="employeesEdit" role="tabpanel" aria-labelledby="employeesEditTab">
 	<a style="float: right;" class="btn btn-primary" href="add_emp.php?user=<?php echo $_SESSION['username'];?>">Add an Employee Here!</a>   	
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>First Name</th>
	        <th>Last Name</th>        
	        <th>Start Date</th>
	        <th>End Date</th>
	        <th>Actions</th>
	      </tr>
	    </thead>
	    <tbody>
	        <?php 

				echo $empView->getAllEmp($_SESSION['username']);	
	        ?>
	    </tbody>
	  </table>  				    				    				
	</div>
	<div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messagesTab">
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>First Name</th>
	        <th>Last Name</th>        
	        <th>Email</th>
	        <th>Phone Number</th>
	        <th>Message</th>
	        <th>Date</th>
	        <th>Actions</th>
	      </tr>
	    </thead>
	    <tbody>
	        <?php 
			  	foreach ((array)$messages as $message) 
			  	{
	        ?>
	        <tr>
	          <td><?php echo $message['first_name'] ?></td>
	          <td><?php echo $message['last_name'] ?></td>
	          <td><?php echo $message['email'] ?></td>          
	          <td><?php echo $message['phone_number'] ?></td>
	          <td><?php echo $message['message_body'] ?></td>
	           <td><?php echo $message['message_timestamp'] ?></td>
	          <td>
	            <a href="mailto:<?php echo $message['email'] ?>">Reply</a>
	            </a>
            <a href="admin_profile.php?&deleteMessage=<?php echo $message['message_id'] ?>" 
            	style="color:red" onclick="confirm('Are you sure want to delete this message ?')">
              Delete
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
<div><p><br></p></div>
</body>
<footer align="center" style="background-color: lightblue;">
	123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
	©2021 AnimalMart, Inc. All rights reserved.
</footer>
</html> 