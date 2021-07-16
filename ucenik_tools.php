<?php 

	require_once("connection.php");

	session_start();
	if($_SESSION["admin"] < 1) return header("location:index.php");

	if(isset($_POST["ucenik_uredi"])){
		$ucenik_id = $_POST["ucenik_uredi"];
		header("location:panel.php?show=ucenici_uredi&ucenik_id=".$ucenik_id);
	}
	else if(isset($_POST["ucenik_izbrisi"])){
		$ucenik_id = $_POST["ucenik_izbrisi"];
		$query = "DELETE FROM ucenici WHERE ucenik_id='".$ucenik_id."'";
		mysqli_query($db, $query);
		header("location:panel.php?show=ucenici_lista");
	}
	else if(isset($_POST["ucenik_uredjivanje_finish"])){
		$ime_prezime = $_POST["ucenik_uredjivanje_ime_prezime"];
		$razred = $_POST["ucenik_uredjivanje_razred"];
		$odjeljenje = $_POST["ucenik_uredjivanje_odjeljenje"];

		$query = "UPDATE ucenici SET ime_prezime='".$ime_prezime."', razred='".$razred."', odjeljenje='".$odjeljenje."' WHERE ucenik_id='".$_POST["ucenik_uredjivanje_finish"]."'";
		mysqli_query($db, $query);
		header("location:panel.php?show=ucenici_lista");
	}


?>