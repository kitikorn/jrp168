<script type="text/javascript">
$(document).ready(function() {
    //console.log( eady!" );
    loadListWaitingList();

});


function loadActivate(MemberID){
	//alert(MemberID);
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
		"ยืนยัน": function() {
		$("#box-success" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
			$.ajax({
				type:"get",
				url:"ajax/p-activatemember.php",
				data:"MemberID="+MemberID,
				success:function(data){
				  $("#box-success").html(data);
				  $("#info-success").show();
				  $(".overlay").remove();
          loadListWaitingList();
				}
			}
		);
        	loadListWaitingList();
          $( this ).dialog( "close" );
        },
        ยกเลิก: function() {
          $( this ).dialog( "close" );
        }
      }
    });
}


</script>

<div class="callout callout-success" id="info-success" style="display:none;">
     <h4> <i class="icon fa fa-check"></i> คุณได้ยืนยันสมาชิกสำเร็จ</h4>
</div>

<div id="dialog-confirm" title="ยืนยันสมาชิกใหม่ ?" style="display:none;">
  <p>
  คุณต้องการยืนยันสมาชิกใหม่ท่านนี้ใช่หรือไม่</p>
</div>




<div id="box-success"></div>
