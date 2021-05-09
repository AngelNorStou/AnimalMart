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








}




?>

