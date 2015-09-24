<?
session_start();
include "includes/config.php";
include "includes/db.php";


include "Class/Auth.php";
include "Class/Datethai.php";
include "Class/ResizeImage.php";

include "function/string.php";
include "function/address.php";
include "function/getAll.php";


$auth = new Auth();
$Datethai = new Datethai();

$module = @$_GET[module];
$con = @$_GET["con"];
$view = @$_GET["view"];
$MemberID = @$_GET["MemberID"];
$ParentID = @$_GET["ParentID"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?=$cfg["title"];?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
     <link href="css/general.css" rel="stylesheet" type="text/css" />

     <link rel="stylesheet" href="plugins/jquery-ui-1.11.4/jquery-ui.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

     <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    

    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>

    <script src="plugins/validate/jquery.validate.js" type="text/javascript"></script>


    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

    <script src="plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="plugins/jQueryUI/jquery-ui.js" type="text/javascript"></script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

  
    <script src="js/main.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        //alert('x');
        loadSummaryMember();
        loadSummaryLeader();
        loadSummaryChild();
        loadSummaryWaitingList();
      });
    </script>
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
  
<div id="dialog-check" title="ไม่สามารถเพิ่มลูกทีมได้" style="display:none;">
  <p>
  คุณไม่สามารถเพิ่มลูกทีมได้<br>เนื่องจากคุณยังไม่ได้ถูกยืนยันการเป็นสมาชิก</p>
</div>
<div id="dialog-check-max" title="ไม่สามารถเพิ่มลูกทีมได้" style="display:none;">
  <p>
  คุณไม่สามารถเพิ่มลูกทีมได้<br>เนื่องจากระบบกำหนดให้ทีมคุณมีได้ไม่เกิน <?=@$cfg[subMember]+1;?> คน</p>
