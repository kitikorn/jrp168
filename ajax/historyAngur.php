<?
include "../includes/config.php";
include "../includes/db.php";

$MemberID = @$_GET["MemberID"];
?>



   
 <ul class="timeline">

	<!-- timeline time label -->
	<?
	$sql = "SELECT Title,Description,Added FROM $TMemberTransaction WHERE MemberID='$MemberID' ORDER BY TransactionID DESC";
	$q = mysql_db_query($dbname, $sql) or die($sql);
	$row = mysql_num_rows($q);
	$dateRun = array();
	if($row >0){
		while($result=mysql_fetch_array($q)){
			$date = explode(" ",$result["Added"]);
		
			if(!in_array($date[0], $dateRun)){
	?>
				<li class="time-label">
				    <span class="bg-red">
				        <?=$date[0];?>
				    </span>
				</li>
				<!-- /.timeline-label -->

				<!-- timeline item -->
				<li>
				    <!-- timeline icon -->
				    <? 
				    $sql2 = "SELECT Title,Description,Added FROM $TMemberTransaction WHERE MemberID='$MemberID' AND Added LIKE '".$date[0]."%' ORDER BY Added DESC"; 
				    $q2 = mysql_db_query($dbname, $sql2) or die($sql2);
				   // print $sql2;
				    while($resultS = mysql_fetch_array($q2)){
				    	$dateS = explode(" ",$resultS["Added"]);
				    ?>
				    <i class="fa fa-newspaper-o bg-blue"></i>
				    <div class="timeline-item ">
				        <span class="time"><i class="fa fa-clock-o"></i> <?=$dateS[1]?></span>

				        <h3 class="timeline-header text-green"><?=$resultS["Title"];?></h3>

				        <div class="timeline-body table table-hover">
				            &nbsp;&nbsp;&nbsp;&nbsp;
				            <?=$resultS["Description"];?>
				        </div>

				        
				    </div>
				   <? } ?>
				</li>

	<!-- END timeline item -->
	<? 
			}
			$dateRun[] = $date[0];
		}
	
	} else{
		?>
		<li class="time-label">
			<span class="bg-red">
			    ไม่มีข้อมูล
			</span>
		</li>
	<?
	}	
	?>
	</ul>



