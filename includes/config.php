<?
$host = "localhost";
$user = "jrpcom_angur";
$password = "angur";
$dbname = "jrpcom_angur";


//Table name
$TMember = "Member";
$TFilePath = "FilePath";
$TProvince = "province";
$TAmphur = "amphur";
$TMemberTransaction = "MemberTransaction";
$TRenewal = "Renewal";

//Config
$cfg = array(
		"systemName" => "ระบบบฐานข้อมูล",
		"listPerPage" => 200,
		"mailContactUs" => "kitikorn.y@gmail.com",
		"title" => "ยินดีต้อนรับสู่ jrp168.com",
		"headerIndex" => "ยินดีต้อนรับสู่ jrp168.com",
		"photoProfileWidth" => 250,
		"photoProfileHeight" => 350,
		"subMember" => 11,
		"expireDefault" =>"30"
		);

//Modules Config
$Modules = array(
			"searchMember" => 1
			);

//$_SESSION["Member"]["MemberID"] = "";
//$_SESSION["Member"]["MemberType"] = "";

$dateD = array(
				1 => "วันอาทิตย์",
				2 => "วันจันทร์",
				3 => "วันอังคาร",
				4 => "วันพุธ",
				5 => "วันพฤหัสบดี",
				6 => "วันศุกร์",
				7 => "วันเสาร์"
			);

//file path
$memberFile = "file/member/";

//Main menu name
$menuName = array(
			"register" => array("th"=>"ลงทะเบียน","en"=>"New member register."),
			"registerChild" => array("th"=>"เพิ่มลูกทีม","en"=>"Add Child"),
			"searchMember" =>array("th"=>"ค้นหาข้อมูลสมาชิก","en"=>"Search member"),
			"waitingList" =>array("th"=>"สมาชิกรอยันยัน","en"=>"Waiting List."),
			"contactsUs" =>array("th"=>"ติดต่อเรา","en"=>"Contact Us.")	

			);

//email for contactus
$mailContact = "admin168@jrp168.com";


?>
