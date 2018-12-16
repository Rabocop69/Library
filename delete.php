<?php
session_cache_limiter ('nocache,private');
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        $passwordSesion = $_SESSION['password'];

    if(!(is_null($_GET['id']) && is_null($_GET['table']))){
		include ('datos_conexion.inc');
		$conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, $mysql_dbName);
		switch ($_GET['table']) {
			case 'book':
				$primary="isbn";
				break;
			case 'user':
				$primary="userName";
				break;
		}
		$query="delete from {$_GET['table']} where {$primary}='{$_GET['id']}';";
		echo "$query";
		$conexion->query($query);
		if($conexion->connect_errno){
            echo "Failed to connect to mysql $mysqli->connect_error";
            die();
        }
	}else{
		echo "Error al borrar";
	}
}else{
	header("Location:index.php");
}
 ?>