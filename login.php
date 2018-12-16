<?php
	session_cache_limiter ('nocache,private');
    session_start();
    if (isset($_SESSION['username'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        $passwordSesion = $_SESSION['password'];
	}
?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="form1.css" media="screen" />
	</head>

	<body>
		<?php 
		if (isset($_POST['user']) && isset($_POST['pass'])) {
			include ("datos_conexion.inc");

			// connecting to BD
			$conexion = new mysqli ($mysql_server,$mysql_login,$mysql_pass,$mysql_dbName);

			if ($conexion->connect_errno) {
				echo "Failed to connect to MySQL: " . $mysqli->connect_error;
				die();
			}		
			
			//SQL construction
			$sentenciaSQL = "SELECT userName, password,category FROM user where userName='". $_POST['user'] ."' and password='" . $_POST['pass'] . "' ;";

			$registros = $conexion->query ($sentenciaSQL); 

			//check results
			$row = $registros->fetch_assoc();
				
			if($row ['userName'] == $_POST['user'] && $row ['password'] == $_POST['pass']){

				$_SESSION['username']=$_POST['user'];
				$_SESSION['password']=$_POST['pass'];
				$_SESSION['category']=$row['category'];

				header("Location: home.php");
			}else{
				echo "<p align=center> Usuari denegat </p>";
			}
		}
		
		?>
		<form action="" method="post">
			<h1 align="center">Log In</h1>
			<div id="form1">
				<label for="user">User</label>
				<input type="text" name="user" id="user" value=""><br>
				
				<label for="pass">Password</label>
				<input type="password" name="pass" id="pass" value=""><br>
					
				<input type="submit" name="SUBMIT" value="Log in">
			</div>
			<p>Do you have an account? If not you can create one at <a href="register.php">Register</a></p>	
		</form>
	</body>
</html>