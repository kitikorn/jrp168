<?
function getAmphur($aid){
	include "includes/config.php";
	$sql = "SELECT AMPHUR_NAME FROM $TAmphur WHERE AMPHUR_ID = '$aid'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$result = mysql_fetch_array($q);
	return $result["AMPHUR_NAME"];
}

function getProvince($pid){
	include "includes/config.php";
	$sql = "SELECT PROVINCE_NAME FROM $TProvince WHERE PROVINCE_ID = '$pid'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$result = mysql_fetch_array($q);
	return $result["PROVINCE_NAME"];
}
?>