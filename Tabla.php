<?php 

class Table {
    private $dbName;
    private $tableName;
    private $fields=array();
    private $files=array();
    private $extra=array();

    
    public function __construct($dbName1, $tableName1, $fields1, $files1,$extra1){
        $this->dbName = $dbName1;
        $this->tableName = $tableName1;
        $this->fields = $fields1;
        $this->files = $files1;
        $this->extra = $extra1;
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
            if($valor != $this->fields[0]) $fieldsQuery .= ','.$valor;    
        }

        $sentenciaSQL = "select ".$fieldsQuery." from ".$this->tableName.";";
        
        $registers= $conexion->query($sentenciaSQL);
        
        //echo "filas: ".$registers->num_rows;
        echo "<table>";
            echo "<tr>";
                foreach ($this->fields as $valor){
                    echo "<th>".ucfirst($valor)."</th>";
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
            while ($row = $registers->fetch_assoc()){
                echo "<tr>";
                
                foreach ($this->fields as $valor)
                    echo "<td>".$row[$valor]."</td>";
                
                    if($this->extra[0]){
                        echo "<td><a href='{$this->files[0]}?id={$row[$this->fields[0]]}&table='$this->tableName''>
                            <img src='image/browse.png'>
                        </a></td>";
                    }
                    if($this->extra[1]){
                        echo "<td><a href='{$this->files[1]}?id={$row[$this->fields[0]]}&table='$this->tableName''>
                            <img src='image/edit.png'>
                        </a></td>";
                    }
                    if($this->extra[2]){
                        echo "<td><a href='{$this->files[2]}?id={$row[$this->fields[0]]}&table='$this->tableName''>
                            <img src='image/delete.png'>
                        </a></td>";
                    }
                echo "</tr>";
            }
        echo "</table>";
    } 
}

?>