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
$id = $_GET['id'];
$vid = $_GET['vid'];
$sid = $_GET['sid'];
$open = $_GET['open'];
$st = $_GET['st'];
$en = $_GET['en'];
$sname = $_GET['sname'];
$pas = $_GET['pass'];
$type = $_GET['type'];
$pass = "nicetry";
if ($type == "updatesong"){
try{
		//Grab Users
	if ($pas == $pass){
		$qryUsers = $dbc->prepare("UPDATE songs SET youtubeid='$vid' WHERE id LIKE '%".$id."%'");
		$qryUsers->execute();
		die("Success!");
	}else{
		die("Wrong!");
	}
}catch(PDOException $e){
	die("Error!");
}
}elseif ($type == "grabsongs"){
	$query = "SELECT * FROM shows WHERE id='$id'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("<poster>".$row['Poster']."</poster><name>".$row['Name']."</name>");
    }

    // Continue on as usual.
}
$query = "SELECT * FROM songs WHERE showid='$id'";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("<item><img>https://i.ytimg.com/vi/".$row['youtubeid']."/mqdefault.jpg</img><id>".$row['ID']."</id><songname>".$row['Name']."</songname></item>");
    }

    // Continue on as usual.
}
mysqli_close($link);
}elseif ($type == "grablist"){
$query = "SELECT * FROM shows";

if ($stmt = mysqli_prepare($link, $query)) {

    $stmt->execute();
    
    $row = array();
    stmt_bind_assoc($stmt, $row);

    // loop through all result rows
    while ($stmt->fetch()) {
       echo("<item>".$row['ID']."</item>");
    }

    // Continue on as usual.
}
}elseif ($type == "addsong"){

try{
		$qryAddUser = $dbc->prepare("INSERT INTO songs (id, name, showid, opening, start, end, youtubeid) VALUES ('$id', '$sname', '$sid', '$open', '$st', '$en', '$vid')");
		$qryAddUser->execute();
		die("Success!");
	}catch(PDOException $e){
			die('Error:Failed to create song.'.$e);
	}//End(0)

}
?>
