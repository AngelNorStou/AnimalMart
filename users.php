<?php
session_start();
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

    // Get data account by email.
    public function displayRecordByUsername($username)
    {     
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data;
        }
        else{
            echo "Account not found";
        }       
    }

    // Verifies if the email and password match in the system
    public function login($postData)
    {

        $username = $this->con->real_escape_string($_POST['login_username']); 
        $email = $this->con->real_escape_string($_POST['login_email']);
        $password = $this->con->real_escape_string($_POST['login_password']);          
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND username = '$username'";
        $sql = $this->con->query($query);
        if($sql->num_rows > 0)
        {
           
            echo "You have logged in!";
        }
        else{
            echo "Not match found!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;           
        } 
    }

    // Inserts a new user into the database.
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

    // Updates a user from the database
    public function updateUser($postData)
    {

        $firstname = $this->con->real_escape_string($_POST['ufirstname']);
        $lastname = $this->con->real_escape_string($_POST['ulastname']); 
        $username = $this->con->real_escape_string($_POST['uusername']); 

        $email = $this->con->real_escape_string($_POST['uemail']);
        $password= $this->con->real_escape_string($_POST['upassword']);

        $city = $this->con->real_escape_string($_POST['ucity']);        
        $phone= $this->con->real_escape_string($_POST['uphone']);

 
        $query = " UPDATE users SET  first_name = '$firstname', last_name = '$lastname',  email = '$email', password = '$password',city = '$city', phone_number = '$phone' WHERE username = '$username'";

        $sql = $this->con->query($query);
        if($sql == true)
        {
            echo "Update successful!"."<br>";
        }
        else{
            echo "Update failed, please try again!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    }    


}





?>