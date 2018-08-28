<?php
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php'); //Database 

$id = $_GET['id'];
$user = $_GET['user'];
$reason = $_GET['reason'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");

if (strlen($user) > 48){
	die('Username is to long.');
}else if (strlen($user) < 2){
	die('Username is to short.');
}//End(0)

if (strlen($id) > 10){
	die('ID is to long.');
}else if (strlen($user) < 1){
	die('ID is to short.');
}//End(0)

if (strlen($reason) > 255){
	die('Reason is to long.');
}else if (strlen($reason) < 25){
	die('Reason is to short.');
}//End(0)

if (!is_numeric($id)){
	die('ID is invalid.');
}//End(0)

//Check if user already exists
try{
	//Count
	$numUsers = $dbc->prepare("SELECT count(*) FROM requests WHERE ip LIKE '%".$ip."%' OR hfid LIKE '%".$id."%'");
	$numUsers->execute();
	$numUsers = $numUsers->fetchColumn();
	if ($numUsers >= 1){
		die('Request from ID or IP has already been sent.');
	}
}catch(PDOException $e){
	die('Error:Failed to Establish Query.');
}//End(0)

//Create User
try{
	$qryAddUser = $dbc->prepare("INSERT INTO requests (hfid, ip, username, reason, date) VALUES ('$id', '$ip', '$user', '$reason', '$nowtime')");
	$qryAddUser->execute();
	die("Request sent. Now all you have to do is wait for a PM.");
}catch(PDOException $e){
	die('Error:Failed to create request.');
}//End(0)
?>