<?php
include './controller/controller_appointments.php';
session_start();

$appointments = new ControllerAppointment();

$delete = $appointments->delete($_GET['appt_id']);
if($delete == 1){
   	header("location: ./user_profile.php");
}

?>