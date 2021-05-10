<?php 

class Service{
    private $servername = "localhost";
    private $username = "root";
    private $password ="";
    private $database ="animalmartdatabase";

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

    public function displayService()
    {     
        $query = "SELECT * FROM services";
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

   public function getNumOfServices($type){
        $query = "SELECT COUNT(*) AS total FROM services WHERE service_type = '$type'";
        $result = $this->con->query($query);
      if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data['total'];
        }  
    }

    public function getServices($min, $max)
    {

    //retrieve the selected results from database   
    //$query = "SELECT * FROM services WHERE service_type = '$service_type' LIMIT " . $min . ' OFFSET ' . $max; 
        $query = "SELECT * FROM services LIMIT " . $min . ' OFFSET ' . $max;
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
        else{
            return null;
        } 
    }

    public function getServiceType(){
        $query = "SELECT DISTINCT service_type FROM services";
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

    public function displayServiceById($id){
       $query = "SELECT * FROM services WHERE service_id = '$id'";
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data;
        }  
    }

    public function addService($post){

        $type = $this->con->real_escape_string($_POST['service_type']);
        $name = $this->con->real_escape_string($_POST['name']);
        $desc = $this->con->real_escape_string($_POST['desc']);
        $length = $this->con->real_escape_string($_POST['length']);
        $price = $this->con->real_escape_string($_POST['price']);

        $query = "INSERT INTO services (service_type, service_name, service_description, service_length, service_price) VALUES ('$type', '$name', '$desc', '$length', '$price')";
        $sql = $this->con->query($query);
        if($sql == true)
        {
           return 1;
        }
        else{
            return 0;
        }
        
    }

    public function editService($post){

        $name = $this->con->real_escape_string($_POST['name']);
        $desc = $this->con->real_escape_string($_POST['desc']);
        $length = $this->con->real_escape_string($_POST['length']);
        $price = $this->con->real_escape_string($_POST['price']); 
        $id = $this->con->real_escape_string($_POST['service_id']);

        $query = " UPDATE services SET service_name = '$name', service_description = '$desc', service_length = '$length', service_price = '$price'  WHERE service_id = '$id' ";

        $sql = $this->con->query($query);
        if ($sql == true){
            return 1;
        }
        else{
            return 0;
        }
    }

    public function deleteService($id){
        $query = "DELETE FROM services WHERE service_id = '$id'";
        $sql = $this->con->query($query);
        if ($sql == true){
            return 1;
        }
        else{
            return 0;   
        }
    }

    public function searchServices($string){
        $query = "SELECT * FROM services WHERE service_name LIKE '%$string%'";
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
}
?>