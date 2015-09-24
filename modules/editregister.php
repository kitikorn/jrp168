<?
$module = @$_GET["module"];
$process = @$_GET["process"];
$con = @$_GET["con"];

if($con == "profile"){
  $MemberID = @$_SESSION[Member][MemberID];
}else{
  $MemberID = @$_GET["MemberID"];
}


$statusAdd = "0";

if($process == "edit"){
  $MemberID = @$_POST["MemberID"];
  $prefix = @$_POST["prefix"];
  $email = @$_POST["email"];
  $passwd = @$_POST["Passwd"];
  $repasswd = @$_POST["rePasswd"];

  $firstname = @$_POST["firstname"];
  $lastname = @$_POST["lastname"];
  $nickname = @$_POST["nickname"];
  $datebirth = @$_POST["datebirth"];
  $picExist = @$_POST["picExist"];

  //convert date format
  list($dateofbirth["day"],$dateofbirth["month"],$dateofbirth["year"]) = @explode("-",@$_POST["dateofbirth"]);
  $dob = $dateofbirth["year"]."-".$dateofbirth["month"]."-".$dateofbirth["day"];

  $tel = @$_POST["Tel"];
  $mobile = @$_POST["mobile"];
  $occu = @$_POST["occu"];
  $address = @$_POST["address"];
  $province = @$_POST["province"];
  $amphur = @$_POST["amphur"];
  $zipcode = @$_POST["zipcode"];
  $photo = @$_POST["photo"];
  $added = date("Y-m-d H:i:s");

  $passwd_md5 = md5($passwd);

  $con = @$_POST["con"];
  
  //print md5("khai")."-".$passwd_md5."-".$passwd;
  
  //add success.
    //$sql = "INSERT INTO $TMember (Email,Password,Prefix,FirstName,LastName,NickName,DateBirth,DateOfBirth,Tel,Mobile,Occupation,Zipcode,Address,AMPHUR_ID,PROVINCE_ID,Added) VALUES('$email','$passwd_md5','$prefix','$firstname','$lastname','$nickname','$datebirth','$dob','$tel','$mobile','$occu','$zipcode','$address','$amphur','$province','$added')";
    if($passwd == "" && $repasswd == ""){
       $sql = "UPDATE $TMember SET Email='$email',Prefix='$prefix',FirstName='$firstname',LastName='$lastname',NickName='$nickname',DateBirth='$datebirth',DateOfBirth='$dob',Tel='$tel',Mobile='$mobile',Occupation='$occu',Zipcode='$zipcode',Address='$address',AMPHUR_ID='$amphur',PROVINCE_ID='$province' WHERE MemberID='$MemberID'";
     }else{
       $sql = "UPDATE $TMember SET Email='$email',Password='$passwd_md5',Prefix='$prefix',FirstName='$firstname',LastName='$lastname',NickName='$nickname',DateBirth='$datebirth',DateOfBirth='$dob',Tel='$tel',Mobile='$mobile',Occupation='$occu',Zipcode='$zipcode',Address='$address',AMPHUR_ID='$amphur',PROVINCE_ID='$province' WHERE MemberID='$MemberID'";
     }
   
    $q = mysql_db_query($dbname, $sql) or die($sql);

    if($q){
      $statusAdd = "success";
    }else{
      $statusAdd = "error";
    }  

  //upload pic
  $target_dir = $memberFile;
  $target_file = $target_dir . basename($_FILES["photo"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["photo"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  /*}
  
  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  */
  } else {
    if(is_uploaded_file($_FILES["photo"]["tmp_name"])){
          $fileName = $_FILES["photo"]["name"];
          list($fN,$format) = explode(".", $fileName);
          $fID = $MemberID;
          $nFN = $fID.".".$format;
          //print $nFN ;
          $newName = $memberFile.$nFN;
   
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $newName)) {
              //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              //update tb file path
              if($picExist != "Y"){
                $sql2 = "INSERT INTO $TFilePath(Modules,ItemID,PathUpload,Added) VALUES('member','$fID','$nFN','".date("Y-m-d H:i:s")."')";
                $q2 = mysql_db_query($dbname, $sql2) or die($sql2);
              }
              

              //resize
              $resize = new ResizeImage($newName);
              $resize->resizeTo($cfg["photoProfileWidth"], $cfg["photoProfileHeight"], 'maxWidth');
              $resize->saveImage($newName);

          } else {
              //Upload failed.
              echo "Sorry, there was an error uploading your file.";
          }
    }

  }

  if($con == "profile"){
    print "<meta http-equiv='refresh' content='1;url=".$_SERVER["PHP_SELF"]."'>";
  }else{
    print "<meta http-equiv='refresh' content='1;url=".$_SERVER["PHP_SELF"]."?module=viewmember&MemberID=$MemberID'>";
  }

}

