<?php
	session_cache_limiter ('nocache,private');
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        $passwordSesion = $_SESSION['password'];
        $categorySesion = $_SESSION['category'];
        if ($categorySesion=='client') {
        	header("Location:home.php");
        }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Insert</title>
	<style type="text/css">


	</style>
</head>
<body>
	<?php
	require_once("functions.php");
	require_once("Form1.2.php");

	if(isset($_GET['table'])){
		 require_once ('datos_conexion.inc');
         $conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, 'library');
         if($conexion->connect_errno){
            echo "Failed to connect to mysql $mysqli->connect_error";
            die();
        }

        if (isset($_GET['add'])) {
        	if ($_GET['table']=='book') {
        		$register= new Form("insert.php","Add",$_GET['table']);
				$register->addField("isbn","ISBN","text","","placeholder='XXXXX'","","required=''");
				$register->addField("title","Title","text","","","required=''");
				$register->addField("description","Description","text","","","required=''");
				$register->addField("language","Language","text","English","","required=''");
				$register->addField("publicationDate","Publication","date","","","required=''");
				$register->addField("authorid","Author","number","1","","required=''");
				$register->addField("table","Table","hidden","book","","required=''");
				$register->displayForm();
        	}else{
        		$register= new Form("insert.php","Add",$_GET['table']);
				$register->addField("username","User","text","","placeholder='user'","","required=''");
				$register->addField("dni","DNI","text","","","required=''");
				$register->addField("password","Password","password","","","required=''");
				$register->addField("category","Category","text","client","","required=''");
				$register->addField("table","Table","hidden","user","","required=''");
				$register->displayForm();
        	}

        }else{

	        switch ($_GET['table']) {
				case 'book':
					$fields=array('isbn','title','description','language','publicationDate','authorid');
					$cad="";
					$cad2="";
					foreach ($fields as $field) {
						if ($field!="authorid") {
							$cad=$cad.$field.",";
							$cad2=$cad2."'".$_GET[$field]."',";
						}else{
							$cad=$cad.$field;
							$cad2=$cad2."'".$_GET[$field]."'";
						}
					}
					break;
				case 'user':
					$fields=array('username','password','dni','category');
					$cad="";
					$cad2="";

					foreach ($fields as $field) {
						if ($field!="category") {
							$cad=$cad.$field.",";
							$cad2=$cad2."'".$_GET[$field]."',";
						}else{
							$cad=$cad.$field;
							$cad2=$cad2."'".$_GET[$field]."'";
						}
					}
					break;
			}

			$sentenciaSQL = "insert into {$_GET['table']} ( $cad ) values ($cad2);";
	     	//echo "$sentenciaSQL"; //if you need to check the query uncomment
	        
	       
	        if($conexion->query($sentenciaSQL)){
            	echo "The data has been succesfully saved";
        	}else{
        		echo "There has been an error saving the data (ex:repeated id,...)";
        	}

	    }
	}

	?>

</body>
</html>