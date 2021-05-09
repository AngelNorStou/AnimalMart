<?php

include './model/messages.php';

date_default_timezone_set("America/New_York"); // sets timezone for timestamp

// create message obj
$messageObj = new Message();
$messages = $messageObj->displayMessages();

// if the form is submitted, and all data required is entered, insert into db
if(isset($_POST['submit'], $_POST['firstname'],$_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['message'])){
	
	$newMessage = $messageObj->insertMessage($_POST);
	if($newMessage == 1){ // if the insertion was successful
		header("Location: Home.php");
	}
}

// if the message is deleted, delete from db
if (isset($_GET['deleteId'])) {
	$message = $messageObj->deleteMessage($_GET['deleteId']);
	if($message == 1){ // if deletion was successful
		header("Location: admin_profile.php");
	}
}

?>