//get list edit
$sql3 = "SELECT * FROM $TMember WHERE MemberID ='$MemberID'";
$q3 = mysql_db_query($dbname, $sql3) or die($sql3);
$resultE = mysql_fetch_array($q3);

$sql4 = "SELECT PathUpload FROM $TFilePath WHERE Modules='member' AND ItemID ='$MemberID'";
$q4 = mysql_db_query($dbname, $sql4) or die($sql4);
$resultP = mysql_fetch_array($q4);


if($resultE["PROVINCE_ID"] == 0){
  $resultE["PROVINCE_ID"] = "";
}

if($resultE["AMPHUR_ID"] == 0){
  $resultE["AMPHUR_ID"] = "";
}
?>
  <script>
  $(document).ready(function(){
    loadProvince("<?=$resultE['PROVINCE_ID'];?>");
    loadAmphur("<?=$resultE['PROVINCE_ID'];?>","<?=$resultE['AMPHUR_ID'];?>");
   

   $("#register-form").validate({
      rules:{
        //email:"required"
        email:{
          required: true,
          email:true,
          highlight:function(){
            $("#class-email").addClass("has-error");
          },
          equalTo:function(){
            var eMail = $("#email").val();

            /*
            $.ajax({
                type:"get",
                url:"ajax/chExistMail.php",
                data:"email="+eMail,
                success:function(data){
                  $("#chEmail").html(data);
                }
              }
            ); 
            */

            var eM = $("#chEmail").text();
            //alert(eM);
            if(eM == "Y"){
              $("#class-email").addClass("has-error");
              return false;
            }

          }
          
        },
        Passwd:{
          required:function(){
            if($("#Passwd").val() == ""){
              return false;
            }
          }
          /*
          ,
          highlight:function(){
            if($("#Passwd").val() != ""){
              $("#class-passwd").addClass("has-error");
            }
          }*/
        },
        rePasswd:{
          required: function(){
            if($("#rePasswd").val() == ""){
              return false;
            }else{
              return true;
            }
          },
          highlight:function(){
            $("#class-re-passwd").addClass("has-error");
          },
          equalTo: "#Passwd"
        },
        prefix:{
          required: true,
          highlight:function(){
            $("#class-prefix").addClass("has-error");
          }
        },
        firstname:{
          required: true,
          highlight:function(){
            $("#class-firstname").addClass("has-error");
          }
        },
        lastname:{
          required: true,
          highlight:function(){
            $("#class-lastname").addClass("has-error");
          }
        },
        dateofbirth:{
          required: true,
          highlight:function(){
            $("#class-dateofbirth").addClass("has-error");
          }
        },
        mobile:{
          required: true,
          highlight:function(){
            $("#class-mobile").addClass("has-error");
          }
        },
        occu:{
          required: true,
          highlight:function(){
            $("#class-occu").addClass("has-error");
          }
        }
          
      },
      messages:{
        email:{
          required:"<span class='txtred'>กรุณากรอกอีเมล์</span>",
          email:"<span class='txtred'>กรุณากรอกรูปแบบอีเมล์ที่ถูกต้อง</span>",
          equalTo:"<span class='txtred'>อีเมล์นี้มีผู้ใช้แล้ว</span>"
        },
        Passwd:"<span class='txtred'>กรุณากรอกรหัสผ่าน</span>",
        rePasswd:{
          required:"<span class='txtred'>กรุณากรอกยินยันรหัสผ่าน</span>",
          equalTo:"<span class='txtred'>กรุณากรอกรหัสผ่านให้ตรงกัน</span>"
        },
        prefix:"<span class='txtred'>กรุณากรอกคำนำหน้าชื่อ</span>",
        firstname:"<span class='txtred'>กรุณากรอกชื่อ</span>",
        lastname:"<span class='txtred'>กรุณากรอกนามสกุล</span>",
        dateofbirth:"<span class='txtred'>กรุณาเลือก วัน/เดือน/ปี เกิด</span>",
        mobile:"<span class='txtred'>กรุณากรอกเบอร์มือถือ</span>",
        occu:"<span class='txtred'>กรุณากรอกอาชีพ</span>"
      },
      unhighlight:function(){
         $( "#class-email").removeClass( "has-error" ).addClass("has-success");
         $( "#class-passwd").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-re-passwd").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-prefix").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-firstname").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-lastname").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-dateofbirth").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-moibile").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-occu").removeClass( "has-error" ).addClass( "has-success" );

      }

     
    });
  });

  $(function(){
    $("#dateofbirth").inputmask("dd-mm-yyyy", 
      {
        "placeholder": "dd-mm-yyyy"
      }
      );
  });

  function getAmphur(){
      loadAmphur($("#province").val(),"");
  }


