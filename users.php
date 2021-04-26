<?php

// Create the class Customers
class Users
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

    // Verifies if the email and password match in the system
    public function login($postData)
    {

        $email = $this->con->real_escape_string($_POST['vemail']);
        $password= $this->con->real_escape_string($_POST['vpassword']);          
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $sql = $this->con->query($query);
        if($sql->num_rows > 0)
        {
            header("Location:user_profile.php");
        }
        else{
            echo "Not match found!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;           
        } 
    }

    public function insertUser($postData,$fileData)
    {

        $firstname = $this->con->real_escape_string($_POST['firstname']);
        $lastname = $this->con->real_escape_string($_POST['lastname']); 
        $username = $this->con->real_escape_string($_POST['username']); 

        $email = $this->con->real_escape_string($_POST['email']);
        $password= $this->con->real_escape_string($_POST['password']);

        $city = $this->con->real_escape_string($_POST['city']);        
        $phone= $this->con->real_escape_string($_POST['phone']);

        $picture =  $this->target_dir.basename($_FILES['profilepic']['name']); 
 
        $query = " INSERT INTO users(first_name, last_name, username, email, password, city, phone_number,profile_picture) VALUES ('$firstname','$lastname', '$username', '$email', '$password', '$city', '$phone','$picture')";
        $sql = $this->con->query($query);
        if($sql == true)
        {
            header("Location:user_profile.php");
        }
        else{
            echo "Registration failed, please try again!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    }


}





?>