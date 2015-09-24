<?
session_start();
include "../includes/config.php";
include "../includes/db.php";

$type = $_GET["type"];

if($type=="A"){
	$sql = "SELECT COUNT(MemberID) AS count FROM $TMember WHERE Activated = 'Y' AND MemberType !='A' AND Status ='A'";;
	$q = mysql_db_query($dbname, $sql) or die($sql);

	$result = mysql_fetch_array($q);

	print $result["count"];
}

if($type=="L"){
	$sql = "SELECT COUNT(MemberID) AS count FROM $TMember WHERE Activated = 'Y' AND MemberType ='U' AND Status ='A'";;
	$q = mysql_db_query($dbname, $sql) or die($sql);

	$result = mysql_fetch_array($q);

	print $result["count"];
}

if($type=="C"){
	$sql = "SELECT COUNT(MemberID) AS count FROM $TMember WHERE Activated = 'Y' AND MemberType ='S' AND Status ='A'";;
	$q = mysql_db_query($dbname, $sql) or die($sql);

	$result = mysql_fetch_array($q);

	print $result["count"];
}

if($type=="W"){
	$sql = "SELECT COUNT(MemberID) AS count FROM $TMember WHERE Activated = 'N' AND MemberType ='U' AND Status ='A'";;
	$q = mysql_db_query($dbname, $sql) or die($sql);

	$result = mysql_fetch_array($q);

	print $result["count"];
}



mysql_close();
?>