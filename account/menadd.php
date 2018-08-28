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
function checkRemoteFile($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==FALSE)
    {
        return true;
    }
    else
    {
        return false;
    }
}
$id = $_GET['id'];
$song = $_POST['song'];
$op = $_POST['op'];
$ytid = $_POST['ytid'];
$captcha=$_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");

if (strlen($song) > 48){
	redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Song Name is too long.");
}elseif (strlen($song) < 12){
	redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Song Name is too short.");
}
if (@getimagesize('https://i.ytimg.com/vi/'.$ytid.'/mqdefault.jpg')) {
	}else{
		redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Youtube video doesn't exist.");
	}
	if(!isset($_COOKIE['session'])) {
    redirect("http://musicani.me/account/login.php");
} else {
    //-]Create Query for Warning usage.
    try{
        //Query
        $queryTokens = $dbc->prepare("SELECT * FROM session WHERE ip LIKE '%".$ip."%'");
        $queryTokens->execute();
        $times = $queryTokens->fetchColumn(2);
                //Query
        $queryUser = $dbc->prepare("SELECT * FROM session WHERE ip LIKE '%".$ip."%'");
        $queryUser ->execute();
        $user = $queryUser ->fetchColumn(0);
        //Count
        $numTokens = $dbc->prepare("SELECT count(*) FROM session WHERE ip LIKE '%".$ip."%'");
        $numTokens->execute();
        $numTokens = $numTokens->fetchColumn();
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
   //Check Token
if ($numTokens == 0){
    unset($_COOKIE['session']);
    $res = setcookie('session', '', time() - 3600);
    redirect("http://musicani.me/account/login.php?id=Session Not Found.");
}else if ($numTokens == 1){
    $result = date("Y-m-d H:i:s", strtotime($times) + 60*25);
 
    if ($result > $nowtime){    
    }else{
        unset($_COOKIE['session']);
        $res = setcookie('session', '', time() - 3600);
        redirect("http://musicani.me/account/login.php?id=Session Timed Out.");
    }//End(1)
}//End(0)
 try{
        //Update Session
        $queryUpdate = $dbc->prepare("UPDATE session SET lastuse='$nowtime' WHERE ip LIKE '%".$ip."%'");
        $queryUpdate->execute();
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)

if (!$captcha) {
redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Bad Captcha.");
}
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lcvng8UAAAAAL0cl19rYPILxx39ZuAo8_1kHtBm&amp;amp;response=" . $captcha);
if ($response . success == false) {
redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Bad Captcha.");
} else {
  //-]Create Query for Mentions
    try{
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM Mentions WHERE youtubeid LIKE '%".$ytid."%' AND showid LIKE '%".$id."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM >= 1){
        	redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Mention already exists.");
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
    try{
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM Mentions WHERE youtubeid LIKE '%".$ytid."%' AND showid LIKE '%".$id."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM >= 1){
        	redirect("http://musicani.me/account/mention.php?id=".$id."&erid=Mention already exists.");
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
        try{
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM Mentions WHERE youtubeid LIKE '%".$ytid."%' AND username LIKE '%".$user."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM >= 1){
        	redirect("http://musicani.me/account/mention.php?id=".$id."&erid=You have already Mentioned this before!");
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
    try{
    		//Make a new code.
$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charsLength = strlen($chars);
$code = '';
for ($i = 0; $i < 25; $i++) {
    $code .= $chars[rand(0, $charsLength - 1)];
}//End(0)
	$qryAddSession = $dbc->prepare("INSERT INTO Mentions (ID, Name, showID, opening, start, end, youtubeid, username, date) VALUES ('$code', '$song', '$id', '$op', '0', '0', '$ytid', '$user', '$nowtime')");
	$qryAddSession->execute();
	setcookie("session", $code);
	redirect("http://musicani.me/anime/?id=".$id);
}catch(PDOException $e){
	die('Error:Failed to create request.');
}//End(0)
}
}
?>
