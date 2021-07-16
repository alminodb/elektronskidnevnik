<?php 

	require_once("connection.php");
	session_start();
	if($_SESSION["admin"] == 0) return header("location:panel.php");
	if(isset($_POST["razred_dodaj"])){
		$razred = $_POST["razred"];
		$odjeljenje = $_POST["odjeljenje"];
		$razrednik = $_POST["razrednik"];
		$ucionica = $_POST["ucionica"];

		$query = "INSERT INTO razredi (razred, odjeljenje, razrednik, ucionica) VALUES ('$razred', '$odjeljenje', '$razrednik', '$ucionica')";
		mysqli_query($db, $query);

		header("location:panel.php?show=razredi_dodaj");
	}


?>