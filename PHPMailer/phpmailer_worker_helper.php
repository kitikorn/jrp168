<?php 
class PHPMailer_Worker extends PHPMailer {

	var $gmail_account = array();

	function __construct(){
		parent::__construct();
	}

	function addGmailAccount($array){
		$this->gmail_account = $array;
	}

	function getRoundIndex(){

		if (!$this->gmail_account) return;

		if (file_exists(__DIR__.'/cache/gmail_account')){
			$index = file_get_contents(__DIR__.'/cache/gmail_account');
			if ($index+1 > count($this->gmail_account)) $index = 0;
			file_put_contents(__DIR__.'/cache/gmail_account', $index+1);
		}else{
			file_put_contents(__DIR__.'/cache/gmail_account', 0);
			$index = 0;
		}
		$this->Username = $this->gmail_account[$index][0];
		$this->Password = $this->gmail_account[$index][1];
	}

	function send(){
		$this->getRoundIndex();
		parent::send();
	}
}
?>