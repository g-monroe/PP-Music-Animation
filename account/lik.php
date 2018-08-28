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

$id = $_GET['id'];
$mention = $_GET['mention'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");

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
    setcookie('session', false, time() - 60*100000, '/');
    $res = setcookie('session', '', time() - 3600);
    redirect("http://musicani.me/account/login.php?id=Session Not Found.");
}else if ($numTokens == 1){
    $result = date("Y-m-d H:i:s", strtotime($times) + 60*25);
 
    if ($result > $nowtime){    
    }else{
       unset($_COOKIE['session']);
        setcookie('session', false, time() - 60*100000, '/');
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
     try{
        //Grab Name
        if (isset($mention)){
        $querySong = $dbc->prepare("SELECT * FROM Mentions WHERE id LIKE '%".$id."%'");
        $querySong->execute();
        $songname = $querySong->fetchColumn(1);

        $querySong = $dbc->prepare("SELECT * FROM Mentions WHERE id LIKE '%".$id."%'");
        $querySong->execute();
        $songytid = $querySong->fetchColumn(6);
    }else{
        $querySong = $dbc->prepare("SELECT * FROM songs WHERE id LIKE '%".$id."%'");
        $querySong->execute();
        $songname = $querySong->fetchColumn(1);

        $querySong = $dbc->prepare("SELECT * FROM songs WHERE id LIKE '%".$id."%'");
        $querySong->execute();
        $songytid = $querySong->fetchColumn(6);
    }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.' .$e);
    }//End(1)

try{
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM likes WHERE songid LIKE '%".$id."%' AND username LIKE '%".$user."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM > 0){
        	$qrydelete = $dbc->prepare("DELETE FROM likes WHERE songid='".$id."' AND username='".$user."'");
            $qrydelete->execute();
            if (isset($mention)){
                redirect("http://musicani.me/account/");
            }else{
                redirect("http://musicani.me/account/");
            }
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.' .$e);
    }//End(1)
    try{
	$qryAddSession = $dbc->prepare("INSERT INTO `likes`(`username`, `songID`, `Name`, `youtubeid`) VALUES ('$user', '$id', '$songname', '$songytid')");
	$qryAddSession->execute();
	if (isset($mention)){
                redirect("http://musicani.me/account/");
            }else{
                redirect("http://musicani.me/account/");
            }
}catch(PDOException $e){
	die('Error:Failed to create request.' .$e);
}//End(0)
}
?>
