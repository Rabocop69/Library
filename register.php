<?php
	session_cache_limiter ('nocache,private');
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

        header("Location:home.php");
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
	require_once("Form1.2.php");
	$register= new Form("insert.php","Register","user");
	$register->addField("username","User","text","","placeholder='user'","","required=''");
	$register->addField("dni","DNI","text","","","required=''");
	$register->addField("password","Password","password","","","required=''");
	$register->addField("category","Category","hidden","client","","required=''");
	$register->addField("table","Table","hidden","user","","required=''");
	$register->displayForm();
	?>

</body>
</html>