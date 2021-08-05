<?php require 'projectconnect.php';
unset($_SESSION['user']);
unset($_SESSION['power']);
header("Location: http://localhost:31337/project/mainpage.php");
?>