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
        <div id='Container'>
        	    <center>");

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
if (strlen($id) > 25){
	die('Refer is to long.');
}else if (strlen($id) < 24){
	die('Refer is to short.');
}//End(0)
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$mention = $_GET['mention'];
$nowtime = date("Y-m-d H:i:s");
//POPULAR FOR HOMEPAGE

        try{
            $queryPopCount = $dbc->prepare("SELECT count(*) FROM popular");
            $queryPopCount ->execute();
            $queryPopCount = $queryPopCount->fetchColumn();
            if ($queryPopCount >= 11){
            $qryDel = $dbc->prepare("DELETE FROM popular WHERE date IS NOT NULL order by date ASC LIMIT 1");
            $qryDel->execute();
            }
        }catch(PDOException $e){
            die('Error:Failed to Establish Query.');
        }//End(1)
      
//END OF POPULAR
if (!isset($mention)){
$query = "SELECT * FROM songs WHERE id LIKE '%".$id."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("<iframe id='ytplayer' type='text/html' width='960' height='640'
  					src='https://www.youtube.com/embed/".$row['youtubeid']."?autoplay=1&origin=http://example.com'
  					frameborder='0'></iframe><br>
  					<a href='../php/server/report.php?id=".$id."' id='mscbtn'>Report</a><a style='margin-left:25px' href='../anime/?id=".$row['showID']."' id='mscbtn'> Back </a>");
       $ytid = $row['youtubeid'];
       $nam = $row['Name'];
       try{
        $queryLikers = $dbc->prepare("SELECT count(*) FROM likes WHERE songid LIKE '%".$id."%'");
        $queryLikers->execute();
        $queryLikers = $queryLikers->fetchColumn();
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM likes WHERE songid LIKE '%".$id."%' AND username LIKE '%".$user."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM > 0){
            echo("<a style='margin-left:25px' href='like.php?id=".$id."' id='mscbtn'> Unlike(".$queryLikers.") </a>");
        }else{
            echo("<a style='margin-left:25px' href='like.php?id=".$id."' id='mscbtn'> Like(".$queryLikers.") </a>");
        }
        $queryPopCheck = $dbc->prepare("SELECT count(*) FROM popular WHERE id LIKE '%".$id."%'");
        $queryPopCheck->execute();
        $queryPopCheck = $queryPopCheck->fetchColumn();
        if ($queryPopCheck == 0){
            $qryPOP = $dbc->prepare("INSERT INTO popular (ID, Date, mention, youtubeid, Name) VALUES ('$id','$nowtime','0','$ytid','$nam')");
            $qryPOP->execute();
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
       echo("
                </center>
        </div>
         <footer>
                           <div id='disqus_thread'></div>
<script>


var disqus_config = function () {
this.page.url = 'http://musicani.me/song/index.php?id=".$id."';  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = '".$id."'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = '//musicani-me.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
        
         </footer>             
    </body>

</html>");
    }

    // Continue on as usual.
}
}else{
    $query = "SELECT * FROM Mentions WHERE id LIKE '%".$id."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("<center><h3 class='white arial'>Mention by ".$row['username']."<h3></center>
        <iframe id='ytplayer' type='text/html' width='960' height='640'
                    src='https://www.youtube.com/embed/".$row['youtubeid']."?autoplay=1&origin=http://example.com'
                    frameborder='0'></iframe><br>
                    <a href='../php/server/report.php?id=".$id."'  id='mscbtn'>Report</a><a style='margin-left:25px' href='../anime/?id=".$row['showID']."'  id='mscbtn'> Back </a>");
       $ytid = $row['youtubeid'];
       $nam = $row['Name'];
       try{
        $queryLikers = $dbc->prepare("SELECT count(*) FROM likes WHERE songid LIKE '%".$id."%'");
        $queryLikers->execute();
        $queryLikers = $queryLikers->fetchColumn();
        //Query
        $queryUserM = $dbc->prepare("SELECT count(*) FROM likes WHERE songid LIKE '%".$id."%' AND username LIKE '%".$user."%'");
        $queryUserM->execute();
        $queryUserM = $queryUserM->fetchColumn();
        if ($queryUserM > 0){
            echo("<a style='margin-left:25px' href='like.php?id=".$id."&mention=1' id='mscbtn'> Unlike(".$queryLikers.") </a>");
        }else{
            echo("<a style='margin-left:25px' href='like.php?id=".$id."&mention=1' id='mscbtn'> Like(".$queryLikers.") </a>");
        }
        $queryPopCheck = $dbc->prepare("SELECT count(*) FROM popular WHERE id LIKE '%".$id."%'");
        $queryPopCheck->execute();
        $queryPopCheck = $queryPopCheck->fetchColumn();
        if ($queryPopCheck == 0){
            $qryPOP = $dbc->prepare("INSERT INTO popular (ID, Date, mention, youtubeid, Name) VALUES ('$id','$nowtime','1','$ytid','$nam')");
            $qryPOP->execute();
        }
    }catch(PDOException $e){
        die('Error:Failed to Establish Query.');
    }//End(1)
       echo("
                </center>
        </div>
         <footer>
                           <div id='disqus_thread'></div>
<script>


var disqus_config = function () {
this.page.url = 'http://musicani.me/song/index.php?id=".$id."';  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = '".$id."'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = '//musicani-me.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
        
         </footer>             
    </body>

</html>");
    }

    // Continue on as usual.
}
}
/* close connection */
mysqli_close($link);
?>
<!--<!DOCTYPE html>
<html>
    
    <head>
        <link href="css/main.css" type="text/css" rel="stylesheet"/>
        <link rel="icon" type="image/png" href="http://musicani.me/img/icon.png">
        <title>Musicani - Listen. Watch. Enjoy.</title>
        <script src="js/main.js"></script>
    </head>
    <body>
        <div id="navBar">
            <a href="/" id="logo"class="arial bold"><span class="sitelogo dodge upper arial bold">Music</span>ani<span class="dodge upper">●</span>me <span class="sitelogo dodge upper arial bold">ALPHA</span></a>
            <ul id="topNav" class="line listnone">
                <li class="upper bold arial white"><a href="" class="white"><img class="navicon-cat">&nbsp;Anime</a></li>
            </ul>
        </div>
        <div id="Container">
        	    <center>
                	<iframe id="ytplayer" type="text/html" width="960" height="640"
  					src="https://www.youtube.com/embed/M7lc1UVf-VE?autoplay=0&origin=http://example.com"
  					frameborder="0"></iframe><br>
  					<a href=''>Report</a>
                </center>
        </div>
    </body>

</html>-->