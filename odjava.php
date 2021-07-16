<?php 

	session_start();
	if($_SESSION["logged"] == "true"){
		session_destroy();
		header("location:index.php");
	}

?>