<?
include "../includes/config.php";
include "../includes/db.php";

$email = $_GET["email"];
$sql = "SELECT Email FROM $TMember WHERE Email ='$email'";
$q = mysql_db_query($dbname, $sql) or die($sql);
$result = mysql_fetch_array($q);
$exi = $result["Email"];
if($email == $exi){
	print "Y";
}else{
	print "N";
}

mysql_close();
?>