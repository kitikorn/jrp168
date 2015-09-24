
<?
$MemberID = @$_GET["MemberID"];

$sql = "SELECT * FROM $TMember WHERE MemberID = '$MemberID'";
$q = mysql_db_query($dbname, $sql) or die($sql);
$result = mysql_fetch_array($q);

$sql2 = "SELECT PathUpload FROM $TFilePath WHERE Modules ='member' AND ItemID ='$MemberID'";
$q2 = mysql_db_query($dbname, $sql2) or die($sql2);
$resultP = mysql_fetch_array($q2);
$rowP = mysql_num_rows($q2);

if($result["Activated"] == "N"){
	$MemberCode = "<span class=\"badge bg-red\">รอยืนยัน</span>";
}else{
	$MemberCode = $result["MemberCode"];
}

if($result["MemberType"] == "S"){
	$MemberType = "ลูกทีม";
}else{
	$MemberType = "หัวหน้าทีม";
}

$dateNow = date("Y-m-d H:i:s");
if($dateNow > $result["ExpireDate"]){
  $classText = "text-red";
}else{
  $classText = "text-green";
}

?>
 <script type="text/javascript">
$(document).ready(function() {
    //console.log( eady!" );
    //CKEDITOR.replace('detail');

    loadHistoryAngur('<?=$MemberID?>');
    $( "#add-history-bu" ).click(function() {
      $("#plus").click();
    });

    $( "#cancel-history" ).click(function() {
      $("#plus").click(); 
      $("#title").val("");
      $("#detail").val("");
    });

        //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

     $("#form-add-history").validate({
      rules:{
        title:{
          required: true,
          highlight:function(){
            $("#class-title").addClass("has-error");
          }
        }
      },
      messages:{
        title:"<span class='txtred'>กรุณากรอกชื่อเรื่อง</span>",
      },
      unhighlight:function(){
         $( "#class-title").removeClass( "has-error" ).addClass("has-success");
      }
    });

    $("#form-renewal").validate({
      rules:{
        money:{
          required: true,
          number:true,
          highlight:function(){
            $("#class-money").addClass("has-error");
          }
        }
      },
      messages:{
        money:{
          required:"<span class='text-red'>กรุณากรอกจำนวนเงิน</span>",
          number :"<span class='text-red'>กรุณาใส่เฉพาะตัวเลขเท่านั้น</span>"
        }
      },
      unhighlight:function(){
         $( "#class-money").removeClass( "has-error" ).addClass("has-success");
      }
    });

      $("#save-history" ).click(function() {
      //return false;
        var title = $("#title").val();
        var detail = $("#detail").val();

        if(title == ""){
          // none
        }else{
          $(".box-info" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
          $.ajax({
                    type:"get",
                    url:"ajax/saveHistory.php",
                    data:"MemberID="+$("#MemberID").val()+"&title="+title+"&detail="+detail,
                    success:function(data){
                      
                      loadHistoryAngur($("#MemberID").val());
                      $(".overlay").remove();
                      $("#title").val("");
                      $("#detail").val("");
                      $("#plus").click(); 
                    }
                  }
          );

          return false;
        }
      });

      $("#save-renewal" ).click(function() {
        var money = $("#money").val();
        var period = $("#period").val();

        if(money == ""){

        }else{
          $(".box-info" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
          $.ajax({
              type:"get",
              url:"ajax/reNewal.php",
              data:"MemberID="+$("#MemberID").val()+"&money="+money+"&period="+period,
              success:function(data){
                //$("#expireDateArea").html(data);
                loadExpireDate($("#MemberID").val());
                $("#info-renewal").show();
                loadReNewal();
                $("#money").val("");
                $(".overlay").remove();
              }
            }
          );
          return false;
        }
        
      });
     


      $("#cancel-renewal").click(function(){
        loadReNewal();
      });

});


function loadExpireDate(MemberID){
  $.ajax({
              type:"get",
              url:"ajax/expireDate.php",
              data:"MemberID="+MemberID,
              success:function(data){
                $("#expireDateArea").html(data);

              }
            }
          );

}

function loadReNewal(){
  $("#reNewal").click();
}


</script>


<div class="callout callout-success" id="info-success" style="display:none;">
     <h4> <i class="icon fa fa-check"></i> คุณได้ทำการลบสมาชิกสำเร็จ</h4>
</div>

<div class="callout callout-success" id="info-renewal" style="display:none;">
     <h4> <i class="icon fa fa-check"></i> คุณได้ต่ออายุสมาชิกสำเร็จ</h4>
</div>

<div id="dialog-confirm" title="ลบสมาชิก ?" style="display:none;">
  <p>
  คุณแน่ใจจะลบหรือไม่ ?</p>
</div>
<div id="dialog-check" title="ไม่สามารถเพิ่มลูกทีมได้" style="display:none;">
  <p>
  คุณไม่สามารถเพิ่มลูกทีมได้<br>เนื่องจากสมาชิกหลักยังไม่ได้ถูก ยืนยัน การเป็นสมาชิก</p>
</div>


<div class="" id="box-main">
  <div class="box-header with-border">
      <h3 class="box-title">รายละเอียดสมาชิก</h3>
 		
  </div><!-- /.box-header -->

<div class="row">
    <div class="col-md-4">
      <div class="box box-info">
        <div class="box-header with-border">
        <? if($result["MemberType"] == "U"){ ?>
          <center><h3 class="box-title badge bg-red" >รหัสสมาชิก : <?=$MemberCode;?></h3></center>
          <? } ?>
        </div><!-- /.box-header -->
        <div class="box-body" align="center">
          <?
          if($rowP > 0){
            $pic = $memberFile.$resultP["PathUpload"]."?t=".time();
          }else{
            $pic = $memberFile."avatar.png?t=".time();
          }

          ?>
          <img src="<?=$pic?>" width="250" class="img-circle">
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <div class="col-md-8">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">ข้อมูลส่วนตัว</h3>
          	<div class="box-tools pull-right">
			 	<button type="button" class="btn btn-info" onclick="window.location='<?=$_SERVER["PHP_SELF"]?>?module=editregister&MemberID=<?=$MemberID?>'"><i class="fa fa-edit"></i></button>
 			</div>
        </div><!-- /.box-header -->
        <div class="box-body">
          

		<table class="table table-striped">
			<tbody>
				<? if($result["MemberType"] == "S" ){ ?>
				<tr >
					<td style="width: 200px" >หัวหน้าทีม : </td>
					<td ><a href="<?=$_SERVER["PHP_SELF"]?>?module=viewmember&MemberID=<?=$result["ParentID"]?>"><?=getName($result["ParentID"]);?></a></td>
				</tr>
				<? } ?>
				<tr >
					<td style="width: 200px" >ประเภทสมาชิก : </td>
					<td ><?=$MemberType;?></td>
				</tr>
				<tr >
					<td style="width: 200px" >อีเมล์	 : </td>
					<td ><?=$result["Email"];?></td>
				</tr>
				<tr>
					<td>ชื่อ-สกุล :</td>
					<td><?=$result["Prefix"].$result["FirstName"]." ".$result["LastName"];?></td>
				</tr>
				<tr>
					<td>ชื่อเล่น :</td>
					<td><?=$result["NickName"];?></td>
				</tr>
				<tr>
					<td>วันเกิด :</td>
					<td><?=$dateD[$result["DateBirth"]];?></td>
				</tr>
				<tr>
					<td>วัน/เดือน/ปี เกิด :</td>
					<td><?=$result["DateOfBirth"];?></td>
				</tr>
				<tr>
					<td>เบอร์โทรศัพท์บ้าน :</td>
					<td><?=$result["Tel"];?></td>
				</tr>
				<tr>
					<td>เบอร์โทรศัพท์มือถือ :</td>
					<td><?=$result["Mobile"];?></td>
				</tr>
				<tr>
					<td>อาชีพ :</td>
					<td><?=$result["Occupation"];?></td>
				</tr>
				<tr>
					<td>ที่อยู่ :</td>
					<td><?=$result["Address"];?></td>
				</tr>
				<tr>
					<td>อำเภอ :</td>
					<td><?=getAmphur($result["AMPHUR_ID"]);?></td>
				</tr>
				<tr>
					<td>จังหวัด :</td>
					<td><?=getProvince($result["PROVINCE_ID"]);?></td>
				</tr>
				<tr>
					<td>รหัสไปรษณีย์ :</td>
					<td><?=$result["Zipcode"];?></td>
				</tr>
        <tr>
          <td>วันที่เป็นสมาชิก :</td>
          <td><?=$result["Added"];?></td>
        </tr>
        <? if($result["MemberType"] == "U"){ ?>
        <tr>
          <td>วันหมดอายุสมาชิก : <a href="javascript:void(0)" onclick="return loadReNewal()" id="addExpireDate">[ต่ออายุ]</a></td>
          <td id="expireDateArea"><span class="<?=$classText?>" id=""><?=$result["ExpireDate"];?></span>

          </td>
        </tr>
        <? } ?>
			</tbody>
		</table>

    <div class="box box-solid collapsed-box">
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" id="reNewal" style="display:none;"><i class="fa fa-plus"></i></button>
      </div><!-- /.box-tools -->
      <div class="box-body">
      <form id="form-renewal" action="<?=$_SERVER["PHP_SELF"]?>" method="post">
        <input type="hidden" name="MemberID" id="MemberID" value="<?=$MemberID?>">
            <div class="box-body">
            <label>:: ระยะเวลา ::</label>
              <div class="input-group " id="class-period">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                   <select class="form-control" name="period" id="period">
                        <option value="1">1 เดือน</option>
                        <option value="3">3 เดือน</option>
                        <option value="6">6 เดือน</option>
                      </select>
                </div>
                <span id="chEmail" style="display:none;"></span>
            </div><!-- /.box-body -->
            <div class="box-body">
            <label>:: จำนวนเงิน ::</label>
              <div class="input-group " id="class-money">
                  <div class="input-group-addon">
                    <i class="fa fa-money"></i>
                  </div>
                  <input class="form-control" type="text"  id="money" name="money">
                </div>
              
            </div><!-- /.box-body -->
            <div class="box-body">
                 
                      <table align="right" border="0" width="210" style="margin-top:5px;">
                      <tr>
                        <td align="left">
                          <button id="cancel-renewal" type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat"  style="width:100px;"><i class="fa fa-times-circle"></i> ยกเลิก</button>

                        </td>
                        <td align="right">
                          <button id="save-renewal" style="width:100px;" class="btn btn-block btn-social btn-primary btn-block btn-flat">
                          <i class="fa  fa-save"></i> บันทึก
                          </button>
                      </tr>
                    </table>
            
            </div>
        </form>
      </div><!-- /.box-body -->
    </div>


        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <? if($result["MemberType"] == "U"){ ?>
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">ลูกทีม</h3>
			<div class="box-tools pull-right">

				<button type="button" class="btn btn-success" onclick="return addChild('<?=$MemberID?>','<?=getActivate($MemberID)?>','<?=getOver($MemberID)?>')"><i class="fa fa-plus-circle"></i></button>
			</div>
        </div><!-- /.box-header -->

        <div class="box-body">
          <?
			$sql4 = "SELECT * FROM $TMember WHERE MemberType='S' AND Status='A' AND Activated='Y' AND ParentID='$MemberID'";
			$q4 = mysql_db_query($dbname, $sql4) or die($sql4);
			$rowC = mysql_num_rows($q4);
          ?>
          <? if($rowC > 0){ ?>
          <table class="table table-hover">
                    <tbody><tr >
                      <th style="width: 10px" >#</th>
                      <th style="width: 100px">รูปสมาชิก</th>
                      <th>สมาชิก</th>
                      <? if($_SESSION["Member"]["MemberType"] == "A"){ ?> 
                      <th style="width: 100px">เมนู</th>
                      <? } ?>
                    </tr>
                    <?
                    

                    $i = 1; 
                    while($resultS = mysql_fetch_array($q4)) {
                      $mc = "-";

                      $sql3 = "SELECT PathUpload FROM $TFilePath WHERE Modules ='member' AND ItemID ='$resultS[MemberID]' AND Status='A'";
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
                      <td>
                        <img src="<?=$pic?>?val=<?=time();?>" width="50" class="img-circle">
                      </td>
                      <td><a href="<?=$_SERVER["PHP_SELF"]?>?module=viewmember&MemberID=<?=$resultS["MemberID"]?>&view=vDetail&ParentID=<?=$resultS["ParentID"]?>"><?=$resultS["Prefix"].$resultS["FirstName"]." ".$resultS["LastName"]?></a></td>
                    <? if($_SESSION["Member"]["MemberType"] == "A"){ ?> 
                      <td align="right"><span>
                        <div class="btn-group-horizontal">
                          <button type="button" class="btn btn-info" onclick="window.location='indexhome.php?module=editregister&MemberID=<?=$resultS["MemberID"]?>'"><i class="fa fa-edit"></i></button>
                          <button type="button" class="btn btn-danger" onclick="delMemberS('<?=$resultS["MemberID"]?>')"><i class="fa fa-times-circle"></i></button>
                        </div>
                      </span></td>
                      <? } ?>

                   </tr>
                   <?
                    $i++; 
                    } ?>
                   
                  </tbody>

                 </table>
                 <? }else{ ?>
                 	<span class="badge bg-red">ไม่พบข้อมูลลูกทีม</span>
                 <? } ?>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <? } ?>
   
   <div class="col-md-12">
     
     <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">ประวัติการดูดวง</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-success" id="add-history-bu"><i class="fa fa-plus-circle"></i></button>        
      </div>
        </div><!-- /.box-header -->

        <div class="box box-solid collapsed-box">

          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" id="plus" style="display:none;"><i class="fa fa-plus"></i></button>
          </div><!-- /.box-tools -->
          <div class="box-body">
          <form id="form-add-history" action="<?=$_SERVER["PHP_SELF"]?>" method="post">
            <input type="hidden" name="MemberID" id="MemberID" value="<?=$MemberID?>">
                <div class="box-body">
                <label>:: ชื่อเรื่อง ::</label>
                  <div class="input-group " id="class-title">
                      <div class="input-group-addon">
                        <i class="fa fa-list"></i>
                      </div>
                       <input class="form-control" type="text"  id="title" name="title">
                    </div>
                    <span id="chEmail" style="display:none;"></span>
                </div><!-- /.box-body -->
                <div class="box-body">
                <label>:: รายละเอียด ::</label>
                  <div class="input-group " id="class-detail">
                      <div class="input-group-addon">
                        <i class="fa fa-list"></i>
                      </div>
                       <textarea id="detail" name="detail" class="form-control" rows="3" ></textarea>
                    </div>
                    <span id="chEmail" style="display:none;"></span>
                </div><!-- /.box-body -->
                <div class="box-body">
                     
                          <table align="right" border="0" width="210" style="margin-top:5px;">
                          <tr>
                            <td align="left">
                              <button id="cancel-history" type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat"  style="width:100px;"><i class="fa fa-times-circle"></i> ยกเลิก</button>

                            </td>
                            <td align="right">
                              <button id="save-history" style="width:100px;" class="btn btn-block btn-social btn-primary btn-block btn-flat">
                              <i class="fa  fa-save"></i> บันทึก
                              </button>
                          </tr>
                        </table>
                
                </div>
            </form>
          </div><!-- /.box-body -->
        </div>

        <div class="box-body" id="history-angur"></div><!-- /.box-body -->
      </div><!-- /.box -->

   </div>

  </div>
 </div>



