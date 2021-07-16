<?php 

	require_once("connection.php");

	session_start();
	if($_SESSION["admin"] == 0 && !strpos($_SESSION["functions"], "profesor")) return header("location:panel.php");

	if(isset($_POST["ocjene_ucenici"])){
		$razred_id = $_POST["ocjene_ucenici"];
		header("location:panel.php?show=ocjene_lista_ucenika&razred_id=".$razred_id);
	}

	if(isset($_POST["ocjene_lista_ocjena"])){
		$ucenik_id = $_POST["ocjene_lista_ocjena"];
		header("location:panel.php?show=ocjene_lista_ocjena&ucenik_id=".$ucenik_id);
	}
	if(isset($_POST["ocjene_lista_predmeta"])){
		$ucenik_id = $_POST["ocjene_lista_predmeta"];
		$result = mysqli_query($db, "SELECT razred,odjeljenje FROM ucenici WHERE ucenik_id='".$ucenik_id."'");
		if(mysqli_num_rows($result) > 0){
			if($row = mysqli_fetch_assoc($result)){
				$razred = $row["razred"];
				$odjeljenje = $row["odjeljenje"];
			}
		}
		header("location:panel.php?show=ocjene_lista_predmeta&razred=".$razred."&odjeljenje=".$odjeljenje."&ucenik_id=".$ucenik_id);
	}
	if(isset($_POST["ocjena_izbrisi"])){
		$ocjena_id = $_POST["ocjena_izbrisi"];
		mysqli_query($db, "DELETE FROM ocjene WHERE ocjena_id='".$ocjena_id."'");
		header("location:panel.php?show=ocjene_lista_razreda");
	}
	if(isset($_POST["ocjena_uredi"])){
		$ocjena_id = $_POST["ocjena_uredi"];
		header("location:panel.php?show=ocjene_uredi&ocjena_id=".$ocjena_id);
	}
	if(isset($_POST["ocjene_uredjivanje_finish"])){
		$ocjena_id = $_POST["ocjene_uredjivanje_finish"];
		$ocjena = $_POST["ocjene_uredjivanje_ocjena"];
		$profesor = $_POST["ocjene_uredjivanje_profesor"];
		$predmet = $_POST["ocjene_uredjivanje_predmet"];

		$predmet_res = mysqli_query($db, "SELECT predmet_id FROM predmeti WHERE predmet='$predmet'");
		if($predmet_row = mysqli_fetch_assoc($predmet_res)){
			$predmet_id = $predmet_row["predmet_id"];
		}

		$ucenik_res = mysqli_query($db, "SELECT ucenik_id FROM ocjene WHERE ocjena_id='$ocjena_id'");
		if($ucenik_row = mysqli_fetch_assoc($ucenik_res)){
			$ucenik_id = $ucenik_row["ucenik_id"];
		}

		$query = "UPDATE ocjene SET predmet_id='$predmet_id', ocjena='$ocjena', profesor='$profesor'";
		mysqli_query($db, $query);

		header("location:panel.php?show=ocjene_lista_ocjena&predmet_id=".$predmet_id."&ucenik_id=".$ucenik_id);
	}

?>