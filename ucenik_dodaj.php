<?php 

	require_once("connection.php");
	session_start();
	if($_SESSION["admin"] == 0) return header("location:panel.php");
	if(isset($_POST["ucenik_dodaj"])){
		$ucenik = $_POST["ucenik"];
		$razred = $_POST["razred"];
		$odjeljenje = $_POST["odjeljenje"];

		$query = "SELECT razred_id FROM razredi WHERE razred='".$razred."' AND odjeljenje='".$odjeljenje."'";
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result) >= 1){
			if($row = mysqli_fetch_assoc($result)){
				$razred_id = $row["razred_id"];
			}
		}

		$query = "INSERT INTO ucenici (ime_prezime, razred, odjeljenje, razred_id) VALUES ('$ucenik', '$razred', '$odjeljenje', '$razred_id')";
		mysqli_query($db, $query);

		header("location:panel.php?show=ucenici_dodaj");
	}


?>