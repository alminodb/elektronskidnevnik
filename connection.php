<?php 

	$db = mysqli_connect("localhost", "root", "", "eldnevnik");

	mysqli_set_charset($db, "utf8");

	if(!$db){
		die("Unable to connect to database!");
	}

?>