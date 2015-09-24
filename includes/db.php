<?
mysql_connect($host,$user,$password) or die("Can't connect to database!");
$charset="SET NAMES utf8"; 
mysql_query($charset) or die('Invalid query: '. mysql_error()); 
$charset = "SET character_set_results=utf8";
mysql_query($charset) or die('Invalid query: ' . mysql_error()); 

?>