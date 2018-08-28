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
echo("<!DOCTYPE html>
<html>
    
    <head>
        <link href='css/main.css' type='text/css' rel='stylesheet'/>
        <link rel='icon' type='image/png' href='http://musicani.me/img/icon.png'>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title>Musicani - Listen. Watch. Enjoy.</title>
    </head>
    <body>
        <div id='navBar'>
            <a href='/' id='logo'class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a>
                <a class='arial white right navbarcenter' href='logout.php'>Log out</a>
        </div>
        <form id='main'>
        <div id='Header'>
            <a href='/' id='formlogo' class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a><h3>Mentions</h3>
        </div>
        <div id='mainContainer'>
        <table id='menlist'>
        <tr>
            <th id='thumbs'></th>
            <th id='ytName'></th>
            <th id='btns'></th>
        </tr>");
$query = "SELECT * FROM Mentions WHERE username LIKE '%".$user."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    $i2 = 0;
    // loop through all result rows
    while ($stmt->fetch()) {
                echo("<tr><td><img src='https://i.ytimg.com/vi/".$row['youtubeid']."/mqdefault.jpg' id='thumb'></td><td id='listname'><a href='../song/index.php?id=".$row['ID']."&mention=1'>".$row['Name']."</a></td><td><a href='del.php?id=".$row['ID']."' id='del'>Delete</a></td></tr>");
       
        $i2++;
    }
    if ($i2 == 0){
        echo("<center><p class='white arial'>Nothing found.</p></center>");
    }
    echo("</table></div></form>");
    // Continue on as usual.
}
echo("<form id='main'>
        <div id='Header'>
            <a href='/' id='formlogo' class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a><h3>Liked Songs</h3>
        </div>
        <div id='mainContainer'>
        <table id='menlist'>
        <tr>
            <th id='thumbs'></th>
            <th id='ytName'></th>
            <th id='btns'></th>
        </tr>");
$query = "SELECT * FROM likes WHERE username LIKE '%".$user."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    $i2 = 0;
    // loop through all result rows
    while ($stmt->fetch()) {
                echo("<tr><td><img src='https://i.ytimg.com/vi/".$row['youtubeid']."/mqdefault.jpg' id='thumb'></td><td id='listname'><a href='../song/index.php?id=".$row['songID']."&mention=1'>".$row['Name']."</a></td><td><a href='lik.php?id=".$row['songID']."' id='del'>UnLike</a></td></tr>");
       
        $i2++;
    }
    if ($i2 == 0){
        echo("<center><p class='white arial'>Nothing found.</p></center>");
    }
    echo("</table></div></form>");
    // Continue on as usual.
}

echo("        <form id='main'>
        <div id='Header'>
            <a href='/' id='formlogo' class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a><h3>Reports</h3>
        </div>
        <div id='mainContainer'>
        <table id='reportlist'>
        <tr>
            <th id='thumbs'><p class='white arial'>Status</p></th>
            <th id='ytName'><p class='white arial'>Name</p></th>
            <th id='status'><p class='white arial'>Date</p></th>
        </tr>");
$query = "SELECT * FROM reports WHERE username LIKE '%".$user."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    $i2 = 0;
    // loop through all result rows
    while ($stmt->fetch()) {
        if ($i2 <= 5){
                            try{
                if ($row['anime'] == '1'){
                 $queryUser = $dbc->prepare("SELECT * FROM shows WHERE id LIKE '%".$row['ID']."%'");
                 $queryUser ->execute();
                 $user = $queryUser ->fetchColumn(1);
                echo("<tr><td><p class='white arial bold'>".$row['Status']."</p></td><td id='listname'><a href='../anime/index.php?id=".$row['ID']."'>".$user."</a></td><td><p class='white right'>".$row['Date']."</p></td></tr>");
                }else{
                 $queryUser = $dbc->prepare("SELECT * FROM shows WHERE id LIKE '%".$row['ID']."%'");
                 $queryUser ->execute();
                 $user = $queryUser ->fetchColumn(1);
                echo("<tr><td><p class='white arial bold'>".$row['Status']."</p></td><td id='listname'><a href='../song/index.php?id=".$row['ID']."'>".$user."</a></td><td><p class='white right'>".$row['Date']."</p></td></tr>");
                }
            }catch(PDOException $e){
                die('Error!');
            }
            }
        }
        $i2++;
    }
    if ($i2 == 0){
        die("<center><p class='white arial'>Nothing found.</p></center>");
    }
    echo("</table>");
    // Continue on as usual.
}

?>