<?php 

	require_once("connection.php");

	session_start();
	if($_SESSION["admin"] == 0) return header("location:panel.php");

	if(isset($_POST["predmet_uredi"])){
		$predmet_id = $_POST["predmet_uredi"];
		header("location:panel.php?show=predmeti_uredi&predmet_id=".$predmet_id);

	}
	else if(isset($_POST["predmet_izbrisi"])){

	}
	else if(isset($_POST["predmet_uredjivanje_finish"])){

	}

?>