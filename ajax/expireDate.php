<?
session_start();
include "../includes/config.php";
include "../includes/db.php";

$MemberID = $_GET["MemberID"];

$sql = "SELECT ExpireDate FROM $TMember WHERE MemberID = '$MemberID'";;
$q = mysql_db_query($dbname, $sql) or die($sql);

$result = mysql_fetch_array($q);

if(date("Y-m-d H:i:s") > $result["ExpireDate"]){
	print "<span class=\"text-red\">".$result["ExpireDate"]."</span>";
}else{
	print "<span class=\"text-green\">".$result["ExpireDate"]."</span>";
}

mysql_close();
?>