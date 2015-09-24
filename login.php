<?
session_start();
include "includes/config.php";
include "includes/db.php";
include "Class/Auth.php";

//check logined 
$auth = new Auth();
if($auth->checkAuth()){
  print "<meta http-equiv='refresh' content='0;url=indexhome.php'>";
}
//end check login

$process = @$_GET["process"];
if($process == "login"){
	
	$email = @$_POST["email"];
	$password = @md5($_POST["password"]);
	

	$sql = "SELECT MemberID,MemberCode,FirstName,LastName,MemberType,Added FROM $TMember WHERE Email = '$email' AND Password ='$password' AND Status='A'";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$row = mysql_num_rows($q);

  if($row == 0){
    $sql2 = "SELECT MemberID,MemberCode,FirstName,LastName,MemberType,Added FROM $TMember WHERE Mobile = '$email' AND Password ='$password' AND Status='A'";
    $q2 = mysql_db_query($dbname, $sql2) or die($sql2);
    $row = mysql_num_rows($q2);
    $result = mysql_fetch_array($q2);
  }else{
    $result = mysql_fetch_array($q);
  }

	
	
	if($row > 0){
    $sql1 = "SELECT Modules,ItemID,PathUpload FROM $TFilePath WHERE Modules='member' AND ItemID='$result[MemberID]'";
    $q1 = mysql_db_query($dbname, $sql1) or die($sql1);
    $rowPic = mysql_num_rows($q1);
    $resultPath = mysql_fetch_array($q1);
    if($rowPic > 0){
      @$_SESSION[Member][Photo] = $memberFile.$resultPath[PathUpload];
    }else{
      @$_SESSION[Member][Photo] = $memberFile."avatar.png";
    }
    

		@$_SESSION[Member][MemberID] = $result[MemberID];
		@$_SESSION[Member][MemberCode] = $result[MemberCode];
		@$_SESSION[Member][Email] = $email;
		@$_SESSION[Member][FirstName] = $result[FirstName];
		@$_SESSION[Member][LastName] = $result[LastName];
		@$_SESSION[Member][MemberType] = $result[MemberType];
    @$_SESSION[Member][Created] = $result[Added];

		$loginWarning = "";
    
    print "<meta http-equiv='refresh' content='0;url=indexhome.php'>";

	}else{
		$loginWarning = "Login Failed!";
	}

}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><? print @$cfg[title];?> : Login</title>
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
        
        <form action="login.php?process=login" method="post">
          <div class="form-group has-feedback">
            <input name="email" type="text" class="form-control" placeholder="Email or Telephone number" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            
             <table align="right" border="0" width="100%" style="margin-top:5px;">
                    <tr>
                      <td align="right">
                  <button type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat" onclick="location.href='indexhome.php'" style="width:120px;"><i class="fa fa-times-circle"></i>ยกเลิก</button>
       
                  </td>
                      <td align="right" width="130"><button type="submit" class="btn btn-block btn-social btn-primary btn-block btn-flat" style="width:120px;"> <i class="fa fa-sign-in"></i>เข้าสู่ระบบ</button></td>
                    </tr>
                    <tr>
                      <td align="left" colspan="2" style="padding-top:10px;"><a href="forgotpassword.php">[ ลืมรหัสผ่าน ]</a></td>
                    </tr>
                    <tr>
                      <td align="right" colspan="2"><span class="text-red"><?=@$loginWarning;?></span></td>
                    </tr>
                    </table>

                    
          </div>
         
        </form>

      <br><br><br>
        

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
