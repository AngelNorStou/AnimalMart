<?php

include './model/users.php';


class ViewPet
{
	public $petObj ;

    public function __construct(Pets pet_obj)
    {
    	//Set connection
        $this->petObj = $pet_obj;
        
    }

    public function displayPets($owner)
    {
        $pets = $this->petObj->displayPetsByUsername($owner);

        $label_start_tag = "<label  class=\"form-label card-text\">" ;

        $label_end_tag = "</label>";

        $html = "";

        foreach ($pets as $pet) 
        {
            $html = "<div class=\"card col\" style=\"width: 18rem;margin: 2%;\">    " .
                    "<div class=\"card-body\">".
                    "<div class=\"row\" style=\"margin-bottom: 3%;\">".

                    $label_start_tag."Name: ". $pet['pet_name']. $label_end_tag.
                    $label_start_tag."Type: ". $pet['pet_type']. $label_end_tag.
                    $label_start_tag."Breed: ". $pet['breed']. $label_end_tag.
                    $label_start_tag."Gender: ". $pet['gender']. $label_end_tag.
                    $label_start_tag."Size: ". $pet['size']. $label_end_tag.
                    $label_start_tag."Weight: ". $pet['weight']. $label_end_tag.
                    $label_start_tag."Age: ". $pet['age']. $label_end_tag.

                    "</div> ".

                    "<a class=\"btn btn-primary\" href=\"edit_pet.php?petEdit=". $pet['pet_id'] ." \">Edit</a> ".

                    "</div></div> " ;
        }       
    	

		return $html;
    }




}




?>

