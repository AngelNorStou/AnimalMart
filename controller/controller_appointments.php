<?php

include './model/model_appointment.php';


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

    public function getAppointments($username){
    	$app = $this->appointmnetObj->getAppointmentsByUsername($username);
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
				$appointment = $this->appointmnetObj->getAppointmentsById($_GET['appt_id']);
				return $appointment;
			}
		
    }

    public function editAppointment($post){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {
    	// edit appointment
		if(isset($_POST['editAppointment'])){
			$appointment = $this->appointmnetObj->updateAppointment($_POST);
			if($appointment == 1){
				header("Location: user_profile.php");
			}
		}
    	}
	}

	public function delete($id){
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		  {
	    	if (isset($_GET['appt_id'])) {
				$service = $this->appointmnetObj->deleteAppointment($id);
				if($service == 1){
					header("Location: user_profile.php");
				}
			}
		}
	}

}

?>