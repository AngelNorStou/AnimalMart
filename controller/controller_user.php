<?php

class ControllerUser
{
	public $userObj ;

    public function __construct(Users $user_obj)
    {
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
		    	$isAdmin = $this->userObj->isAdmin($_POST['login_username']);

		    	if ($isAdmin)
		    	{
		    		header("Location:admin_profile.php?login=".$_POST['login_username']);
		    	}
		    	else
		    	{
		    		header("Location:user_profile.php?login=".$_POST['login_username']);
		    	}

		    	return "";
		    }
		    else
		    {
		    	return "Not match found in our database. Please create an account." ;
		    }
		}
	
    }

}




?>

