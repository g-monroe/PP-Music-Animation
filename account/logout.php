<?php
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('../php/server/cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php');

function stmt_bind_assoc (&$stmt, &$out) {
    $data = mysqli_stmt_result_metadata($stmt);
    $fields = array();
    $out = array();

    $fields[0] = $stmt;
    $count = 1;

    while($field = mysqli_fetch_field($data)) {
        $fields[$count] = &$out[$field->name];
        $count++;
    }    
    call_user_func_array(mysqli_stmt_bind_result, $fields);
}
// $url should be an absolute url
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

if(!isset($_COOKIE['session'])) {
    redirect("http://musicani.me/account/register.php");
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
        $dltTokens = $dbc->prepare("DELETE FROM session WHERE  ip LIKE '%".$ip."%'");
    $dltTokens->execute();
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
    unset($_COOKIE['session']);
    setcookie('session', false, time() - 60*100000, '/');
    $res = setcookie('session', '', time() - 3600);
    redirect("http://musicani.me/account/login.php?id=Successfully Logged out!");
}
?>