 function loadAmphur(ProvinceID,AmphurID){
     $.ajax({
                type:"get",
                url:"ajax/amphur.php",
                data:"ProvinceID="+ProvinceID+"&AmphurID="+AmphurID,
                success:function(data){
                  $("#amphur-area").html(data);
                }
              }
        );
  }

  function loadProvince(ProvinceID){
      $.ajax({
                type:"get",
                url:"ajax/province.php",
                data:"ProvinceID="+ProvinceID,
                success:function(data){
                  $("#privince-area").html(data);
                }
              }
        );
  }

  function loadListMember(condition,memberCode,firstName,lastName,memberType,page){
      $(".box-success" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
      $.ajax({
                type:"get",
                url:"ajax/listmember.php",
                data:"condition="+condition+"&memberCode="+memberCode+"&firstName="+firstName+"&lastName="+lastName+"&memberType="+memberType+"&page="+page,
                success:function(data){
                  $("#area-listmember").html(data);
                  $(".overlay").remove();
                }
              }
        );
  }

  function loadListWaitingList(){
    $("#box-success" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
      $.ajax({
                type:"get",
                url:"ajax/listwaitinglist.php",
                data:"condition=test",
                success:function(data){
                  $("#box-success").html(data);
                  $(".overlay").remove();
                }
              }
      );
  }

  function searchMember(){
  var memberCode = $("#memberCode").val();
  var firstName = $("#firstname").val();
  var lastName = $("#lastname").val();
  var memberType = $("#memberType").val();
  

  loadListMember("A",memberCode,firstName,lastName,memberType,"1");
  $("#info-success").hide();
}


  function delMember(MemberID){
  //alert(MemberID);
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
    "ลบ": function() {
    $("#box-success" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
      $.ajax({
        type:"get",
        url:"ajax/p-delmember.php",
        data:"MemberID="+MemberID,
        success:function(data){
          $("#area-listmember").html(data);
          $("#info-success").show();
          $(".overlay").remove();
        }
      }
    );
          searchMember();
          $("#info-success").show();
          $( this ).dialog( "close" );
        },
        ยกเลิก: function() {
          $( this ).dialog( "close" );
        }
      }
    });

}

 function delMemberS(MemberID){
  //alert(MemberID);
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
    "ลบ": function() {
    
      $.ajax({
        type:"get",
        url:"ajax/p-delmember.php",
        data:"MemberID="+MemberID,
        success:function(data){
          //$("#area-listmember").html(data);
          location.reload();
          //$("#info-success").show();
          //$(".overlay").remove();
        }
      }
    );

          $( this ).dialog( "close" );
        },
        ยกเลิก: function() {
          $( this ).dialog( "close" );
        }
      }
    });

}

function addChild(MemberID,Exist,Over){
  if(MemberID ==0){
    var url = "indexhome.php?module=register&con=child";
  }else{
    var url = "indexhome.php?module=register&con=child&MemberID="+MemberID;
  }
  
  if(Exist == "N"){
    $( "#dialog-check" ).dialog({
        resizable: false,
        height:200,
        modal: true,
        buttons: {

          ยกเลิก: function() {
            $( this ).dialog( "close" );
          }
        }
      });
  }else if(Over == "Y"){
    $( "#dialog-check-max" ).dialog({
        resizable: false,
        height:200,
        modal: true,
        buttons: {

          ยกเลิก: function() {
            $( this ).dialog( "close" );
          }
        }
      });
  }else{
    
    $(location).attr("href", url);
  }
}

function loadHistoryAngur(MemberID){

  //$(".box-index" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
  $.ajax({
        type:"get",
        url:"ajax/historyAngur.php",
        data:"MemberID="+MemberID,
        success:function(data){
          $("#history-angur").html(data);
          $(".overlay").remove();
        }
      }
    );
}

function loadSummaryMember(){
  $("#allMember" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
  $.ajax({
        type:"get",
        url:"ajax/summaryMember.php",
        data:"type=A",
        success:function(data){
          $("#allMember-r").html(data);
          $(".overlay").remove();
        }
      }
    );
}

function loadSummaryLeader(){
  $("#allLeader" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
  $.ajax({
        type:"get",
        url:"ajax/summaryMember.php",
        data:"type=L",
        success:function(data){
          $("#allLeader-r").html(data);
          $(".overlay").remove();
        }
      }
    );
}

function loadSummaryChild(){
   $("#allChild" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
  $.ajax({
        type:"get",
        url:"ajax/summaryMember.php",
        data:"type=C",
        success:function(data){
          $("#allChild-r").html(data);
          $(".overlay").remove();
        }
      }
    );
}

function loadSummaryWaitingList(){
   $("#allWaitingList" ).append( "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
  $.ajax({
        type:"get",
        url:"ajax/summaryMember.php",
        data:"type=W",
        success:function(data){
          $("#allWaitingList-r").html(data);
          $(".overlay").remove();
        }
      }
    );
}

