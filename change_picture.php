<?php


include 'users.php';

$userObj = new Users();
$user = null;
$user_name = null;

if(isset($_GET['profile']) && !empty($_GET['profile']))
{
	$user_name = $_GET['profile'];
}


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$target = $userObj->target_dir.$_FILES["upicture"]["name"];
	move_uploaded_file($_FILES["upicture"]["tmp_name"], $target); 
	$userObj->updatePicture($_FILES["upicture"]["name"],$_POST['current_user']);
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


	<title>Change Picture</title>	
</head>
<body>
<div  style="background-color: lightblue;">
	<ul class="nav justify-content-center">
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" aria-current="page" href="#">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="services.php">Services Offered</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: blue;" href="contact.php">Contact</a>
	  </li>
	  <li class="nav-item" >
	    <a class="nav-link active" style="color: darkblue;" href="user_profile.php?login=<?php echo $user_name; ?>" tabindex="-1"><?php echo $user_name; ?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="Home.php" tabindex="-1">Log Out</a>
	  </li>
	</ul>	
</div>
<div class="container">
    	<form id="userPicture"  action="change_picture.php" method="POST" enctype="multipart/form-data">
			  <div class="row">
			  	<label class="form-label">Select a new image file.</label>
			  	<div class="row">
				<label class="form-label">Profile Picture</label>
				<input class="form-control form-control-lg" name="upicture" id="upicture" type="file" /> 			  		
			  	</div>
		  </div>
		  <div class="row">
	  		<button style="float: left;margin-top: 2%;" name="selectImage"  value="selectImage" type="submit" class="btn btn-primary selectImage">Confirm Changes</button>			
			<input type="hidden" class="form-control" value="<?php echo $user_name; ?>"  name="current_user">		  			
		  </div>	    		
    	</form>
	</div>		
</div>
</body>
</html> 