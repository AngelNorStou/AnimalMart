<?php



// Create the class Customers
class Employees
{
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

    // Display Employees
    public function displayEmployees()
    {     
        $query = "SELECT employee_id, first_name, last_name, start_date, end_date 
                    FROM employees INNER JOIN users 
                      ON ( employees.user_id = users.user_id)";

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

    public function displayEmployee($employee_id)
    {     
        $query = "SELECT * FROM employees WHERE employee_id = '$employee_id'";

        $result = $this->con->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();           
            return $data;
        }
    }    
       

}

?>