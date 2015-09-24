<?
session_start();
include "../includes/config.php";
include "../includes/db.php";


include "../Class/Auth.php";
include "../Class/Datethai.php";
include "../Class/ResizeImage.php";

$condition = $_GET["condition"];

$sql2 = "SELECT MemberID,MemberCode,Prefix,FirstName,LastName,MemberType FROM $TMember WHERE Activated= 'N' AND MemberType='U' AND Status='A' ORDER BY MemberCode";
$q2 = mysql_db_query($dbname, $sql2) or die($sql2);
$rowC = mysql_num_rows($q2);

if($rowC >0){
  $total = "<span style=\"font-size:14px;\" class=\"text-red\">(ทั้งหมด ".$rowC." คน)</span>";
}else{
  $total = "";
}
?>

<div class="box" id="box-main">
<div class="box-header with-border">
      <h3 class="box-title">สมาชิกรอยืนยัน <?=$total;?></h3>

    
  </div><!-- /.box-header -->
   
                <div class="box-body" >
                <? if($rowC > 0){ ?>
                  <table class="table table-hover">
                    <tbody>
                    <tr >
                      <th style="width: 10px" >#</th>
                      <th style="width: 90px">รหัสสมาชิก</th>
                      <th style="width: 100px">รูปสมาชิก</th>
                      <th>สมาชิก</th>
                      <th style="width: 110px">ประเภทสมาชิก</th>
                      <th style="width: 60px">เมนู</th>
                    </tr>
                    <?
                    $i=1;
                    while($result = mysql_fetch_array($q2)) {
                      
                      if($result["MemberCode"] != ""){
                        $mc = $result["MemberCode"];
                      }else{
                        $mc = "<span class=\"badge bg-red\">รอยืนยัน</span>";
                      }

                        $mt = "หัวหน้าทีม";
                     
                      $sql3 = "SELECT PathUpload FROM $TFilePath WHERE Modules ='member' AND ItemID ='$result[MemberID]'";
                      $q3 = mysql_db_query($dbname, $sql3) or die($sql3);
                      $reP = mysql_fetch_array($q3);
                      $rowP = mysql_num_rows($q3);
                      if($rowP > 0){
                        $pic = $memberFile.$reP["PathUpload"];
                      }else{
                        $pic = $memberFile."avatar.png";
                      }
                      
                    ?>
                    <tr>
                      <td><?=$i;?></td>
                      <td><?=$mc;?></td>
                      <td>
                        <img src="<?=$pic?>" width="50" class="img-circle">
                      </td>
                      <td><?=$result["Prefix"].$result["FirstName"]." ".$result["LastName"]?></td>
                      <td><span class="badge bg-light-blue"><?=$mt?></span></td>
                      <td>
                      <button id="complexConfirm" type="button" class="btn btn-success" onclick="return loadActivate('<?=$result["MemberID"];?>')"><i class="fa fa-key"></i></button>
                      </td>
                   </tr>
                   <?
                    $i++; 
                    } ?>
                   
                  </tbody>

                  </table>

                  
                  <? } else { ?>
                      <span class="badge bg-red">ไม่พบข้อมูล</span>
                  <? } ?>
                  </div>
                </div><!-- /.box-body -->

                 
            
<?
mysql_close();
?>