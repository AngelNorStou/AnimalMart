<?php
Session_start();
unset($_SESSION['username']);
unset($_SESSION['isAdmin']);
header('Location: Home.php');

?>