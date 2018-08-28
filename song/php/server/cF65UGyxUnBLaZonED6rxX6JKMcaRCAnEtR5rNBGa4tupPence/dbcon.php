<?php
//Initial Connection File; Very important to establish a secure connection befo ->
// -re any work is done.
if (!defined('auth_4M2ynM9DPv9x3We8_ForbiddenCheck')) {
    die('forbidden');
}
$link = mysqli_connect("localhost", "p5g2n8w2_admin", "Qrsa-z75aaZi", "p5g2n8w2_gdi");

//Declare dbc as a mysql Database connection to the database named "kevin_gate" ->
// to overall perform required requests
try{
	$dbc = new PDO('mysql:host=localhost;dbname=p5g2n8w2_gdi','p5g2n8w2_admin','Qrsa-z75aaZi');
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die('Error:Failed to Establish Connection!');
}

//End of Document.
?>