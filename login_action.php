<?php 

	require_once("connection.php");

	if(isset($_POST["login"])){
		$email = $_POST["email"];
		$pw = $_POST["password"];
		if(empty($pw) || empty($email)){
			header("location:login.php?login=empty");
		}
		else{
			$query = "SELECT * FROM ucenici WHERE email='".$email."' AND password='".$pw."'";
			$result = mysqli_query($db, $query);
			if(mysqli_num_rows($result) == 1){
				while($row = mysqli_fetch_assoc($result)){
					session_start();
					$_SESSION["email"] = $email;
					$_SESSION["password"] = $pw;
					$_SESSION["ime_prezime"] = $row["ime_prezime"];
					$_SESSION["admin"] = $row["admin"];
					$_SESSION["functions"] = $row["functions"];
					$_SESSION["logged"] = true;
					$_SESSION["razred"] = $row["razred"];
					$_SESSION["odjeljenje"] = $row["odjeljenje"];
					header("location:panel.php");
				}
			}
			else{
				$query = "SELECT * FROM profesori WHERE email='".$email."' AND password='".$pw."'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) == 1){
					while($row = mysqli_fetch_assoc($result)){
						session_start();
						$_SESSION["email"] = $email;
						$_SESSION["password"] = $pw;
						$_SESSION["ime_prezime"] = $row["ime_prezime"];
						$_SESSION["admin"] = $row["admin"];
						$_SESSION["functions"] = $row["functions"];
						$_SESSION["logged"] = true;
						header("location:panel.php");
					}
				}
				else{
					return header("location:login.php?login=failed");
				}
			}
		}
	}

?>