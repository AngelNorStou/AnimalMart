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

    public function getAppointmentsByUsername($username){

    	$query = "SELECT * FROM appointments WHERE pet_id IN (SELECT pet_id FROM pets WHERE user_id IN (SELECT user_id FROM users WHERE username = '$username'))";
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

    public function getAppointmentsById($id){

        $query = "SELECT * FROM appointments WHERE appointment_id = '$id'";
        $result = $this->con->query($query);
        if($result->num_rows> 0){
            $data = $result->fetch_assoc();           
            return $data;
        }  
    }

	public function createAppointment($post){

        $date = $this->con->real_escape_string($_POST['appointment_datetime']);
        $name = $this->con->real_escape_string($_POST['name']);
        $desc = $this->con->real_escape_string($_POST['desc']);
        $length = $this->con->real_escape_string($_POST['length']);
        $price = $this->con->real_escape_string($_POST['price']);

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


    public function updateAppointment($post){

        $date = $this->con->real_escape_string($_POST['appointment_datetime']);
        $pet = $this->con->real_escape_string($_POST['pet']);
        $service = $this->con->real_escape_string($_POST['service']);

        $query = "UPDATE appointments SET appointment_datetime = '$date', pet_id = '$pet', service_id = '$service' WHERE appointment_id = '$id'";
        $sql = $this->con->query($query);
        if($sql == true)
        {
            return 1;
        }
        else{
            return 0;
        } 
    }

    public function deleteAppointment($id){
        $query = "DELETE FROM appointments WHERE appointment_id = '$id'";
        $sql = $this->con->query($query);
        if ($sql == true){
            return 1;
        }
        else{
            return 0;   
        }
    }

    public function searchPastAppointments($id){

    }

    public function searchUpcomingAppointments($id){

    }
}
?>