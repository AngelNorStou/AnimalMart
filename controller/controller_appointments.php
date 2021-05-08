<?php

include './model/model_appointment.php';

$app = new Appointment();

 // Insert Record in guest table
	if(isset($_POST['submit']))
	{
	    $val = $app->createAppointment($_POST);
	    if($val == 1){
	    	header("location: ./user_profile.php");
	    }
	}

?>