<?php



// Create the class Employees
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
        $query = "SELECT username, first_name, last_name, start_date, end_date 
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

    // Display Employees
    public function selectEmployee($user_name)
    {     
        $query = "SELECT start_date, end_date, isAdmin 
                    FROM employees WHERE user_id IN 
                                                (SELECT user_id FROM users WHERE username = '$user_name')";

        $result = $this->con->query($query);
        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();      
            return $data;
        }

      
    }    

    public function insertEmp($postData, $admin,$user_id)
    {

        $start_date = $_POST['emp_date']; 

        $isAdmin = $_POST['adminOption']; 

 
        $query = " INSERT INTO employees(user_id, start_date, isAdmin ) VALUES ('$user_id','$start_date', '$isAdmin')";

        $sql = $this->con->query($query);
        if($sql == true)
        {
            header("Location:admin_profile.php?login=".$admin);
        }
        else{
            echo "Registration failed, please try again!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    } 

   public function updateEmp($postData, $admin)
    {

        $user_name = $_POST['emp_editusername'];

        $start_date = $_POST['emp_date_start'];         

        $end_date = $_POST['emp_date_end'];

        $isAdmin = $_POST['adminOption']; 

 
        $query = " UPDATE employees SET start_date = '$start_date', 
                                        end_date = '$end_date', 
                                        isAdmin =  '$isAdmin'
                                        WHERE user_id IN 
                                                      (SELECT user_id FROM users WHERE username = '$user_name')";

        $sql = $this->con->query($query);
        if($sql == true)
        {
            header("Location:admin_profile.php?login=".$admin);
        }
        else{
            echo "Update failed, please try again!"."<br>";
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    }


    public function getUserId($user_name)
    {

        $query = "SELECT user_id FROM users WHERE username = '$user_name'";

        $sql = $this->con->query($query);

        if($sql->num_rows > 0) // if it exist
        {
            $data = $sql->fetch_assoc(); 

            echo $data['user_id'];

            return $data['user_id'];
        } 
        else{

            return null;

        }          

    }


    public function deleteEmp($user_name)
    {
        $id = $this->getUserId($user_name);
        $query = "DELETE FROM employees WHERE user_id = '$id'";
        $sql = $this->con->query($query);
        if($sql==true){
            echo "Record deleted sucessfully";
        }
        else{
            echo "Not possible to delete, please try again!";
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

/*
SELECT `employee_id`, `first_name`, `last_name`, `start_date`, `end_date` FROM `employees` INNER JOIN `users` ON ( `employees`.`user_id` = `users`.`user_id` AND `users`.`username` = 'sabpags') 


 */

?>

