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
		    	$this->userObj->isAdmin($_POST['login_username']);

		    	return "";
		    }
		    else
		    {
		    	return "Not match found in our database. Please create an account." ;
		    }


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




}




?>

