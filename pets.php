<?php

// Create the class Customers
class Pets
{
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



    public function displayPetsByUsername($user_name)
    {
   
        $query = "SELECT * FROM pets WHERE user_id IN 
                    (SELECT user_id FROM users WHERE username = '$user_name')";
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

    public function displayPetById($id)
    {
   
        $query = "SELECT * FROM pets WHERE pet_id = '$id'";
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data;
        }

    }

     // Updates a user from the database
    public function updatePet($postData, $id)
    {

        $petname = $this->con->real_escape_string($_POST['edit_pet_name']);
        $type = $this->con->real_escape_string($_POST['edit_pet_type']); 
        $breed = $this->con->real_escape_string($_POST['edit_pet_breed']); 

        $gender = $this->con->real_escape_string($_POST['edit_pet_gender']);
        $size= $this->con->real_escape_string($_POST['edit_pet_size']);

        $weight= $this->con->real_escape_string($_POST['edit_pet_weight']);        
        $age= $this->con->real_escape_string($_POST['edit_pet_age']);

 
        $query = " UPDATE pets SET  pet_name = '$petname', pet_type = '$type', breed = '$breed',             gender = '$gender', size = '$size' , weight = '$weight', age = '$age'
                    WHERE pet_id = '$id' ";

        $sql = $this->con->query($query);
        if($sql == true)
        {
            $user_name = getUsername($id);  
            //echo   $user_name;
            header("Location:user_profile.php?login=".$user_name);
        }
        else{
            echo "Update failed, please try again!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    }

    public function getUsername($id)
    {
        $query = "SELECT DISTINCT username FROM users WHERE user_id IN 
                    (SELECT user_id FROM pets WHERE pet_id = '$id')";
        $result = $this->con->mysql_result($query);
        return  $result;  
    } 





}




?>