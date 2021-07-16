<?php 

	require_once("connection.php");
	session_start();
	if($_SESSION["admin"] == 0) return header("location:panel.php");
	if(isset($_POST["predmet_dodaj"])){
		$predmet = $_POST["predmet"];

		$query = "INSERT INTO predmeti (predmet) VALUES ('$predmet')";
		mysqli_query($db, $query);

		header("location:panel.php?show=predmeti_dodaj");
	}


?>