<?php 

 class Form {
	private $fields =array();
	private $nextForm;
	private $submitText;
	private $tableName;

	function __construct($nextForm1, $submitText1,$tableName){
		$this->nextForm=$nextForm1;
		$this->submitText=$submitText1;
		$this->tableName=$tableName;
		$this->addFields();
	}

	function addFields(){
		include ('datos_conexion.inc');
		$conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, $mysql_dbName);

		$registers =$conexion->query("show columns from $this->tableName");
		foreach ($registers as $register) {
			$this->fields[]=array($register['Field'],$register['Field']);
		}
		//print_r($this->fields);
	}

	function displayForm(){
		echo '<form action='.$this->nextForm."'><br/>";
		foreach ($this->fields as $field) {
			echo "<label for='$field[0]'>$field[1]</label><br/>
		  	<input type='text' name='$field[0]' value=''><br/>";
		}
		echo "<input type='submit' name='$this->submitText'>";
		echo "</form>" ;

	}
}

?>