<?php
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

if(!isset($_COOKIE['session'])) {
    echo("<!DOCTYPE html>
<html>
    
    <head>
        <link href='css/regmain.css' type='text/css' rel='stylesheet'/>
        <link rel='icon' type='image/png' href='http://musicani.me/img/icon.png'>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title>Musicani - Listen. Watch. Enjoy.</title>
    </head>
    <body>
        <div id='navBar'>
            <a href='/' id='logo'class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a>
            <ul id='topNav' class='line listnone'>
            </ul>
        </div>
        <form id='main'  action='log.php' method='post'>
        <div id='Header'>
        	<a href='/' id='formlogo' class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a><h3>Login</h3>
        </div>
        <div id='mainContainer'>");
    if (!isset($id)){
    	echo("      <div id='msg' class='hid'><p id='msgcaption'>This is a message.</p></div>");
    }else{
    	echo("      <div id='msg' class='vis'><p id='msgcaption'>".$id."</p></div>");
    }

        	echo("<table id='tblform'>
        		<tr>
        			<th id='lbl'></th>
        			<th id='input'></th>
        		</tr>
        		<tr>
        			<td><label class='white arial'>Username:</label></td>
        			<td><input type='textbox' name='user' class='tb' id='user'/></td>
        		</tr>
        		<tr>
        			<td><label class='white arial'>Password:</label></td>
        			<td><input type='password' name='pass' class='tb' id='pass'/></td>
        		</tr>
       		 </table>
       <center><div data-theme='dark' class='g-recaptcha' data-sitekey='6Lcvng8UAAAAAGFg8V-F0yk-WR9t1c2VBbenbox7'></div>
       			<input type='submit' id='register' value='Login'/><a href='register.php'><input type='button' id='register' value='Register'/></a>
       </center>
        </div>
        </form>");
} else {
   redirect("http://musicani.me/account/");
}
?>