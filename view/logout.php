<?php
Session_start();
unset($_SESSION['username']);
unset($_SESSION['isAdmin']);
Session_destroy();
header('Location: Home.php');

?>