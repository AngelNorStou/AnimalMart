<?php


class ControllerEmployee
{
	public $empObj ;

    public function __construct(Employees $emp_obj)
    {
    	//Set connection

    	$this->empObj = $emp_obj;
    	
    }

    public function verify_delete($get)
    {

	  if(isset($_GET['deleteId']) ) 
	  {
	      $this->empObj->deleteEmp($_GET['deleteId']);
	      return "Employee successfully removed.";
	  }	

	  return "";

    }

    public function verify_addEmp($post, $user)
    {
  
        if($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $empObj->insertEmp($_POST, $user);
        }


    }        








}




?>

