<?php
//Initial Connection File; Very important to establish a secure connection befo ->
// -re any work is done.
if (!defined('auth_4M2ynM9DPv9x3We8_ForbiddenCheck')) {
    die('forbidden');
}

//Declare dbc as a mysql Database connection to the database named "kevin_gate" ->
// to overall perform required requests
try{
	$dbc = new PDO('mysql:host=localhost;dbname=kevin_gdi','kevin_admin','Qrsa-z75aaZi');
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die('Error:Failed to Establish Connection!');
}

//End of Document.
?>