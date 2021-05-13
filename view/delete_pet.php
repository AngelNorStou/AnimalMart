<?php
include '../model/pets.php';
session_start();

$pets = new Pets();

$delete = $pets->deletePet($_GET['petDelete']);
if($delete == 1){
	header("location: user_profile.php?login=".$_SESSION['username']);
}

?>