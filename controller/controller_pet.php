<?php


class ControllerPet
{
	public $petObj ;

    public function __construct(Pets $pet)
    {
    	//Set connection
        $this->petObj = $pet;
    }

    public function verify_addPet($post)
    {
		  if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {

		  	if ( ( is_numeric($_POST['size']) !== true) or ( is_numeric($_POST['weight']) !== true) or
		  		 ( is_numeric($_POST['age']) !== true) ) 
			{

				return "The pet's size, weight or age must be a number.";
			}

		    $this->petObj->insertPet($_POST);
		  }

		  return "";


    }





}




?>

