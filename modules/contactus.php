 <script>
  $(document).ready(function(){

   $("#form-contactus").validate({
      rules:{
        //email:"required"
        email:{
          required: true,
          email:true,
          highlight:function(){
            $("#class-email").addClass("has-error");
          }          
        },
        title:{
          required: true,
          highlight:function(){
            $("#class-title").addClass("has-error");
          }
        },
         description:{
          required: true,
          highlight:function(){
            $("#class-description").addClass("has-error");
          }
        },
        tel:{
          required: true,
          highlight:function(){
            $("#class-tel").addClass("has-error");
          }
        },
        sender:{
          required: true,
          highlight:function(){
            $("#class-sender").addClass("has-error");
          }
        }
          
      },
      messages:{
        email:{
          required:"<span class='txtred'>กรุณากรอกอีเมล์</span>",
          email:"<span class='txtred'>กรุณากรอกรูปแบบอีเมล์ที่ถูกต้อง</span>"
        },
        title:"<span class='txtred'>กรุณากรอกห้อข้อคิดต่อ</span>",
        description:"<span class='txtred'>กรุณากรอกรายละเอียดการติดต่อ</span>",
        tel:"<span class='txtred'>กรุณากรอกเบอร์โทรศัพท์ของท่าน</span>",
        sender:"<span class='txtred'>กรุณากรอกชื่อผู้ส่งข้อความ</span>",
        
      },
      unhighlight:function(){
         $( "#class-email").removeClass( "has-error" ).addClass("has-success");
         $( "#class-title").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-description").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-tel").removeClass( "has-error" ).addClass( "has-success" );
         $( "#class-sender").removeClass( "has-error" ).addClass( "has-success" );
      }

     
    });
  });

 

</script>
<?
$process = @$_GET["process"];
if($process == "send"){
	$title = $_POST["title"];
	$description = $_POST["description"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$sender = $_POST["sender"];


	$Subject = "มีผู้ติดต่อจาก http://www.jrp168.com";
    $Message = "หัวข้อ : ".$title."\n";
    $Message .= "รายละเอียด : ".$description."\n";
    $Message .= "เบอร์โทรศัพท์ : ".$tel."\n";
    $Message .= "อีเมล์ : ".$email."\n";
    $Message .= "ผู้ส่ง : คุณ".$sender."\n";
    

    $m = mail($mailContact,$Subject,$Message,$email);
    if($m){
        @$check = "success";
        print "<meta http-equiv='refresh' content='3;url=indexhome.php'>";
    }else{
       	@$check = "failed";

    }
  }


?>
<? if(@$check == "success") {?>
<div class="alert alert-success alert-dismissable">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
            เราได้รับข้อความของคุณแล้ว !
      </div>

<? }else if(@$check =="failed"){ ?>
	<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    เราไม่สามารรถส่งข้อความได้ กรุณาติดต่อผู้ดูแลระบบ
                  </div>
<? } ?>
<form id="form-contactus" action="<?=@$_SERVER[PHP_SELF]?>?module=contactus&process=send" method="post">
<div class="col-md-13">

              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">ติดต่อเรา</h3>
                </div>
                <!--
                <div class="box-body">
                  <h7 class="box-title">บริษัท xxxx จำกัด</h7>
                </div>
				-->
                <div class="box-body">
                  <!-- Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>:: หัวข้อ ::</label>
                    <div class="input-group" id="class-title">
                      <div class="input-group-addon">
                        <i class="fa fa-newspaper-o"></i>
                      </div>

                      <input type="text" class="form-control" name="title" id="title">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->

                  <!-- Date mm/dd/yyyy -->
                  <div class="form-group">
                  <label>:: รายละเอียด ::</label>
                    <div class="input-group" id="class-description">
                      <div class="input-group-addon">
                        <i class="fa fa-comment"></i>
                      </div>
                     <textarea class="form-control" rows="3" placeholder="" name="description" id="description"></textarea>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->

                  <!-- phone mask -->
                  <div class="form-group">
                    <label>:: เบอร์โทรศัพท์ ::</label>
                    <div class="input-group" id="class-tel">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control" name="tel"  id="tel">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->

                  <!-- phone mask -->
                  <div class="form-group">
                    <label>:: อีเมล์ ::</label>
                    <div class="input-group" id="class-email">
                      <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                      </div>
                      <input type="text" class="form-control" name="email"  id="email">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  <!-- phone mask -->
                  <div class="form-group">
                    <label>:: ชื่อผู้ส่ง ::</label>
                    <div class="input-group" id="class-sender">
                      <div class="input-group-addon">
                        <i class="fa f fa-user"></i>
                      </div>
                      <input type="text" class="form-control" name="sender"  id="sender">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->

                  
                   <table align="right" border="0" width="23%" style="margin-top:5px;">
                      <tr>
                        <td align="left">
                          <button  type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat" onclick="location.href='indexhome.php'" style="width:100px;"><i class="fa fa-times-circle"></i> ยกเลิก</button>

                        </td>
                        <td align="right">
                          <button class="btn btn-block btn-social btn-primary btn-block btn-flat">
                          <i class="fa  fa-comment"></i> ส่งข้อความ
                        </button>
                      </tr>
                    </table>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              

               

                </div><!-- /.box-body -->

              </div><!-- /.box -->
			
            </div>
            </form>
            