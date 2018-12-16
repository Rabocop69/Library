<?php 

 class Form {

	private $fields =array();
	private $nextForm;
	private $submitText;

	function __construct($nextForm1, $submitText1){
		$this->nextForm=$nextForm1;
		$this->submitText=$submitText1;
	}

	function addField($input,$name,$type){
		$this->fields[]=array($input,$name,$type);
	}

	function displayForm(){
		echo '<form action='.$this->nextForm."'><br/>";
		foreach ($this->fields as $field) {
			echo "<label for='$field[0]'>$field[1]</label><br/>
		  	<input type='$field[2]' name='$field[0]' value=''><br/>";
		}
		echo "<input type='submit' name='$this->submitText'>";
		echo "</form>" ;
	}
}

?>