</div>

    <div class="wrapper" id="box-index">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="indexhome.php" class="navbar-brand"><b><?=$cfg["headerIndex"];?></b></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <!--
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
              -->
              <!--
              <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
              </form>     
              -->
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  

                <? if($auth->checkAuth() == true ){ ?>
                  <!-- Notifications Menu -->                 
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?=@$_SESSION[Member][Photo];?>" class="user-image " alt="User Image"/>
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><? print @$_SESSION[Member][FirstName]." ".@$_SESSION[Member][LastName];?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="<?=@$_SESSION[Member][Photo];?>" class="img-circle"  alt="User Image"/>
                        <p>
                          <? print @$_SESSION[Member][FirstName]." ".@$_SESSION[Member][LastName];?>
                          <small><? print @$_SESSION[Member][Email];?></small>
                          <small>เป็นสมาชิกเมื่อ : <?=@$_SESSION[Member][Created]?></small>
                        </p>
                      </li>
                      
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="<?=$_SERVER["PHP_SELF"]?>?module=editregister&con=profile" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                        </div>
                        <div class="pull-right">
                          <a href="logout.php" class="btn btn-default btn-flat">ออกจากระบบ</a>
                        </div>
                      </li>
                    </ul>
                  </li>

             <? }else{ ?>
             <?
              
             ?>
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="login.php">
                      <i class="fa fa-sign-in">&nbsp;เข้าสู่ระบบ</i>
                     
                    </a>
                    
                  </li>
             <? }//end if account menu?>

                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">

            <h1>
             
             <small>
              <ol class="breadcrumb">
              <li><a href="<?=$_SERVER["PHP_SELF"];?>"><i class="fa fa-dashboard"></i> Home</a></li>
              <? 
              if($module == "contactus"){
                print "<li class=\"active\">ติดต่อเรา</li>";
              }

              if($module == "register"){
                if($con == "child"){
                  print "<li class=\"active\">เพิ่มลูกทีม</li>";
                }else{
                  print "<li class=\"active\">ลงทะเบียนสมาชิกใหม่</li>";
                }
              }

              if($module == "searchmember"){
                print "<li class=\"active\">ค้นหาช้อมูลสมาชิก</li>";

              }

              if($module =="waitinglist"){
                print "<li class=\"active\">สมาชิกรอยืนยัน</li>";
              }

              if($module =="editregister" && $con == "profile"){
                print "<li class=\"active\">แก้ไขข้อมูลส่วนตัว</li>";
              }else if($module =="editregister"){
                print "<li class=\"active\">แก้ไขข้อมูลสมาชิก</li>";
              }

              if($module == "viewmember"){
                print "<li class=\"active\"><a href=\"indexhome.php?module=searchmember\">ค้นหาช้อมูลสมาชิก</a></li>";
                if($ParentID != "" && $ParentID != 0  ){
                  print "<li class=\"active\"><a href=\"".$_SERVER["PHP_SELF"]."?module=viewmember&MemberID=".$ParentID."\"> : หัวหน้าทีม : ".getName($ParentID)."</a></li>";
                }
                print "<li class=\"active\">".getName($MemberID)."</li>";
                
              }
              ?>

            </ol>
            </small>
            </h1>
            
            <!-- Menu main -->
         <? if($module == ""){ ?>
          <div class="row" style="margin-top:20px;">
          <? if(@$_SESSION["Member"]["MemberType"] == "U"){ ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="javascript:addChild('<?=$_SESSION["Member"]["MemberID"]?>','<?=getActivate($_SESSION["Member"]["MemberID"]);?>','<?=getOver($_SESSION["Member"]["MemberID"])?>')">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?=$menuName["registerChild"]["th"];?> (<?=getAllChild(@$_SESSION["Member"]["MemberID"]);?>)</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <?=$menuName["registerChild"]["en"];?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </a>
            </div><!-- /.col -->

            <? } else { ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?=@$_SERVER[PHP_SELF]?>?module=register">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?=$menuName["register"]["th"];?></span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <?=$menuName["register"]["en"];?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </a>
            </div><!-- /.col -->

            <? } ?>

            
            <? if($auth->authMainMenu()){ ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?=@$_SERVER[PHP_SELF]?>?module=searchmember">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-search"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?=$menuName["searchMember"]["th"];?></span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <?=$menuName["searchMember"]["en"];?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              </a>
            </div><!-- /.col -->
            <? } ?>
             <? if($auth->authMainMenu()){ ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?=@$_SERVER[PHP_SELF]?>?module=waitinglist">
              <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa  fa-list"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?=$menuName["waitingList"]["th"];?></span>
 
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <?=$menuName["waitingList"]["en"];?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              </a>
            </div><!-- /.col -->
            <? } ?>

            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?=@$_SERVER[PHP_SELF]?>?module=contactus">
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-whatsapp"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"><?=$menuName["contactsUs"]["th"];?></span>
        
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <?=$menuName["contactsUs"]["en"];?>
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            </a>
          </div>
          <? } ?>
            <!-- End Menu main -->
            

            <? if($module =="" && @$_SESSION["Member"]["MemberType"] == "A"){?>
              <div class="box box-success" >

                <div class="box-header with-border">
                  <h3 class="box-title">ภาพรวมสมาชิก</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" >
                  
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12" id="allMember">

                      <div class="info-box" style="background-color:#deecef;" >
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content" >
                          <span class="info-box-text">สมาชิกทั้งหมด</span>
                          <span class="info-box-number" id="allMember-r"><small>%</small></span>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12" id="allLeader">
                      <div class="info-box" style="background-color:#deecef;">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">หัวหน้าทีม</span>
                          <span class="info-box-number" id="allLeader-r">41,410</span>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div><!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12" id="allChild">
                      <div class="info-box" style="background-color:#deecef;">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">ลูกทีม</span>
                          <span class="info-box-number" id="allChild-r">760</span>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12" id="allWaitingList">
                      <div class="info-box" style="background-color:#deecef;">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">สมาชิกรอยืนยัน</span>
                          <span class="info-box-number" id="allWaitingList-r">2,000</span>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div><!-- /.col -->
                  </div>  
                </div><!-- /.box-body -->

              </div>
            <? } ?>

            <? if($module =="" && $_SESSION["Member"]["MemberType"] == "U"){ ?>
              <div class="box-body no-padding" >
                  
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12" id="allMember">

                      <div class="info-box" style="background-color:#deecef;" >
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text"><strong>รหัสสมาชิก</strong></span>
                          <span class="info-box-number" ><h2 class="text-red"><?=$_SESSION["Member"]["MemberCode"];?></h2></span>
                        </div><!-- /.info-box-content -->
                      </div><!-- /.info-box -->
                    </div><!-- /.col -->
                   
                   
                  </div>  
                </div><!-- /.box-body -->
            <? } ?>
          </section>

           <?
          if($module != ""){
              include "modules/".$module.".php";
          }
           ?>
          

        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong>Copyright &copy; 2014-<? print date("Y"); ?> &nbsp;All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

   

  </body>
</html>

<?
@mysql_close();
?>
