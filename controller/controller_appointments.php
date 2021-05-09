<?php

include './model/model_appointment.php';

if(session_id() == ''){
    //session has not started
    session_start();
}

$app = new Appointment();

 // Insert Record in appointments table
	if(isset($_POST['submit']))
	{
	    $val = $app->createAppointment($_POST);
	    if($val == 1){
	    	header("location: ./user_profile.php");
	    }
	}

	if(isset($_GET['appt_id'])) 
 {
	$appointment = $app->getAppointmentsById($_GET['appt_id']);
}

// edit appointment
if(isset($_POST['editAppointment'])){
	$appointment = $app->updateAppointment($_POST);
	if($appointment == 1){
		header("Location: user_profile.php");
	}
}


?>