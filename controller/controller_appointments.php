<?php

include './model/model_appointment.php';
date_default_timezone_set("America/New_York");

class ControllerAppointment{

	public $appointmnetObj;

    public function __construct()
    {
    	if(session_id() == ''){
		    //session has not started
		    session_start();
		}

    	//Set connection
        $this->appointmnetObj = new Appointment();
    }

    public function getAppointments(){
    	$app = $this->appointmnetObj->getAppointmentsByUsername($_SESSION['username']);
    	return $app;
    }

    public function insert(){
    	 // Insert Record in appointments table
		if(isset($_POST['submit']))
		{
		    $val = $app->createAppointment($_POST);
		    if($val == 1){
		    	header("location: ./user_profile.php");
		    }
		}
    }

    public function getAppById(){
    	if(isset($_GET['appt_id'])) 
		 {
			$appointment = $app->getAppointmentsById($_GET['appt_id']);
		}

    }

    public function editAppointment(){
    	// edit appointment
		if(isset($_POST['editAppointment'])){
			$appointment = $app->updateAppointment($_POST);
			if($appointment == 1){
				header("Location: user_profile.php");
			}
		}
    }

}

?>