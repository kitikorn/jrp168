<?

include "../includes/config.php";
include "../includes/db.php";

$ProvinceID = @$_GET["ProvinceID"];
$sql = "SELECT PROVINCE_ID,PROVINCE_NAME FROM $TProvince ORDER BY PROVINCE_NAME ASC";
$q = mysql_db_query($dbname, $sql) or die($sql);

?>
<select class="form-control" name="province" id="province" onchange="getAmphur()">
<option value="0">-- กรุณาเลือก --</option>
<?
while($result = mysql_fetch_array($q)){
	if($ProvinceID == $result["PROVINCE_ID"]){
?>
    	<option value="<?=$result['PROVINCE_ID']?>" selected><?=$result['PROVINCE_NAME']?></option>
<?
	}else{
?>
		<option value="<?=$result['PROVINCE_ID']?>"><?=$result['PROVINCE_NAME']?></option>
<?
	}
}
?>
</select>
<?
mysql_close();
?>