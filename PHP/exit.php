<?php
if (!isset($_SESSION))
	session_start();
unset($_SESSION['user']);
include('index.php');
?>