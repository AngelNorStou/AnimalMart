<?php

include './model/messages.php';

date_default_timezone_set("America/New_York");

$messageObj = null;

$messageObj = new Message();
$messages = $messageObj->displayMessages();

// if the form is submitted, and all data required is entered, insert into db
if(isset($_POST['submit'])){
	
	$newMessage = $messageObj->insertMessage($_POST);
	if($newMessage == 1){ // if the insertion was successful
		header("Location: Home.php");
	}
}

if (isset($_GET['deleteId'])) {
	$message = $messageObj->deleteMessage($_GET['deleteId']);
	if($message == 1){
		header("Location: admin_profile.php");
	}
}

?>