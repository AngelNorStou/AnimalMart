<?php


class ControllerUser
{
	public $userObj ;

    public function __construct(Users $user_obj)
    {
    	if(session_id() == ''){
		    //session has not started
		    session_start();
		}
    	//Set connection

    	$this->userObj = $user_obj;
    	
    }

    public function verify_login($post)
    {
    	// Checks if the data is empty.
    	// The 'required' Attribute of the input fields
    	// ensure that the user fills the textboxes.

		if(isset($_POST['login_username'],$_POST['login_email'] , $_POST['login_password']))
		{
		    $UserExist = $this->userObj->login($_POST);

		    // Checks if user exists
		    if ($UserExist)
		    {

		    	//header("Location:user_profile.php?login=".$_POST['login_username']);
		    	$this->userObj->isAdmin($_POST['login_username']);


		    	return "";
		    }
		    else
		    {
		    	return "Not match found in our database. Please create an account." ;
		    }


		}
	
    }

    public function verify_insert($post)
    {
    	// Checks if the data is empty.
    	// The 'required' Attribute of the input fields
    	// ensure that the user fills the textboxes.

		if($_SERVER['REQUEST_METHOD'] == 'POST' )
		{	

			if (!($_FILES['profilepic']['size'] == 0 && $_FILES['profilepic']['error'] == 0))
			{
			    $target = $this->userObj->target_dir.$_FILES["profilepic"]["name"];
			    move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target); 
			}	
				
		    $this->userObj->insertUser($_POST,$_FILES); 
		}
	
    }



    public function verify_update($post)
    {
    	// Checks if the data is empty.
    	// The 'required' Attribute of the input fields
    	// ensure that the user fills the textboxes.

		if(isset($_POST['uusername'],$_POST['upassword'])) 
		{
			$isUser = $this->userObj->isUser($_POST['uusername'],$_POST['upassword']);

			if ($isUser) // Matching password and username
			{
				$this->userObj->updateUser($_POST);

		    	return "";				

				
			}
			else
			{
				return "Please enter the correct username and password to confirm the changes." ;
			}
			
			
		}
	 		
	
    }


    public function verify_passwordChange($post)
    {
    	// Checks if the data is empty.
    	// The 'required' Attribute of the input fields
    	// ensure that the user fills the textboxes.

		if(isset($_POST['new_password'],$_POST['current_password'],$_POST['current_user'] )) 
		{
			$isUser = $this->userObj->isUser($_POST['current_user'],$_POST['current_password']);

			if ($isUser) // Matching password and username
			{
				$this->userObj->changePassword($_POST);

				return "";
			}
			else
			{
				return "Please enter the correct current username and password to confirm the changes." ;
			}			
			
			
		} 		 		
	
    } 

    public function verify_pictureChange($files, $user)
    {
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
	    	$target = $this->userObj->target_dir.$_FILES["upicture"]["name"];

	    	$target_file = $target . basename($_FILES["upicture"]["name"]);

			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) 
			{
			  return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

			} 


			move_uploaded_file($_FILES["upicture"]["tmp_name"], $target); 

			$this->userObj->updatePicture($_FILES["upicture"]["name"],$user);


		}

		return "";

	
    } 






}




?>

