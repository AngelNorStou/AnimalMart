<?php

class Message{

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

    public function displayMessages(){
    	$query = "SELECT * FROM messages";
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

    public function insertMessage($postdata){
    	
    	$firstname = $this->con->real_escape_string($_POST['firstname']);
        $lastname = $this->con->real_escape_string($_POST['lastname']); 
        $email = $this->con->real_escape_string($_POST['email']);        
        $phone= $this->con->real_escape_string($_POST['phone']);
        $message = $this->con->real_escape_string($_POST['message']);
       	$timestamp = $this->con->real_escape_string($_POST['timestamp']);
 
        $query = " INSERT INTO messages (first_name, last_name, email, phone_number, message_body, message_timestamp) VALUES ('$firstname','$lastname', '$email', '$phone', '$message' , '$timestamp')";
        $sql = $this->con->query($query);

        if($sql == true)
        {
            return 1;
        }
        else{
            return 0;
        }
    }

    public function deleteMessage($id){
        $query = "DELETE FROM messages WHERE message_id = '$id'";
        $sql = $this->con->query($query);
        if ($sql == true){
            return 1;
        }
        else{
            return 0;   
        }
    }
}

?>