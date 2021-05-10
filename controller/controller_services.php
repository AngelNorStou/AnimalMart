<?php
include './model/model_services.php';

class ControllerService{

	public $serviceObj;

    public function __construct()
    {
    	if(session_id() == ''){
		    //session has not started
		    session_start();
		}

    	//Set connection
        $this->serviceObj = new Service();
    }

   // New functions below...

    // View
    public function getServices($service_type,$min, $max)
    {
     	$services = $this->serviceObj->getServices($service_type,$min, $max);
    	return $services;   	
    }

    // Model
    private function getHighestCount()
    {
     	$grooming = $this->serviceObj->getNumOfServices("grooming");
     	$training = $this->serviceObj->getNumOfServices("training");
     	$vet = $this->serviceObj->getNumOfServices("vet");

     	return max($grooming,$training,$vet);
    }


    // Model
    private function getNumberOfPages($results_per_page)
    {
    	$highest = $this->getHighestCount();

    	$count = 0;

    	if (($highest % $results_per_page) != 0)
    	{
    		$count = floor($highest / $results_per_page) + 1;	
    	}
    	else
    	{
    		$count = $highest / $results_per_page ;
    	}

    	return $count;

    }


    // View
    public function displayPagination($results_per_page)
    {

    	$number_of_page = $this->getNumberOfPages($results_per_page);

    	$html = "<nav> <ul class=\"pagination\">";

	     for($page = 1; $page<= $number_of_page; $page++) 
	     {  
	     	$html .= "<li class=\"page-item\"><a class=\"page-link\" href=\"services.php?page=". $page
	     			 . "\">".$page."</a></li>" ;
	     }

	     $html .= "</ul></nav>";

	     return $html;
  	
    }
   

    // From orginal sources.


    public function displayAllServices(){
    	$services = $this->serviceObj->displayService();
    	return $services;
    }

    public function getServiceId(){

		if(isset($_GET['service'])) 
		 {
			$service = $this->serviceObj->displayServiceById($_GET['service']);
			return $service;
		}
    }

    public function addService($post){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {
	  	  	if(isset($_POST['addService'],$_POST['service_type']))
			{
			    $val = $this->serviceObj->addService($_POST);
			    if($val == 1){
			    	header("Location: services.php");
			   	}
			}
		}
    }

    public function editService($post){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {
	    	if (isset($_POST['editService'], $_POST['service_id'], $_POST['name'], $_POST['price'])) {
				$edit_service = $this->serviceObj->editService($_POST);
				if($edit_service == 1){
					header("Location: services.php");
				}
			}
		}
    }

    public function deleteService($id){
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
		  {
	    	if (isset($_POST['deleteService'])) {
				$service = $this->serviceObj->deleteService($_POST['service_id']);
				if($service == 1){
					header("Location: services.php");
				}
			}
		}
    }

    public function serviceType(){
    	$type = $this->serviceObj->getServiceType();
    	return $type;
    }

    public function search(){
    	if(isset($_GET['searchInput'])) 
		 {
			$searchServices = $this->serviceObj->searchServices($_GET['searchInput']);
			return $searchServices;
		}
    }

}

?>