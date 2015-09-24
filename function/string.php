<?
function idenGen($id){
	$define = 5;
	$len = strlen($id);
	$loop = $define-$len;

	$te = "";
	if($len<$define){
		for($i=0;$i<$loop;$i++){
			$te .= "0";
		}
		$newID = "168".$te.$id;
	}else if($len >= $define){
		$newID = "168".$id;
	}
	return $newID;
}
?>