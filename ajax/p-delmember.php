<?
session_start();
include "../includes/config.php";
include "../includes/db.php";

$MemberID = $_GET["MemberID"];

$sql = "UPDATE $TMember SET Status = 'I' WHERE MemberID='$MemberID'";
$q = mysql_db_query($dbname, $sql) or die($sql);


$sql3 = "UPDATE $TFilePath SET Status = 'I' WHERE Modules='member' AND ItemID='$MemberID'";
$q3 = mysql_db_query($dbname, $sql3) or die($sql3);

mysql_close();
?>