<?php


include './model/users.php';

$userObj = new Users();
$user = null;

session_start();

if (!isset($_SESSION['username'])) // If it is empty
{  

	header("Location:login.php");

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
	    <a class="nav-link active" style="color: white;" href="user_profile.php" aria-current="page" tabindex="-1"><?php echo $_SESSION['username'] ?></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" style="color: red;" href="logout.php" tabindex="-1">Logout</a>
	  </li>
	
        </ul>
    </div>
</nav>
<div class="container">
    	<form id="userPicture"  style="margin-top: 2%;" action="change_picture.php" method="POST" enctype="multipart/form-data">
			  <div class="row">
			  	<h3 style="margin-bottom: 1%;">Select a new image file for your profile picture.</h3>
			  	<div class="row">
				<input style="margin-left: 1%;" class="form-control form-control-lg" name="upicture" id="upicture" type="file" /></div>
		  </div>
		  <div class="row">
	  		<button style="float: left;margin-top: 2%;margin-left: 1%;" name="selectImage"  value="selectImage" type="submit" class="btn btn-primary selectImage">Confirm Changes</button>			
			<input type="hidden" class="form-control" value="<?php echo $_SESSION['username']; ?>"  name="current_user">		  			
		  </div>	    		
    	</form>
	</div>		
</div>
</body>
</html> 