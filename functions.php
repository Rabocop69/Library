<?php

function createExtra($category){
	if($category=="admin" || $category=="librarian"){
		$extra=array(true,true,true);
	}else{
		$extra=array(true,false,false);
	}	
	return $extra;
}

function searchBook(){
	echo "<form action='discover.php'>
				<label for='searchBook'><b>Search Book </b></label>		  		
		<input type='text' name='searchBook' placeholder='BookTitle' >
		<input type='submit' name=''>
		</form>";
}

function searchUser(){
	echo "<form action='discover.php'>
				<label for='searchUser'><b>Search User </b></label>		  		
		<input type='text' name='searchUser' placeholder='User Name' >
		<input type='submit' name=''>
		</form>";
}

function searchAuthor(){
	echo "<form action='discover.php'>
				<label for='searchAuthor'><b>Search Author </b></label>		  		
		<input type='text' name='searchAuthor' placeholder='Author Name' >
		<input type='submit' name=''>
		</form>";
}

function add($table){
	echo "<a style='text-decoration:none' href='insert.php?add=true&table=".$table."'>Add {$table} <img src='image/add.png'></a>";
}

function bookList($sql,$limit){
	include_once("datos_conexion.inc");

	$conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, $mysql_dbName);

	$registers =$conexion->query($sql);
	$arr= array();

	foreach ($registers as $register) {
		$arr[]=$register;
	}

	if (is_null($limit)) {
		$limit=count($arr);
	}

	for ($i=0; $i < count($arr) && $i<$limit; $i++) { 
		$titul=	$arr[$i]['title'];
		$image=getImageName($titul);
		echo "<div clas='book'>
		<a href='browse.php?id={$arr[$i]['ISBN']}&table=book'>"."
		<img src='image/$image'>
		</a>
		<p>{$titul}</p>

	    <input type='button' value='See the book' onclick="."window.location.href='browse.php?id={$arr[$i]['ISBN']}&table=book'>

		</div>";
	}
}

function getImageName($title){
	$string=cleanSpaces($title).'.png';
	return $string;
}


function cleanSpaces($string){
	$string = str_replace(' ', '', $string);
	return $string;
}

/*function canBorrow($user,$book){
	require_once ('datos_conexion.inc');
	$conexion = new mysqli ($mysql_server, $mysql_login, $mysql_pass, 'book');

        if($conexion->connect_errno){
            echo "Failed to connect to mysql $mysqli->connect_error";
            die();
        }

       	$sentenciaSQL="select count(*) from bo";
        $registers= $conexion->query($sentenciaSQL);
}*/

?>