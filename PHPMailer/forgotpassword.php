<?
session_start();
include "includes/config.php";
include "Class/Auth.php";

include "PHPMailer/PHPMailerAutoload.php";
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

  print_r($mailSend);
  print_r($result);


    $mail = new PHPMailer();

    $body = "xx";

    $mail->IsSMTP(); // telling the class to use SMTP
    //$mail->Host       = "61.91.6.232"; // SMTP server
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "kitikorn.y@gmail.com";  // GMAIL username
    $mail->Password   = "skru2012";            // GMAIL password
    
    $mail->SetFrom("kitikorn.y@gmail.com", '$name');
    
    $mail->Subject = '$subject';
  
    $mail->MsgHTML($body);
    
    $mail->AddAddress('kitikorn.y@gmail.com');
    
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "Message sent!";
    }

    /*
    $m = mail("kitikorn.y@gmail.com","tst","message","jrp168.com");
    if($m){
        print "ok";
    }else{
      print "err";
    }
    */
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
        
        <form action="forgotpassword.php?process=forgot" method="post">
          <div class="form-group has-feedback">
            <input name="email" type="email" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <span class="text-red" >** กรุณากรอกอีเมล์ ระบบจะส่งรหัสผ่านใหม่ไปให้ท่าน</span>
          <div class="row">
            <div class="col-xs-8">    
            
            </div><!-- /.col -->
            <div class="col-xs">

            <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
            <button type="button" class="btn btn-primary btn-block btn-danger" onclick="location.href='indexhome.php'">Cancel</button>
              
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
