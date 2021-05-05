<?php

include 'database.php';

function test(){
	return 1;
}
    function getAppointmentsByUsername($user_name){
    	$query = "SELECT * FROM appointments WHERE username = '$user_name'";
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data;
        }
        else{
            return 0;
        }     
    }

    // to update : user should be here??
    function createAppointment($data){
    	$appointment_date = $this->con->real_escape_string($appointment_datetime);
		$pet_id =  $this->con->real_escape_string($pet);
		$service_id =  $this->con->real_escape_string($service);

    	$query = " INSERT INTO appointments(appointment_datetime, appointment_expiry, pet_id, service_id, employee_id) 
    					VALUES ('$appointment_date','$appointment_date', '$pet_id', '$service_id', 1)";
        $sql = $this->con->query($query);
        if($sql == true)
        {
           return 1;
        }
        else{
           return 0;
        }
    }

    function updateAppointment($postData){
    	$appointment_datetime = $this->con->real_escape_string($_POST['appointment_datetime']);
        $appointment_expiry = $this->con->real_escape_string($_POST['appointment_expiry']); 
        $pet_id = $this->con->real_escape_string($_POST['pet_id']); 

        $service_id = $this->con->real_escape_string($_POST['service_id']);
        $employee_id = $this->con->real_escape_string($_POST['employee_id']);

 
        $query = " UPDATE appointments SET  appointment_datetime = '$appointment_datetime', appointment_expiry = '$appointment_expiry',  
                                     pet_id = '$pet_id', service_id = '$service_id', employee_id = '$employee_id' 
                    WHERE appointment_id = '$appointment_id'";

        $sql = $this->con->query($query);
        if($sql == true)
        {
           return 1;
        }
        else{
            return 0;
        }
    }

    // public function deleteAppointment(){

    // }

    // public function searchPastAppointments(){

    // }

    // public function searchUpcomingAppointments(){

    // }

?>