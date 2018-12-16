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
	<title>Update</title>
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

        
        if (!isset($_GET['add'])) {
        	
        	//conexion con la pestaña insert
        	if ($_GET['table']=='book') {
        		$cad ="select * from book where isbn='{$_GET['id']}';";
        		//echo "{$cad}";
        		$result= $conexion->query($cad);
        		$valor = $result->fetch_Assoc();
        		$data=new DateTime($valor['publicationDate']);
        		$data=$data->format("Y-m-d");
        		echo "$data";

        		$register= new Form("insert.php","Add",$_GET['table']);
				$register->addField("isbn","ISBN","text",$valor['ISBN'],"placeholder='XXXXX' disabled","required");
				$register->addField("title","Title","text",$valor['title'],"","required=''");
				$register->addField("description","Description","text",$valor['description'],"","required=''");
				$register->addField("language","Language","text",$valor['language'],"","required=''");
				$register->addField("publicationDate","Publication","date",$data,"","required=''");
				$register->addField("authorid","Author","number",$valor['authorid'],"","required=''");
				$register->addField("table","Table","hidden","book","","required");
				$register->displayForm();
        	}else{
        		$cad ="select * from user where username='{$_GET['id']}';";
        		//echo "{$cad}";
        		$result= $conexion->query($cad);
        		$valor = $result->fetch_Assoc();

        		$register= new Form("insert.php","Add",$_GET['table']);
				$register->addField("username","User","text",$valor['userName'],"placeholder='user' disabled","required");
				$register->addField("dni","DNI","text",$valor['DNI'],"","required");
				$register->addField("password","Password","password",$valor['password'],"","required");
				$register->addField("category","Category","text","client",$valor['category'],"required");
				$register->addField("table","Table","hidden","user","","required");
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