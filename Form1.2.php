<?php 

 class Form {
	private $fields =array();
	private $combos = array();
	private $comboExists=false;
	private $nextForm;
	private $submitText;
	private $tableName;

	function __construct($nextForm1, $submitText1,$tableName){
		$this->nextForm=$nextForm1;
		$this->submitText=$submitText1;
		$this->tableName=$tableName;
	}

	function addField($name,$output,$type,$default,$extra,$required){
		$this->fields[]=array($name,$output,$type,$default,$extra,$required);	
	}

	function addCombo($name,$options,$values){
		$this->combos[]=array($name,$options,$values);
		$this->comboExists=true;
	}

	function displayForm(){
		echo '<form action='.$this->nextForm."><br/>";
		foreach ($this->fields as $field) {
			if ($field[2]=="hidden") {
				echo "<br/><input type='$field[2]' name='$field[0]' value='$field[3]' $field[4] $field[5]><br/>";
			}else{
				echo "<label for='$field[0]'><b>$field[1]</b></label><br/>
		  		<input type='$field[2]' name='$field[0]' value='$field[3]' $field[4]  {$field[5]}><br/>";
		  		//print_r($field);
			}
		}

		/*if ($this->comboExists) {
			foreach ($this->combos as $combo) {
				echo "<SELECT NAME='{$combo[0]}' SIZE=1>"; 
				foreach ($combo[1] as $option ) {
					echo "<OPTION VALUE=''>{$option}</OPTION>";
				}
				echo "</SELECT>";
			}
		}*/

		echo "<input type='submit' name='submit' value='$this->submitText'></input>";
		echo "</form>" ;

	}
}

?>