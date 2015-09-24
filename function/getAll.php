<?
function getName($MemberID){
	include "includes/config.php";
	$sql = "SELECT Prefix,FirstName,LastName FROM $TMember WHERE MemberID ='$MemberID'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$result = mysql_fetch_array($q);
	//mysql_close();
	return $result["Prefix"].$result["FirstName"]." ".$result["LastName"];
}

function getActivate($MemberID){
	include "includes/config.php";
	$sql = "SELECT Activated FROM $TMember WHERE MemberID ='$MemberID'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$result = mysql_fetch_array($q);
	//mysql_close();
	return $result["Activated"];
}

function getAllChild($MemberID){
	include "includes/config.php";
	$sql = "SELECT COUNT(MemberID) as num FROM $TMember WHERE ParentID ='$MemberID' AND Status ='A' AND MemberType='S'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$result = mysql_fetch_array($q);

	return $result["num"];
}

function getOver($MemberID){
	include "includes/config.php";
	$Now = getAllChild($MemberID);
	if($Now >= $cfg["subMember"]){
		return "Y";
	}else{
		return "N";
	}
}
?>
