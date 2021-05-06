<?php

class Appointment {

	private $servername = "localhost";
    private $username = "root";
    private $password ="";
    private $database ="animalmartdatabase";

    public $target_dir = "Images/";  
    public $con;

    // Create connection string (Database connection)
    public function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if(mysqli_connect_error())
        {
            trigger_error("Not possible to connect to MySQL: ".mysqli_connect_error());
        }
        else
        {
            return $this->con;
        }
    }

    // to edit
    function getAppointmentsByUsername($user_name){
    	$query = "SELECT * FROM appointments";
        $result = $this->con->query($query);
         if($result->num_rows > 0)
        {
            $data = array();
            while($row = $result->fetch_assoc())
            {
                $data[] = $row;
            }
            return $data;
        }
    }

	public function createAppointment(){
        $query = "INSERT INTO appointments (appointment_datetime, appointment_expiry, pet_id, service_id, employee_id) VALUES ('2021-7-23','2021-7-26', '1', '2', '1');";
        $sql = $this->con->query($query);
        if($sql == true)
	    {
	    	return 1;
	    }
	    else{
	    	return 0;
	    } 
    }


    public function updateAppointment(){

    }

    // public function deleteAppointment(){

    // }

    // public function searchPastAppointments(){

    // }

    // public function searchUpcomingAppointments(){

    // }
}
?>