<?php

include './model/messages.php';
date_default_timezone_set("America/New_York");  // sets timezone for timestamp

class ControllerMessage{

	public $messageObj;

	public function __construct()
    {
    	if(session_id() == ''){
		    //session has not started
		    session_start();
		}

    	//Set connection
        $this->messageObj = new Message();
    }

    public function display(){
	$messages = $this->messageObj->displayMessages();
	return $messages;
    }

    public function insert($post){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {
		  	// if the form is submitted, and all data required is entered, insert into db
			if(isset($_POST['submit'], $_POST['firstname'],$_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['message'])){
				
				$newMessage = $this->messageObj->insertMessage($_POST);
				if($newMessage == 1){ // if the insertion was successful
					header("Location: Home.php");
				}
			}
		  }
    }

    public function delete($post){
    // if the message is deleted, delete from db
			if (isset($_GET['deleteMessage'])) {
			$message = $this->messageObj->deleteMessage($_GET['deleteMessage']);
				if($message == 1){ // if deletion was successful
					header("Location: admin_profile.php");
				}
			
    }
}

}


?>