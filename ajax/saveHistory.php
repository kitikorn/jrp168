<?
session_start();
include "../includes/config.php";
include "../includes/db.php";


include "../Class/Auth.php";
include "../Class/Datethai.php";
include "../Class/ResizeImage.php";
include "../function/string.php";

$MemberID = @$_GET["MemberID"];

$title = @$_GET["title"];
$detail = @$_GET["detail"];

print $detail;
$sql = "INSERT INTO $TMemberTransaction (MemberID,Title,Description,Added,MemberIDadd) VALUES ('$MemberID','$title','$detail','".date("Y-m-d H:i:s")."','".$_SESSION["Member"]["MemberID"]."')";
$q = mysql_db_query($dbname, $sql) or die($sql);
if($q == true){
	//print "Y";
}else{
	//print "N";
}

mysql_close();
?>