</script>

<? if($statusAdd == "success"){ ?>
<div class="callout callout-success">
     <h4> <i class="icon fa fa-check"></i> คุณได้แก้ไขข้อมูลสมาชิกสำเร็จ</h4>
      <p>กรุณารอสักครู่ระบบกำลังส่งคุณกล้บไปหน้าแรก</p>
</div>

<? } ?>

<?
if($con == "profile"){
  $headLabel = "แก้ไขข้อมูลส่วนตัว";
}else{
  $headLabel = "แก้ไขข้อมูลสมาชิก";
}
?>
<div class="box box-success">

<form action="<?=$_SERVER["PHP_SELF"]?>?module=<?=$module?>&process=edit" method="post" id="register-form" enctype="multipart/form-data">
<input type="hidden" name="MemberID" value="<?=$MemberID?>">
<input type="hidden" name="con" value="profile">

                <div class="box-header">
                  <h3 class="box-title"><?=$headLabel;?></h3>
                </div>

              <div class="box-body">
                <label>:: อีเมล์ ::</label>
                  <div class="input-group " id="class-email">
                      <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                      </div>
                      <input type="text" class="form-control" name="email" id="email" value="<?=$resultE["Email"]?>"> 
                    </div>
                    <span id="chEmail" style="display:none;"></span>
                </div><!-- /.box-body -->

                <div class="box-body">
                <label>:: รหัสผ่าน ::</label>
                  <div class="input-group" id="class-passwd">
                      <div class="input-group-addon">
                        <i class="fa  fa-key"></i>
                      </div>
                      <input type="password" class="form-control" name="Passwd" id="Passwd">
                    </div>
                </div><!-- /.box-body -->

              <div class="box-body">
                <label>:: ยินยันรหัสผ่าน ::</label>
                  <div class="input-group" id="class-re-passwd">
                      <div class="input-group-addon">
                        <i class="fa  fa-key"></i>
                      </div>
                      <input type="password" class="form-control" name="rePasswd" id="rePasswd">
                    </div>
                </div><!-- /.box-body -->

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>

                <div class="box-body">
                <label>:: คำนำหน้า ::</label>
                  <div class="input-group" id="class-prefix">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <input type="text" class="form-control" name="prefix" id="prefix" value="<?=$resultE["Prefix"]?>">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-body">
                <label>:: ชื่อ ::</label>
                  <div class="input-group" id="class-firstname">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <input type="text" class="form-control" name="firstname" id="firstname" value="<?=$resultE["FirstName"]?>">
                    </div>
                </div><!-- /.box-body -->

                 <div class="box-body">
                <label>:: นามสกุล ::</label>
                  <div class="input-group" id="class-lastname">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$resultE["LastName"]?>">
                    </div>
                </div><!-- /.box-body -->

                 <div class="box-body">
                <label>:: ชื่อเล่น ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <input type="text" class="form-control" name="nickname" id="nickname" value="<?=$resultE["NickName"]?>">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-body">
                <label>:: วันเกิด ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <select class="form-control" name="datebirth">
                        <option value="1" <? if($resultE["DateBirth"] == "1"){ print "selected"; }?>>วันอาทิตย์</option>
                        <option value="2" <? if($resultE["DateBirth"] == "2"){ print "selected";}?>>วันจันทร์</option>
                        <option value="3" <? if($resultE["DateBirth"] == "3"){ print "selected";}?>>วันอังคาร</option>
                        <option value="4" <? if($resultE["DateBirth"] == "4"){ print "selected";}?>>วันพุธ</option>
                        <option value="5" <? if($resultE["DateBirth"] == "5"){ print "selected";}?>>วันพฤหัสบดี</option>
                        <option value="6" <? if($resultE["DateBirth"] == "6"){ print "selected";}?>>วันศุกร์</option>
                        <option value="7" <? if($resultE["DateBirth"] == "7"){ print "selected";}?>>วันเสาร์</option>
                      </select>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-body">
                <label>:: วัน/เดือน/ปี เกิด ::</label>
                  <div class="input-group" id="class-dateofbirth">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?
                        //convert date format
                        list($dateofbirth["year"],$dateofbirth["month"],$dateofbirth["day"]) = @explode("-",$resultE["DateOfBirth"]);
                        $dob = $dateofbirth["day"]."-".$dateofbirth["month"]."-".$dateofbirth["year"];
                      ?>
                      <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" name="dateofbirth" id="dateofbirth" value="<?=$dob?>">
                    </div>
                </div><!-- /.box-body -->   

                <div class="box-body">
                <label>:: เบอร์โทรศัพท์บ้าน ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control" name="Tel" value="<?=$resultE["Tel"]?>">
                    </div>
                </div><!-- /.box-body -->

                 <div class="box-body">
                <label>:: เบอร์โทรศัพท์มือถือ ::</label>
                  <div class="input-group" id="class-mobile">
                      <div class="input-group-addon">
                        <i class="fa fa-mobile-phone"></i>
                      </div>
                      <input type="text" class="form-control" name="mobile" id="mobile" value="<?=$resultE["Mobile"]?>">

                    </div>
                </div><!-- /.box-body -->

                 <div class="box-body">
                <label>:: อาชีพ ::</label>
                  <div class="input-group" id="class-occu">
                      <div class="input-group-addon">
                        <i class="fa fa-user-secret"></i>
                      </div>
                      <input type="text" class="form-control" name="occu" id="occu" value="<?=$resultE["Occupation"]?>">

                    </div>
                </div><!-- /.box-body -->
        

                   <div class="box-body">
                <label>:: ที่อยู่ ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <textarea class="form-control" rows="3" placeholder="" name="address"><?=$resultE["Address"]?></textarea>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-body">
                <label>:: จังหวัด ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <span id="privince-area"></span>
                    </div>
                </div><!-- /.box-body -->

              <div class="box-body">
                <label>:: อำเภอ ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                      <span id="amphur-area"></span>
                    </div>
                </div><!-- /.box-body -->


              <div class="box-body">
                <label>:: รหัสไปรษณีย์ ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-circle-thin"></i>
                      </div>
                     <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?=$resultE["Zipcode"]?>">
                    </div>
                    
                </div><!-- /.box-body -->


              <div class="box-body">
                <label>:: รูปสมาชิก ::</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-file-image-o"></i>
                      </div>
                      <input type="file" class="form-control" name="photo" id="photo">
                      <? if($resultP["PathUpload"] != ""){ ?>
                          <img src="<?=$memberFile.$resultP["PathUpload"]?>?t=<?=time();?>" width="150" class="img-circle">
                          <input type="hidden" value="Y" name="picExist">
                     <? } ?>
                      
                    </div>

                    <br>
                    <table align="right" border="0" width="20%" style="margin-top:5px;">
                      <tr>
                        <td align="left">
                          <button type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat" onclick="location.href='indexhome.php'" style="width:100px;"><i class="fa fa-times-circle"></i> ยกเลิก</button>

                        </td>
                        <td align="right">
                          <button class="btn btn-block btn-social btn-primary btn-block btn-flat">
                          <i class="fa  fa-save"></i> บันทึก
                        </button>
                      </tr>
                    </table>


                </div><!-- /.box-body -->


  </form>
</div>
 

