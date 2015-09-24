
<?
session_start();
include "includes/config.php";
include "includes/db.php";
include "includes/string.php";
include "Class/Auth.php";


//include "PHPMailer/PHPMailerAutoload.php";
//include "PHPMailer/class.phpmailer.php";
//include "PHPMailer/class.smtp.php";
//include "PHPMailer/phpmailer_helper.php";
//include "PHPMailer/phpmailer_worker_helper.php";
//end check login


$process = @$_GET["process"];
if($process == "forgot"){
	
	$email = @$_POST["email"];

	$sql = "SELECT MemberID,MemberCode,FirstName,LastName,Email FROM $TMember WHERE Email = '$email' AND Status='A'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$row = mysql_num_rows($q);
	$result = mysql_fetch_array($q);

  $txtWarning = "";

  if($row > 0){
    $to = $result["Email"];
    $NewPassword = RandomString();

    $Subject = "http://www.jrp168.com : ส่งรหัสผ่านใหม่";
    $Message = "คุณ".$result[FirstName]." ".$result[LastName]." ";
    $Message .= "รหัสผ่านใหม่ของคุณคือ : ".$NewPassword;
    $From = "http://www.jrp168.com ";
    
    $NewPass = md5($NewPassword);

    $m = mail($to,$Subject,$Message,$From);
    if($m){
        $txtWarning["statusMail"] = "ระบบทำการเปลี่ยนรหัสผ่านให้คุณเรียบร้อยแล้ว <br>กรุณาตรวจสอบอีเมล์";
        $sql2 = "UPDATE $TMember SET Password ='$NewPass' WHERE Email='$result[Email]'";
        $q2 = mysql_db_query($dbname, $sql2) or die($sql2);
        print "<meta http-equiv='refresh' content='3;url=login.php'>";
    }else{
        $txtWarning["statusMail"] = "ไม่สามารถส่งอีเมล์ได้ กรุณาติดต่อผู้ดูแลระบบ";
    }

  }else{
      $txtWarning["statusMail"] = "ไม่พบอีเมล์นี้ในระบบ";
  }
    
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><? print @$cfg[systemName];?> : Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="indexhome.php"><b><? print @$cfg[systemName];?></b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        
        <form action="forgotpassword.php?process=forgot" method="post" id="form-forgot">
          <div class="form-group has-feedback">
            <input name="email" type="email" class="form-control" placeholder="Email" required/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <span class="text-red" ><?=@$txtWarning["statusMail"];?></span>
           <table align="right" border="0" width="100%" style="margin-top:5px;">
                    <tr>
                      <td align="right">
                  <button type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat" onclick="location.href='indexhome.php'" style="width:130px;"><i class="fa fa-times-circle"></i>ยกเลิก</button>
       
                  </td>
                      <td align="right" width="140"><button type="submit" class="btn btn-block btn-social btn-primary btn-block btn-flat" style="width:130px;"> <i class="fa fa-sign-in"></i>ส่งรหัสผ่าน</button></td>
                    </tr>
                    
                    
                    </table>
          <div class="row">
            <div class="col-xs-8">    
            
            </div><!-- /.col -->
            <div class="col-xs">

         
              
            </div><!-- /.col -->
          </div>
        </form>

       

        
        

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
<?
mysql_close();
?>
<script>
$("#form-forgot").validate();
</script>
