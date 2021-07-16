<?php 

	require_once("connection.php");
	session_start();
	if($_SESSION["admin"] == 0) return header("location:panel.php");

	if(isset($_POST["razred_ucenici"])){
		$razred_id = $_POST["razred_ucenici"];
		header("location:panel.php?show=ucenici_lista&razred=".$razred_id);
	}
	else if(isset($_POST["razred_uredi"])){
		$razred_id = $_POST["razred_uredi"];
		header("location:panel.php?show=razredi_uredi&razred_id=".$razred_id);
	}
	else if(isset($_POST["razred_izbrisi"])){
		$razred_id = $_POST["razred_izbrisi"];
		mysqli_query($db, "DELETE FROM razredi WHERE razred_id='".$razred_id."'");
		header("location:panel.php?show=razredi_lista");
	}
	else if(isset($_POST["razred_uredjivanje_finish"])){
		$razred_id = $_POST["razred_uredjivanje_finish"];
		$razred = $_POST["razred_uredjivanje_razred"];
		$odjeljenje = $_POST["razred_uredjivanje_odjeljenje"];
		$razrednik = $_POST["razred_uredjivanje_razrednik"];
		$ucionica = $_POST["razred_uredjivanje_ucionica"];

		$query = "UPDATE razredi SET razred='".$razred."', odjeljenje='".$odjeljenje."', razrednik='".$razrednik."', ucionica='".$ucionica."' WHERE razred_id='".$razred_id."'";
		mysqli_query($db, $query);
		header("location:panel.php?show=razredi_lista");
	}

?>