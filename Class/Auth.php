<?

Class Auth{
	function checkAuth(){
		if(@$_SESSION["Member"]["MemberID"] == ""){
			return false;
		}else{
			return true;
		}
	}

	function authMainMenu(){
		if(@$_SESSION["Member"]["MemberType"] == "A"){
			return true;
		}else{
			return false;
		}
	}

}
?>