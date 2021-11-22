<?php

//Enables us to use headers-keeps an eye on outout buffering
ob_start();

//set sessions Allows us to save data for our application
if(!isset($_SESSION)) {
	session_start();
}

$hostname = "localhost";
$username = "root";
$password = "steelers01";
$dbname = "users";

$connection = @mysqli_connect($hostname, $username, $password, $dbname) or die ("Databse connection not established");

?>