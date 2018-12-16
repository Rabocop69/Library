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
	<title>Home</title>
	<style type="text/css">


	</style>
</head>
<body>
	<?php
	require_once("functions.php");
	require_once("TablaSQL.php");

	if (isset($usernameSesion)) {
		echo "<h2> Welcome ".ucfirst($usernameSesion)." , these are your borrowed books </h2>";
		searchBook();
	
		$columnes= array("b.ISBN","title","startDay");
		$arxius= array("browse.php","update.php","delete.php");

		$extra=createExtra($categorySesion);
		$tabla = new TableSQL('library','book',$columnes,$arxius,$extra,"as b join borrow as bor on b.ISBN=bor.ISBN where userName='".$usernameSesion."'");

		$tabla->printTable();		

	}else{
		echo "<h2> Welcome anonymous user </h2>";
		searchBook();
	}
	
	?>

</body>
</html>