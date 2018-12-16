<?php
	session_cache_limiter ('nocache,private');
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        $passwordSesion = $_SESSION['password'];
        $categorySesion = $_SESSION['category'];

        if($categorySesion=='client'){
        	header("Location:home.php");	//restrinction to normal users
        }
	}else{
		header("Location:home.php");		//restrinction to anonymous users
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MyLibrarian</title>
	<style type="text/css">


	</style>
</head>
<body>
	<?php
	require_once("functions.php");
	require_once("TablaSQL.php");
	
		echo "<h2> Welcome to your personal space ".ucfirst($usernameSesion)."</h2>";
		
		//Reservations
		echo "<h3>Reservations:</h3>";
		$columnes= array("u.userName","DNI","category","title","startDay");
		$arxius= array("browse.php","update.php","delete.php");

		$extra=createExtra($categorySesion);
		$tabla = new TableSQL('library','book',$columnes,$arxius,$extra,"as b join borrow as bor on b.ISBN=bor.ISBN join user as u on u.userName=bor.userName");

		$tabla->printTable();
//		add("book");


		//Books
		echo "<h3>Books:</h3>";
		searchBook();
		add("book");


		//Users
		echo "<h3>Users:</h3>";
		searchUser();
		add("user");
		
		$extra=createExtra($categorySesion);
		$columnes= array("u.userName","DNI","category");
		$arxius= array("browse.php","update.php","delete.php");
		$tabla = new TableSQL('library','user',$columnes,$arxius,$extra,"as u limit 10");
		$tabla->printTable();

		//Debtors
		echo "<h3>Debtors:</h3>";
		$columnes= array("u.userName","DNI","category","title","startDay");
		$arxius= array("browse.php","update.php","delete.php");

		$extra=createExtra($categorySesion);
		$tabla = new TableSQL('library','book',$columnes,$arxius,$extra,"as b join borrow as bor on b.ISBN=bor.ISBN join user as u on u.userName=bor.userName where DATE_ADD(bor.startDay, INTERVAL 20 day)<now()");

		$tabla->printTable();	

		//Author	
		echo "<h3>Authors:</h3>";
		searchAuthor();
		$extra=createExtra($categorySesion);
		$columnes= array("a.id","name","nationality");
		$arxius= array("browse.php","update.php","delete.php");
		$tabla = new TableSQL('library','author',$columnes,$arxius,$extra,"as a limit 10");
		$tabla->printTable();
	
	?>

</body>
</html>