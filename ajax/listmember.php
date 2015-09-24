<?
session_start();
include "../includes/config.php";
include "../includes/db.php";


include "../Class/Auth.php";
include "../Class/Datethai.php";
include "../Class/ResizeImage.php";

$memberCode = $_GET["memberCode"];
$firstName = $_GET["firstName"];
$lastName = $_GET["lastName"];
$memberType = $_GET["memberType"];
$condition = $_GET["condition"];

if (isset($_GET["page"])) { 
  $page  = $_GET["page"]; 
} else { 
  $page=1; 
} 
$num_rec_per_page = $cfg["listPerPage"];
$start_from = ($page-1) * $num_rec_per_page ; 

$sql = "SELECT MemberID FROM $TMember WHERE MemberCode LIKE '%$memberCode%' AND FirstName LIKE '%$firstName%' AND LastName LIKE '%$lastName%' AND MemberType ='$memberType'";
//print $sql;
$q = mysql_db_query($dbname, $sql) or die($sql);

$total_records = mysql_num_rows($q);  //count number of records

$sql2 = "SELECT MemberID,ParentID,MemberCode,Prefix,FirstName,LastName,MemberType,Activated,ExpireDate FROM $TMember WHERE MemberCode LIKE '%$memberCode%' AND FirstName LIKE '%$firstName%' AND LastName LIKE '%$lastName%' AND MemberType ='$memberType' AND Status='A' ORDER BY MemberCode ASC LIMIT $start_from,$num_rec_per_page";
$q2 = mysql_db_query($dbname, $sql2) or die($sql2);
$rowC = mysql_num_rows($q2);



?>
<div class="box">
   
                <div class="box-body">

                <? if($rowC > 0){ ?>
                  <table class="table table-hover">

                    <tbody>
                    <tr>
                      <td colspan="6" class="text-red" align="right">ผลการค้นหาทังหมด : <?=$total_records?> คน</td>
                    </tr>
                    <tr >
                      <th style="width: 10px" >#</th>
                      <th style="width: 90px">รหัสสมาชิก</th>
                      <th style="width: 100px">รูปสมาชิก</th>
                      <th>สมาชิก</th>
                      <th style="width: 110px">ประเภทสมาชิก</th>
                      <th style="width: 100px;">เมนู</th>
                    </tr>
                    <?
                    $i = $start_from+1; 
                    while($result = mysql_fetch_array($q2)) {

                      $dateNow = date("Y-m-d H:i:s");
                      if($dateNow > $result["ExpireDate"]){
                        $classText = "text-red";
                      }else{
                        $classText = "text-green";
                      }

                      if($result["Activated"] == "Y" && $result["MemberType"] == "U"){
                        $mc = $result["MemberCode"];
                        $ed = "<span class=\"".$classText."\">หมดอายุสมาชิก : ".$result["ExpireDate"]."</span>";
                      }else  if($result["Activated"] == "Y" && $result["MemberType"] == "S"){
                        $mc = "-";
                        $ed = "";
                      }else{
                        $mc = "<span class=\"badge bg-red\">รอยืนยัน</span>";
                        $ed = "";
                      }

                      if($result["MemberType"] == "U"){
                        $mt = "หัวหน้าทีม";
                      }else{
                        $mt = "ลูกทีม";
                      }

                      $sql3 = "SELECT PathUpload FROM $TFilePath WHERE Modules ='member' AND ItemID ='$result[MemberID]' AND Status='A'";
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
                        <img src="<?=$pic?>?val=<?=time();?>" width="50" class="img-circle">
                      </td>
                      <td>
                        <a href="indexhome.php?module=viewmember&MemberID=<?=$result["MemberID"]?>&ParentID=<?=$result["ParentID"];?>"><?=$result["Prefix"].$result["FirstName"]." ".$result["LastName"]?></a>
                        <br>
                        <? //$ed?>
                      </td>
                      <td><span class="badge bg-light-blue"><?=$mt?></span></td>
                      <td><span>
                        <div class="btn-group-horizontal" >
                          <button type="button" class="btn btn-info" onclick="window.location='indexhome.php?module=editregister&MemberID=<?=$result["MemberID"]?>'"><i class="fa fa-edit"></i></button>
                          <button type="button" class="btn btn-danger" onclick="delMember('<?=$result["MemberID"]?>')"><i class="fa fa-times-circle"></i></button>
                        </div>
                      </span></td>
                   </tr>
                   <?
                    $i++; 
                    } ?>
                    <tr>
                  <td align="right" colspan="6">
                  <div class="btn-group" >
                      <button type="button" class="btn btn-success btn-flat">หน้า</button>
                      <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu" style="align:right;">
                      <? 
                      
                      $total_pages = ceil($total_records / $num_rec_per_page); 

                      //echo "<li><a href='pagination.php?page=1'>«</a></li></a>"; // Goto 1st page  

                      for ($i=1; $i<=$total_pages; $i++) { 
                        ?>
                            <li><a href="javascript:loadListMember('A','<?=$memberCode?>','<?=$firstName?>','<?=$lastName?>','<?=$memberType?>','<?=$i?>')"><?=$i?></a></li>
                               
                          <?      
                      }
                      //echo '<li><a href="#">»</a></li>'; // Goto last page

                      ?>
                    </ul>
                  </div>
                  </td>
                  </tr>
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