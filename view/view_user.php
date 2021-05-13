<?php


class ViewUser
{
	public $userObj ;

    public function __construct(Users $user_obj)
    {

    	$this->userObj = $user_obj;
        
    }

    public function getId($user_name,$item)
    {
        
        $user =  $this->userObj->displayRecordByUsername($user_name);

        return $user[$item];
    }

    public function displayItem($user_name,$item)
    {
    	
    	$user =  $this->userObj->displayRecordByUsername($user_name);

		$label = "<label>".$user[$item]."</label>";

		return $label;
    }

    public function displayPictureSource($user_name)
    {
    	
    	$user =  $this->userObj->displayRecordByUsername($user_name);

    	$picture = "<img src=\"../" . $user['profile_picture'] . "\" class=\"img-thumbnail\" alt=\"No Picture Found.\">";


		return $picture;
    }    




}




?>

