<?php

class ViewUser
{
	public $userObj ;

    public function __construct(Users $user_obj)
    {

    	$this->userObj = $user_obj;
        
    }

    public function displayItem($get,$item)
    {
    	
    	$user =  $this->userObj->displayRecordByUsername($get);

		$label = "<label>".$user[$item]."</label>";

		return $label;
    }




}




?>

