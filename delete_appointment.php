<?php
include './controller/controller_appointments.php';
session_start();

if(isset($_GET['appt_id'])){
	  $val = $app->deleteAppointment($_GET['appt_id']);
	    if($val == 1){
	    	header("location: ./user_profile.php");
	    }
}

?>