<?php



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
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="accountDetailsTab" data-bs-toggle="pill" data-bs-target="#accountDetails" type="button" role="tab" aria-controls="accountDetails" aria-selected="true">Account</button>
    <button class="nav-link" id="employeeDetailsTab" data-bs-toggle="pill" data-bs-target="#employeeDetails" type="button" role="tab" aria-controls="employeeDetails" aria-selected="false">Employee List</button>
  </div>
  <div class="tab-content" id="v-pills-tabContent">
    <div  class="tab-pane fade show active" id="accountDetails" role="tabpanel" aria-labelledby="accountDetailsTab">
		<div class="container">		
			<form>
				<div class="row">
				    <div class="col-3">
			      		<img src="Images/guest.jpg" class="img-thumbnail" alt="...">
			    	</div>	
				    <div class="col-sm">
					    <label class="form-label">First Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" id="firstNameEdit" placeholder="John">
						  <label for="firstNameEdit">John</label>
						</div>	
				    <div class="">
				    <label class="form-label">Last Name</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" id="lastNameEdit" placeholder="Smith">
						  <label for="lastNameEdit">Smith</label>		      		
			    	</div>											    		      		
			    	</div>			    				    				
				</div>
			</div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Username</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" id="usernameEdit" placeholder="Guest">
						  <label for="usernameEdit">Guest</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Email</label>
					    <div class="form-floating">
						  <input type="email" class="form-control" id="emailEdit" placeholder="example@web.ca">
						  <label for="emailEdit">example@web.ca</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Password</label>
					    <div class="form-floating">
						  <input type="password" class="form-control" id="passwordEdit" placeholder="***">
						  <label for="passwordEdit">***************</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">City</label>
					    <div class="form-floating">
						  <input type="text" class="form-control" id="cityEdit" placeholder="Montreal">
						  <label for="cityEdit">Montreal</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				    <div class="col-sm">
				    <label class="form-label">Phone Number</label>
					    <div class="form-floating">
						  <input type="tel" class="form-control" id="phoneEdit" placeholder="999-999-9999">
						  <label for="phoneEdit">999-999-9999</label>		      		
			    	</div>				    				    				
				</div>
			  </div>
			  <div class="row">
				<label  class="form-label">Profile Picture</label>
				<input class="form-control form-control-lg" id="profilePicture" type="file" />
			  </div>

			  	<button id="updateButton" type="submit" class="btn btn-primary">Confirm Changes</button>
			  		  		  		  	
			</form>	
		</div>
    </div>
    <div class="tab-pane fade" id="employeeDetails" role="tabpanel" aria-labelledby="employeeDetailsTab">
	   <table class="table">
	  <thead>
	    <tr>
	      <th scope="col">Employee_ID</th>
	      <th scope="col">User_ID</th>
	      <th scope="col">start_time</th>
	      <th scope="col">end_time</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td>123456</td>
	      <td>789012</td>
	      <td>Sunday April 11 2021,6:00pm</td>
	      <td></td>
	    </tr>
	  </tbody>
	</table> 	
    </div>
  </div>
</div>
</div>
</body>
</html> 