<?php
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php'); //Database
function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
      header('Location: ' . $url);
      die();
    }    
}
$id = $_GET['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");

if (strlen($id) > 25){
	die('refer is to long.');
}else if (strlen($id) < 24){
	die('refer is to short.');
}//End(0)


//Check if report already exists
try{
	//Count
	$numReports = $dbc->prepare("SELECT count(*) FROM reports WHERE ID LIKE '%".$id."%'");
	$numReports ->execute();
	$numReports = $numReports->fetchColumn();
	if ($numReports >= 1){
		die("<script>setTimeout(function () { window.location.href= 'http://musicani.me';},5000);</script>Report for this anime/song has already been sent.");
	}
}catch(PDOException $e){
	die('Error:Failed to Establish Query.');
}//End(0)
$i = 0;
$anime = 0;
//Check if song exists
try{
	//Count
	$songReports = $dbc->prepare("SELECT count(*) FROM songs WHERE ID LIKE '%".$id."%'");
	$songReports ->execute();
	$songReports = $songReports->fetchColumn();
	if ($songReports == 0){
		$i = 2;
	}
}catch(PDOException $e){
	die('Error:Failed to Establish Query.');
}//End(0)
//Check if anime exists
try{
	//Count
	$animeReports = $dbc->prepare("SELECT count(*) FROM shows WHERE ID LIKE '%".$id."%'");
	$animeReports ->execute();
	$animeReports = $animeReports->fetchColumn();
	if ($animeReports == 0){
		$i = 2;
	}else{
		$anime = 1;
	}
}catch(PDOException $e){
	die('Error:Failed to Establish Query.');
}//End(0)


//if(!isset($_COOKIE['session'])) {
//   redirect("http://musicani.me/account/login.php?id=Login to report!");
//} else {
    //-]Create Query for Warning usage.
//    try{
//        //Query
//        $queryTokens = $dbc->prepare("SELECT * FROM session WHERE ip LIKE '%".$ip."%'");
//        $queryTokens->execute();
//        $times = $queryTokens->fetchColumn(2);
//                //Query
//        $queryUser = $dbc->prepare("SELECT * FROM session WHERE ip LIKE '%".$ip."%'");
//        $queryUser ->execute();
//        $user = $queryUser ->fetchColumn(0);
//        //Count
//       $numTokens = $dbc->prepare("SELECT count(*) FROM session WHERE ip LIKE '%".$ip."%'");
//        $numTokens->execute();
//        $numTokens = $numTokens->fetchColumn();
//    }catch(PDOException $e){
//        die('Error:Failed to Establish Query.');
//    }//End(1)
   //Check Token
//if ($numTokens == 0){
//    unset($_COOKIE['session']);
//    $res = setcookie('session', '', time() - 3600);
//    redirect("http://musicani.me/account/login.php?id=Session Not Found.");
//}else if ($numTokens == 1){
//    $result = date("Y-m-d H:i:s", strtotime($times) + 60*25);
// 
//    if ($result > $nowtime){    
//   }else{
//       unset($_COOKIE['session']);
//        $res = setcookie('session', '', time() - 3600);
//        redirect("http://musicani.me/account/login.php?id=Session Timed Out.");
//    }//End(1)
//}//End(0)
// try{
//        //Update Session
//        $queryUpdate = $dbc->prepare("UPDATE session SET lastuse='$nowtime' WHERE ip LIKE '%".$ip."%'");
//        $queryUpdate->execute();
//    }catch(PDOException $e){
//        die('Error:Failed to Establish Query.');
//    }//End(1)

if ($i != 4){
	try{
		$qryAddUser = $dbc->prepare("INSERT INTO reports (anime, username, id, date, status) VALUES ('$anime', '$user', '$id', '$nowtime', 'New Report')");
		$qryAddUser->execute();
		die("<script>setTimeout(function () { window.location.href= 'http://musicani.me';},5000);</script><p id='bigp'>
Report sent. Thanks for the support, the admins will look over the issue.
If the anime has no songs please don't report it with out looking at it's MAL Page. Thank you.</p>");
	}catch(PDOException $e){
			die('Error:Failed to create request.'.$e);
	}//End(0)
//}
}
?>
