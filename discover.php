<?php
	session_cache_limiter ('nocache,private');
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        $passwordSesion = $_SESSION['password'];
        $categorySesion = $_SESSION['category'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Discover</title>
	<style type="text/css">


	</style>
</head>
<body>
	<?php
	require_once("functions.php");
	require_once("TablaSQL.php");

	if (isset($_GET['searchBook']) || isset($_GET['searchUser']) || isset($_GET['searchAuthor']) ) {
		echo "<h2> These are the results of your search: </h2>";
		if (isset($_GET['searchBook'])) {
			echo "<h3>Books:</h3>";
			$columnes= array("b.ISBN","title","name");
			$arxius= array("browse.php","update.php","delete.php");
			if(isset($categorySesion)){
				$extra=createExtra($categorySesion);
			}else{
				$extra=array(true,false,false);
			}
			
			$tabla = new TableSQL('library','book',$columnes,$arxius,$extra,"as b join author as a on b.authorid=a.id where title like '%".$_GET['searchBook']."%'");

			$tabla->printTable();
		}else if(isset($_GET['searchUser'])){
			if(isset($categorySesion)){
				if ($categorySesion=='client') {
					echo "Sorry, you can't see the data of other users";
				}else{
					echo "<h3>Users:</h3>";
					$extra=createExtra($categorySesion);
					$columnes= array("u.userName","DNI","category");
					$arxius= array("browse.php","update.php","delete.php");
					$tabla = new TableSQL('library','user',$columnes,$arxius,$extra,"as u where u.userName like '%".$_GET['searchUser']."%'");
					$tabla->printTable();
				}
			}else{
				echo "Unregistered users can't see the data of other users.";
			}		
		}else{

			echo "<h3>Authors:</h3>";	
			if (isset($categorySesion)) {
				$extra=createExtra($categorySesion);
			}else{
				$extra=array(true,false,false);
			}
			$columnes= array("a.id","name","nationality");
			$arxius= array("browse.php","update.php","delete.php");
			$tabla = new TableSQL('library','author',$columnes,$arxius,$extra,"as a where a.name like '%".$_GET['searchAuthor']."%'");
			$tabla->printTable();
			
		}
		
	}else{
		if (isset($usernameSesion)) {
			echo "<h2> Welcome ".ucfirst($usernameSesion)." , here  you can search for our latest books </h2>";

		}else{
			echo "<h2> Welcome to discover, where un can search for our latest books </h2>";
		}
			searchBook();

			bookList("select * from book order by publicationDate;",10);
	}



	?>

</body>
</html>