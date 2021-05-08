<?php

include 'pets.php';


class ControllerUser
{
	public $petObj ;

    public function __construct()
    {
    	//Set connection
        $this->petObj = new Pets();
    }


}




?>

