<?php 

	require_once("connection.php");

	if(isset($_POST["dodaj"])){
		$email = $_POST["email"];
		$query = "SELECT ucenik_id,admin FROM ucenici WHERE email='$email'";
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result) == 1){
			if($row = mysqli_fetch_assoc($result)){
				$ucenik_id = $row["ucenik_id"];
				$admin = $row["admin"];
				if($admin != 0) return header("location:panel.php?show=admin_dodaj&result=exists");
				else{
					mysqli_query($db, "UPDATE ucenici SET admin='1' WHERE ucenik_id='$ucenik_id'");
					header("location:panel.php?show=admin_dodaj&result=success");
				}
			}
		}
		else{
			$query = "SELECT profesor_id,admin FROM profesori WHERE email='$email'";
			$result = mysqli_query($db, $query);
			if(mysqli_num_rows($result) == 1){
				if($row = mysqli_fetch_assoc($result)){
					$profesor_id = $row["profesor_id"];
					$admin = $row["admin"];
					if($admin != 0) return header("location:panel.php?show=admin_dodaj&result=exists");
					else{
						mysqli_query($db, "UPDATE profesori SET admin='1' WHERE profesor_id='$profesor_id'");
						header("location:panel.php?show=admin_dodaj&result=success");

					}
				}
			}
		}
	}

?>