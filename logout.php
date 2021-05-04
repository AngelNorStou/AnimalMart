<?php
Session_start();
Session_destroy();
header('Location: Home.php');

?>