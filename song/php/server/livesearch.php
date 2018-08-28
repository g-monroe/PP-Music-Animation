<?php
define('auth_4M2ynM9DPv9x3We8_ForbiddenCheck', true);
require_once('cF65UGyxUnBLaZonED6rxX6JKMcaRCAnEtR5rNBGa4tupPence/dbcon.php'); //Database 
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
$q = $_GET['q'];
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");

if (strlen($q) > 48){
	die("<center><p class='white arial'>Search is to long.</p></center>");
}else if (strlen($q) < 3){
	die("<center><p class='white arial'>Search is to short.</p></center>");
}//End(0)

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT * FROM shows WHERE name LIKE '%".$q."%'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
	stmt_bind_assoc($stmt, $row);

	echo("<table id='tblResults'>
                <tr>
                    <th id='imgrow'></th>
                    <th id='namerow'></th>
                </tr>");

	$i2 = 0;
	// loop through all result rows
	while ($stmt->fetch()) {
		if ($i2 <= 5){
			   	echo("<tr><td><img id='posterimg' src='".$row['Poster']."' /></td><td id='listname'><a href='/anime/index.php?id=".$row['ID']."'>".$row['Name']."</a></td></tr>");
		}
		$i2++;
	}
	if ($i2 == 0){
		die("<center><p class='white arial'>Nothing found.</p></center>");
	}
	echo("</table>");
    // Continue on as usual.
}

/* close connection */
mysqli_close($link);
?>