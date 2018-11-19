<?php
	class Test{
	//mutujad ehk properties
	private $secretnumber;
	public $publicnumber;
	
	//funktstioonid on meetodid(methods)	
	//construktor, mis kaivitab klassi kasutuselevoimalusel	
	function __construct($givennumber){
		$this->secretnumber = 7;
		$this->publicnumber = $givennumber * $this->$secretnumber;
	}	
	
	//destraktor, mis kaivitab klassi eemaldamisel
	function __destruct(){
		echo "Klassi lopetab tegevuse";
		
		
	}
	public function showvalues() {
		echo "Salajana number on" . $this->secretnumber;
		$this->tellinfo;

	}
	private function tellinfo(){
	echo "See siin on vaga salajana!";
	}
	
}//class lopeb


?>