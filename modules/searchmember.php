
<?
$module = @$_GET["module"];
$process = @$_GET["process"];
$statusAdd = "0";
?>
<script>

</script>

<div class="callout callout-success" id="info-success" style="display:none;">
     <h4> <i class="icon fa fa-check"></i> คุณได้ทำการลบสมาชิกสำเร็จ</h4>
</div>

<div id="dialog-confirm" title="ลบสมาชิก ?" style="display:none;">
  <p>
  การลบสมาชิกหลัก จะทำให้ลูกทีมถูกลบไปด้วย<br>คุณแน่ใจจะลบหรือไม่ ?</p>
</div>



<div class="box box-success" id="box-main">
  <div class="box-header with-border">
      <h3 class="box-title">ค้นหาข้อมูลสมาชิก</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div><!-- /.box-header -->

<div class="box-body">
    <label>:: ประเภทสมาชิก ::</label>
    <div class="input-group " id="class-type-member">
        <div class="input-group-addon">
          <i class="fa fa-circle-thin"></i>
        </div>
        <select class="form-control" name="memberType" id="memberType">
          <option value="U">-- หน้าหน้าทีม --</option>
          <option value="S">-- ลูกทีม --</option>
        </select>
      </div>
  </div><!-- /.box-body -->

  <div class="box-body">
    <label>:: รหัสสมาชิก ::</label>
    <div class="input-group " id="class-email">
        <div class="input-group-addon">
          <i class="fa fa-circle-thin"></i>
        </div>
        <input type="text" class="form-control" name="memberCode" id="memberCode"> 
      </div>
  </div><!-- /.box-body -->


  <div class="box-body">
    <label>:: ชื่อ ::</label>
    <div class="input-group" id="class-firstname">
        <div class="input-group-addon">
          <i class="fa fa-circle-thin"></i>
        </div>
        <input type="text" class="form-control" name="firstname" id="firstname">
      </div>
  </div><!-- /.box-body -->

 
   <div class="box-body">
    <label>:: นามสกุล ::</label>
    <div class="input-group" id="class-lastname">
        <div class="input-group-addon">
          <i class="fa fa-circle-thin"></i>
        </div>
        <input type="text" class="form-control" name="lastname" id="lastname">

    </div>
     <table align="right" border="0" width="20%" style="margin-top:5px;">
      <tr>
        <td align="left">
          <button type="button" class="btn btn-block btn-social btn-danger btn-block btn-flat" onclick="location.href='indexhome.php'" style="width:100px;"><i class="fa fa-times-circle"></i> ยกเลิก</button>

    </td>
        <td align="right">
        <button class="btn btn-block btn-social btn-primary btn-block btn-flat" onclick="return searchMember()">
                    <i class="fa fa-search"></i> ค้นหา
                  </button>
      </tr>
      </table>
  </div>
</div>
<div id="area-listmember">

</div>


