<?
session_start();
include "../includes/config.php";
include "../includes/db.php";

$MemberID = $_GET["MemberID"];
$money = $_GET["money"];
$period = $_GET["period"];


$sql = "SELECT ExpireDate FROM $TMember WHERE MemberID = '$MemberID'";;
$q = mysql_db_query($dbname, $sql) or die($sql);
$result = mysql_fetch_array($q);

$dn = "Y-m-d H:i:s";
if(date("Y-m-d H:i:s") > $result["ExpireDate"]){
	$expire = date($dn,strtotime("+ ".$period." month"));

}else{
	list($date,$time) = explode(" ",$result["ExpireDate"]);
	list($y,$m,$d) = explode("-", $date);
	list($h,$i,$s) = explode(":", $time);

	$ts = mktime($h,$i,$s,$m,$d,$y);
	$expire = date($dn,strtotime("+ ".$period." month",$ts));
}

$sql2 = "UPDATE $TMember SET ExpireDate = '$expire' WHERE MemberID='$MemberID'";;
$q2 = mysql_db_query($dbname, $sql2) or die($sql2);

$sql3 = "INSERT INTO $TRenewal(MemberID,MoneyAdd,Credit,MemberIDAdd,ExpireDate,Added) VALUE('$MemberID','$money','$period','".$_SESSION["Member"]["MemberID"]."','$expire','".date("Y-m-d H:i:s")."')";
$q3 = mysql_db_query($dbname, $sql3) or die($sql3);

mysql_close();
?>