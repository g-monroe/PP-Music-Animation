<?php
echo("<!DOCTYPE html>
<html>
    
    <head>
        <link href='css/main.css' type='text/css' rel='stylesheet'/>
        <link rel='icon' type='image/png' href='http://musicani.me/img/icon.png'>
        <title>Musicani - Listen. Watch. Enjoy.</title>
        <script src='js/main.js'></script>
    </head>
    <body>
        <div id='navBar'>
            <a href='/' id='logo'class='arial bold'><span class='sitelogo dodge upper arial bold'>Music</span>ani<span class='dodge upper'>●</span>me <span class='sitelogo dodge upper arial bold'>ALPHA</span></a>");
           	if(!isset($_COOKIE['session'])) {
  				echo("<a class='arial white right navbarcenter' href='/account/login.php'>Sign In</a>");
			} else {
            	echo("<a class='arial white right navbarcenter' href='/account/'>Account </a>");
        	}
            echo("<ul id='topNav' class='line listnone'>
                <li class='upper bold arial white'><a href='/anime/' class='white'><img src='img/anime.png'>&nbsp;Anime</a></li>
                 <li class='upper bold arial white'><img src='img/search.png'>&nbsp;<input onkeyup='showResult(this.value)' id='navsearch' class='white' type='textbox'/></li>
            </ul>
        </div>
         <div id='resultsdiv'>
            <table id='tblResults'>
                <tr>
                    <th id='imgrow'></th>
                    <th id='namerow'></th>
                </tr>
                
            </table>
        </div>
       <div id='infobox'>
          <img id='infoIcon' src='img/large.gif'/>
          <div id='msg'>
         <p id='msginfo' class='white arial'>On &nbsp;</p><p id='msginfo' class='bold white arial'>Jan 30, 2017 &nbsp;</p><p id='msginfo' class='white arial'> we will be shutdown due to insufficient funding. If you would like to see this site grow</p><p id='msginfo' class='bold white arial'> &nbsp;Donate </p><p id='msginfo' class='white arial'>! Thank you for the support that people give. - Kevin.</p>
          </div>
       </div>
        <div id='don'>
                 <form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick' />
<input type='hidden' name='hosted_button_id' value='P9XZ5NCB7R86S' />
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif' border='0' name='submit' title='PayPal - The safer, easier way to pay online!' alt='Donate' />
    </div>
    <div id='border'>
                 <h3>Recent Mentions(<a href='/account/register.php'>Sign up</a>)</h3>
            </div>
          <div id='gpContainer'><ul id='thumblst'>");
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('php/server/cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php'); //Database
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
$id = $_GET['id'];

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$query = "SELECT * FROM (
  SELECT * 
  FROM Mentions 
  ORDER BY Date DESC
  LIMIT 10
) AS `table` ORDER by Date ASC";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("
       	<li>
                        <div id='item'>
                             <img src='https://i.ytimg.com/vi/".$row['youtubeid']."/mqdefault.jpg'>
                            <p id='titleitem' class='arial white'><a href='../song/index.php?id=".$row['ID']."&mention=1'>".$row['Name']."</a></p>
                        </div>
                   </li>");
    }
    echo("</ul></div><div id='border'>
                 <h3>Currenting Playing</h3>
            </div>
          <div id='gpContainer'><ul id='thumblst'>");
    // Continue on as usual.
}
$query = "SELECT * FROM (
  SELECT * 
  FROM popular
  ORDER BY Date DESC
  LIMIT 10
) AS `table` ORDER by Date DESC";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("
       	<li>
                        <div id='item'>
                             <img src='https://i.ytimg.com/vi/".$row['youtubeid']."/mqdefault.jpg'>");
       						if($row['mention'] == '0'){
       							echo("<p id='titleitem' class='arial white'><a href='../song/index.php?id=".$row['ID']."'>".$row['Name']."</a></p>");
       						}else{
       							echo("<p id='titleitem' class='arial white'><a href='../song/index.php?id=".$row['ID']."&mention=1'>".$row['Name']."</a></p>");
       						}
                        echo("</div>
                   </li>");
    }
    echo("</ul></div>");
    // Continue on as usual.
}
mysqli_close($link);

?>

  

</body>

</html>