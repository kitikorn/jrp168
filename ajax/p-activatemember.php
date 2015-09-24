<?
session_start();
include "../includes/config.php";
include "../includes/db.php";


include "../Class/Auth.php";
include "../Class/Datethai.php";
include "../Class/ResizeImage.php";
include "../function/string.php";

$MemberID = $_GET["MemberID"];


$sql = "SELECT MemberRun FROM $TMember WHERE MemberType='U' AND Activated ='Y' ORDER BY MemberRun DESC";
$q = mysql_db_query($dbname, $sql) or die($sql);
$result = mysql_fetch_array($q);
$run = $result["MemberRun"]+1;
$MemberCode = idenGen($run);

$expire = date("Y-m-d H:i:s",strtotime("+ ".$cfg["expireDefault"]." days"));


$sql2 = "UPDATE $TMember SET MemberRun='$run',Activated='Y',MemberCode='$MemberCode',ExpireDate='$expire' WHERE MemberID='$MemberID'";
$q2 = mysql_db_query($dbname, $sql2) or die($sql2);
if($q2 == true){
	print "Y";
}else{
	print "N";
}
mysql_close();
?>