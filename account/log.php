<?php
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('../php/server/cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php');
function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
      header('Location: ' . $url);
      die();
    }    
}
$user = $_POST['user'];
$pass = $_POST['pass'];
$captcha=$_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");
if (strlen($user) > 26){
	redirect("http://musicani.me/account/login.php?id=Username too Long.");
}elseif (strlen($user) < 3){
	redirect("http://musicani.me/account/login.php?id=Username too short.");
}
if (strlen($pass) > 48){
	redirect("http://musicani.me/account/login.php?id=Password too Long.");
}elseif (strlen($pass) < 7){
	redirect("http://musicani.me/account/login.php?id=Password too short.");
}
//Check if user exists
try{
	//Count
	$numUsers = $dbc->prepare("SELECT count(*) FROM accounts WHERE username LIKE '%".$user."%' OR email LIKE '%".$user."%'");
	$numUsers->execute();
	$numUsers = $numUsers->fetchColumn();
	if ($numUsers != 1){
		redirect("http://musicani.me/account/login.php?id=User doesn't exists.");
	}
}catch(PDOException $e){
	die('(1)Error:Failed to Establish Query.');
}//End(0)
/* Check if captcha is filled */
if (!$captcha) {
redirect("http://musicani.me/account/login.php?id=Bad Captcha.");
}
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lcvng8UAAAAAL0cl19rYPILxx39ZuAo8_1kHtBm&amp;amp;response=" . $captcha);
if ($response . success == false) {
redirect("http://musicani.me/account/login.php?id=Bad Captcha.");
} else {

//Grab Required User
try{
	$qryUsers = $dbc->prepare("SELECT * FROM accounts WHERE email LIKE '%".$user."%' OR username LIKE '%".$user."%'");
	$qryUsers->execute();
	$hash = $qryUsers->fetchColumn(2);

	$qrybanned = $dbc->prepare("SELECT * FROM accounts WHERE email LIKE '%".$user."%' OR username LIKE '%".$user."%'");
	$qrybanned->execute();
	$banned = $qrybanned->fetchColumn(6);
	if ($banned == 1){
		redirect("http://musicani.me/account/login.php?id=Banned.");
	}
}catch(PDOException $e){
	die('(2)Error:Failed to Establish Query.');
}//End(0)
//Password
if (!password_verify($pass, $hash)) {
	redirect("http://musicani.me/account/login.php?id=Wrong Password.");
}//End(0)
//Create User
try{
	try{
	//Delete Old tokens
	$dltTokens = $dbc->prepare("DELETE FROM session WHERE username LIKE '%".$user."%' OR ip LIKE '%".$ip."%'");
	$dltTokens->execute();
}catch(PDOException $e){
	die('(3)Error:Failed to Establish Query.');
}//End(0)
	//Make a new code.
$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charsLength = strlen($chars);
$code = '';
for ($i = 0; $i < 25; $i++) {
    $code .= $chars[rand(0, $charsLength - 1)];
}//End(0)
	$qryAddSession = $dbc->prepare("INSERT INTO session (username, token, LastUse, ip) VALUES ('$user', '$code', '$nowtime', '$ip')");
	$qryAddSession->execute();
	setcookie("session", $code, time()+3600 , '/' );
	redirect("http://musicani.me/account/");
}catch(PDOException $e){
	die('Error:Failed to create request.');
}//End(0)

}


?>
