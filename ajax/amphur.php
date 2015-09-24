<?
include "../includes/config.php";
include "../includes/db.php";

$ProvinceID = $_GET["ProvinceID"];
$AmphurID = @$_GET["AmphurID"];

$sql = "SELECT AMPHUR_ID,AMPHUR_NAME FROM $TAmphur WHERE PROVINCE_ID ='$ProvinceID'";
$q = mysql_db_query($dbname, $sql) or die($sql);
?>
<select class="form-control" name="amphur" id="amphur">
<option value="0">-- กรุณาเลือก --</option>
<?
while($result = mysql_fetch_array($q)){
	if($AmphurID == $result["AMPHUR_ID"]){
?>
    <option value="<?=$result['AMPHUR_ID']?>" selected><?=$result['AMPHUR_NAME']?></option>
<?
	}else{
?>
	<option value="<?=$result['AMPHUR_ID']?>" ><?=$result['AMPHUR_NAME']?></option>
<?
	}
}
?>
</select>
<?

mysql_close();
?>