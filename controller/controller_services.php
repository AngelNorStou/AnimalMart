<?php
include './model/model_services.php';

if(session_id() == ''){
    //session has not started
    session_start();
}


$serviceObj = new Service();
$services = $serviceObj->displayService();

if(isset($_GET['service'])) 
 {
	$service = $serviceObj->displayServiceById($_GET['service']);
}

if (isset($_POST['editService'], $_POST['service_id'], $_POST['name'], $_POST['price'])) {
	$edit_service = $serviceObj->editService($_POST);
	if($edit_service == 1){
		header("Location: services.php");
	}
}

if (isset($_POST['deleteService'])) {
	$service = $serviceObj->deleteService($_POST['service_id']);
	if($service == 1){
		header("Location: services.php");
	}
}

$type = $serviceObj->getServiceType();

	if(isset($_POST['addService'],$_POST['service_type']))
	{
	    $val = $serviceObj->addService($_POST);
	    if($val == 1){
	    	header("Location: services.php");
	    }
	}

?>