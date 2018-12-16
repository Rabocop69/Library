<?php 

class TableSQL {
    //bug al crear un tableSQL sin el primer atributo con u.
    private $dbName;
    private $tableName;
    private $fields=array();
    private $files=array();
    private $extra=array();
    private $sql;
    
    public function __construct($dbName1, $tableName1, $fields1, $files1,$extra1,$sql1){
        $this->dbName = $dbName1;
        $this->tableName = $tableName1;
        $this->fields = $fields1;
        $this->files = $files1;
        $this->extra = $extra1;
        $this->sql=$sql1;
    }
    
    function __destruct() {}
    
    function printTable() {
        require ('datos_conexion.inc');
        
        $conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, $this->dbName);

        if($conexion->connect_errno){
            echo "Failed to connect to mysql $mysqli->connect_error";
            die();
        }
        
        $fieldsQuery = $this->fields[0];
        
    
        foreach ($this->fields as $valor){
            if($valor != $this->fields[0]){
                if (strpos($valor, '.') !== false) {
                    $fieldsQuery .= ','.$valor." as ".$valor." "; 
                }else{
                    $fieldsQuery .= ','.$valor; 
                }
            }
        }

        $sentenciaSQL = "select ".$fieldsQuery." from ".$this->tableName." ".$this->sql.";";
       // echo "$sentenciaSQL";
        
        $registers= $conexion->query($sentenciaSQL);
       // print_r($registers);
       /* foreach ($this->fields as $valor){
            if (stripos ($valor, '.') !== false) {
                echo "<th>".ucfirst(substr($valor, 2))."</th>";
            }else{
                echo "<th>".ucfirst($valor)."</th>";
            }
        }*/

        //echo "filas: ".$registers->num_rows;
        echo "<table>";
        echo "<tr>";
        
        foreach ($this->fields as $valor){
            if (stripos ($valor, '.') !== false) {
                echo "<th>".ucfirst(substr($valor, 2))."</th>";
            }else{
                echo "<th>".ucfirst($valor)."</th>";
            }                    
        }
        
        if($this->extra[0]){
            echo "<th>Browse</th>";
        }
        if($this->extra[1]){
            echo "<th>Update</th>";
        }
        if($this->extra[2]){
            echo "<th>Delete</th>";
        }
        echo "</tr>";
        
        while ($row = $registers->fetch_assoc()){ //explota si solo tiene un valor.
            echo "<tr>";
                
            foreach ($this->fields as $valor){
                if (stripos ($valor, '.') !== false) {
                    echo "<td>".$row[substr($valor, 2)]."</td>";
                }else{
                    echo "<td>".$row[$valor]."</td>";
                }          
            }
            if($this->extra[0]){
                echo "<td><a href='{$this->files[0]}?id={$row[substr($this->fields[0], 2)]}&table=".
                $this->tableName."'> <img src='image/browse.png'></a></td>";
            }
            if($this->extra[1]){
                echo "<td><a href='{$this->files[1]}?id={$row[substr($this->fields[0], 2)]}&table=".
                $this->tableName."'> <img src='image/edit.png'></a></td>";
            }
            if($this->extra[2]){
                echo "<td><a href='{$this->files[2]}?id={$row[substr($this->fields[0], 2)]}&table=".
                $this->tableName."'><img src='image/delete.png'> </a></td>";
            }
             echo "</tr>";
        }
        echo "</table>";
    }
     
}

?>