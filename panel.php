<?php 

	require_once("connection.php");

	session_start();
	if(@$_SESSION["logged"] != "true") header("location:login.php");
	$functions = $_SESSION["functions"];
	$admin = $_SESSION["admin"];

	// FUNKCIJE


?>

<!DOCTYPE html>
<html>
<head>
	<title>eDnevnik</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="panel-style.css">
	<link href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Electrolize&display=swap" rel="stylesheet">
</head>
<body>
	<div class="top-nav">
		<ul>
			<li><a href="panel.php?show=postavke&user_id=<?php echo $_SESSION["user_id"]; ?>">Postavke</a></li>
			<li><a href="odjava.php">Odjava</a></li>
		</ul>
	</div>
	<div class="side-nav">
		<ul>
			<li class="title">Ocjene</li> <!-- OCJENE -->
			<li><a href="panel.php?show=ocjene_lista_razreda">Ocjene</a></li>
			<?php if(strpos($functions, "ucenik")){ ?>
			<li><a href="#">Moje ocjene</a></li>
			<?php } ?>
			<li><a href="#">Dodaj ocjenu</a></li>
			<li class="title">Učenici</li> <!-- UCENICI -->
			<?php if(strpos($functions, "profesor") || $admin != 0){ ?>
			<li><a href="panel.php?show=ucenici_lista">Lista</a></li>
			<?php } ?>
			<?php if($admin != 0){ ?>
			<li><a href="panel.php?show=ucenici_dodaj">Dodaj učenika</a></li>
			<?php } ?>
			<li class="title">Predmeti</li> <!-- PREDMETI -->
			<li><a href="panel.php?show=predmeti_lista">Lista</a></li>
			<?php if($admin != 0){ ?>
			<li><a href="panel.php?show=predmeti_dodaj">Dodaj predmet</a></li>
			<?php } ?>
			<li class="title">Razredi</li> <!-- RAZREDI -->
			<li><a href="panel.php?show=razredi_lista">Lista</a></li>
			<?php if($admin != 0){ ?>
			<li><a href="panel.php?show=razredi_dodaj">Dodaj razred</a></li>
			<?php } ?>
			<li class="title">Ostalo</li> <!-- OSTALO -->
			<li><a href="panel.php?show=admin_lista">Lista Admina</a></li>
			<li><a href="panel.php?show=admin_dodaj">Dodaj Admina</a></li>
		</ul>
	</div>

	<div class="main">

		<!-- 												MAIN 			      							 -->

		<?php 

		if(@$_GET["show"] == "home" || !isset($_GET["show"])){ ?>

			<?php echo $_SESSION["ime_prezime"]; ?>


		<?php } ?>

		

		<!-- 										RAZREDI - LISTA      							 -->

		<?php if(@$_GET["show"] == "razredi_lista"){ ?>

			<h2>Razredi</h2><br><br>
			<table>
				<tr>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<th>Razrednik</th>
					<th>Ucionica</th>
					<th>Alatke</th>
				</tr>
				<?php 
				$query = "SELECT * FROM razredi ORDER BY odjeljenje ASC";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					while($row = mysqli_fetch_assoc($result)){
						$razred_id = $row["razred_id"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						$razrednik = $row["razrednik"];
						$ucionica = $row["ucionica"];
						?>

						<tr>
							<td><?php echo $razred ?></td>
							<td><h3><?php echo $odjeljenje ?></h3></td>
							<td><?php echo $razrednik ?></td>
							<td><?php echo $ucionica ?></td>
							<form method="post" action="razred_tools.php">
								<td>
									<button name="razred_ucenici" value="<?php echo $razred_id ?>">Lista ucenika</button>
									<?php if($admin > 0){ ?>
									<button name="razred_uredi" value="<?php echo $razred_id ?>">Uredi razred</button>
									<?php } ?>
									<?php if($admin > 0){ ?>
									<button name="razred_izbrisi" value="<?php echo $razred_id ?>">Izbrisi razred</button>
									<?php } ?>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->


		<!--										RAZREDI - DODAJ  													-->




		<?php if(@$_GET["show"] == "razredi_dodaj"){ ?>

			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Dodaj Razred</h2>
			<form method="post" action="razred_dodaj.php" class="dodaj_form">
				<input type="text" name="razred" placeholder="Razred" required="required" autocomplete="off">
				<input type="text" name="odjeljenje" placeholder="Odjeljenje" required="required" autocomplete="off">
				<input type="text" name="razrednik" placeholder="Razrednik" required="required" autocomplete="off">
				<input type="text" name="ucionica" placeholder="Ucionica" required="required"  autocomplete="off">
				<input type="submit" name="razred_dodaj" value="Dodaj" class="dodaj_form_submit">
			</form>



		<?php
			}
		?>



		<!-- 	////////////////////////////////////////// -->

		<!-- 								UCENICI - LISTA 					-->


		<?php if(@$_GET["show"] == "ucenici_lista"){ ?>


			<h2>Ucenici</h2><br><br>
			<table>
				<tr>
					<th>Prezime i ime</th>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<?php if($admin > 0){ ?>
					<th>Alatke</th>
					<?php } ?>
				</tr>
				<?php 

				if(isset($_GET["razred"])){
					$query = "SELECT * FROM ucenici WHERE razred_id='".$_GET["razred"]."' ORDER BY ime_prezime ASC";
					$result = mysqli_query($db, $query);
				}
				else{
					$query = "SELECT * FROM ucenici ORDER BY odjeljenje ASC";
					$result = mysqli_query($db, $query);
				}
				if(mysqli_num_rows($result) >= 1){
					while($row = mysqli_fetch_assoc($result)){
						$ucenik_id = $row["ucenik_id"];
						$ime_prezime = $row["ime_prezime"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						?>

						<tr>
							<td><?php echo $ime_prezime ?></td>
							<td><?php echo $razred ?></td>
							<td><?php echo $odjeljenje ?></td>
							<form method="post" action="ucenik_tools.php">
								<td>
									<?php if($admin > 0){ ?>
									<button name="ucenik_uredi" value="<?php echo $ucenik_id ?>">Uredi ucenika</button>
									<?php } ?>
									<?php if($admin > 0){ ?>
									<button name="ucenik_izbrisi" value="<?php echo $ucenik_id ?>">Izbrisi ucenika</button>
									<?php } ?>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>

		<!-- 	//////////////////////////////////////////// -->


		<!-- 										UCENICI - DODAJ 		-->


		<?php if(@$_GET["show"] == "ucenici_dodaj"){ ?>
			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Dodaj Ucenika</h2>
			<form method="post" action="ucenik_dodaj.php" class="dodaj_form">
				<input type="text" name="ucenik" placeholder="Prezime i ime" required="required" autocomplete="off">
				<input type="text" name="razred" placeholder="Razred" required="required" autocomplete="off">
				<input type="text" name="odjeljenje" placeholder="Odjeljenje" required="required" autocomplete="off">
				<input type="submit" name="ucenik_dodaj" value="Dodaj" class="dodaj_form_submit">
			</form>



		<?php
			}
		?>


		<!-- 	/////////////////////////////////////////////// -->


		<!--										PREDMETI - DODAJ  													-->




		<?php if(@$_GET["show"] == "predmeti_dodaj"){ ?>
			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Dodaj Predmet</h2>
			<form method="post" action="predmet_dodaj.php" class="dodaj_form">
				<input type="text" name="predmet" placeholder="Naziv predmeta" required="required" autocomplete="off">
				<input type="submit" name="predmet_dodaj" value="Dodaj" class="dodaj_form_submit">
			</form>



		<?php
			}
		?>



		<!-- 	////////////////////////////////////////// -->

		<!-- 							PREDMETI - LISTA      							 -->

		<?php if(@$_GET["show"] == "predmeti_lista"){ ?>

			<h2>Predmeti</h2><br><br>
			<table>
				<tr>
					<th>Predmet</th>
					<?php if($admin > 0){ ?>
					<th>Alatke</th>
					<?php } ?>
				</tr>
				<?php 

				$query = "SELECT * FROM predmeti";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					while($row = mysqli_fetch_assoc($result)){
						$predmet_id = $row["predmet_id"];
						$predmet = $row["predmet"];
						?>

						<tr>
							<td><?php echo $predmet ?></td>
							<form method="post" action="predmet_tools.php">
								<td>
									<?php if($admin > 0){ ?>
									<button name="predmet_uredi" value="<?php echo $predmet_id ?>">Uredi predmet</button>
									<button name="predmet_izbrisi" value="<?php echo $predmet_id ?>">Izbrisi predmet</button>
									<?php } ?>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->

		<!-- 										UCENICI - UREDJIVANJE 				 -->

		<?php 

		if(@$_GET["show"] == "ucenici_uredi"){ ?>
			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Uredjivanje ucenika</h2><br><br>
			<table>
				<tr>
					<th>Prezime i ime</th>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<th>Alatke</th>
				</tr>
				<?php 

				if(!isset($_GET["ucenik_id"])) return header("location:panel.php?show=ucenici_lista");

				$query = "SELECT * FROM ucenici WHERE ucenik_id='".$_GET["ucenik_id"]."'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					if($row = mysqli_fetch_assoc($result)){
						$ucenik_id = $row["ucenik_id"];
						$ime_prezime = $row["ime_prezime"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						?>

						<tr>
							<form method="post" action="ucenik_tools.php">
							<td><input type="text" name="ucenik_uredjivanje_ime_prezime" value="<?php echo $ime_prezime ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="ucenik_uredjivanje_razred" value="<?php echo $razred ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="ucenik_uredjivanje_odjeljenje" value="<?php echo $odjeljenje ?>" class="input_edit" autocomplete="off"></td>
								<td>
									<button name="ucenik_uredjivanje_finish" value="<?php echo $ucenik_id ?>">Uredi ucenika</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>
		<?php } ?>

		<!--	/////////////////////////////////////////// -->

		<!-- 							RAZREDI - UREDJIVANJE      							 -->

		<?php if(@$_GET["show"] == "razredi_uredi"){ ?>

			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Uredjivanje razreda</h2><br><br>
			<table>
				<tr>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<th>Razrednik</th>
					<th>Ucionica</th>
					<th>Alatke</th>
				</tr>
				<?php 
				if(!isset($_GET["razred_id"])) return header("location:panel.php?show=razredi_lista");

				$query = "SELECT * FROM razredi WHERE razred_id='".$_GET["razred_id"]."'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					if($row = mysqli_fetch_assoc($result)){
						$razred_id = $row["razred_id"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						$razrednik = $row["razrednik"];
						$ucionica = $row["ucionica"];
						?>

						<tr>
							<form method="post" action="razred_tools.php">
							<td><input type="text" name="razred_uredjivanje_razred" value="<?php echo $razred ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="razred_uredjivanje_odjeljenje" value="<?php echo $odjeljenje ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="razred_uredjivanje_razrednik" value="<?php echo $razrednik ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="razred_uredjivanje_ucionica" value="<?php echo $ucionica ?>" class="input_edit" autocomplete="off"></td>
								<td>
									<button name="razred_uredjivanje_finish" value="<?php echo $razred_id ?>">Uredi razred</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->

		<!-- 							PREDMETI - UREDJIVANJE      							 -->

		<?php if(@$_GET["show"] == "predmeti_uredi"){ ?>

			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Uredjivanje predmeta</h2><br><br>
			<table>
				<tr>
					<th>Predmet</th>
					<th>Alatke</th>
				</tr>
				<?php 
				if(!isset($_GET["predmet_id"])) return header("location:panel.php?show=predmeti_lista");

				$query = "SELECT * FROM predmeti WHERE predmet_id='".$_GET["predmet_id"]."'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					if($row = mysqli_fetch_assoc($result)){
						$predmet_id = $row["predmet_id"];
						$predmet = $row["predmet"];
						?>

						<tr>
							<form method="post" action="predmet_tools.php">
							<td><input type="text" name="predmet_uredjivanje_predmet" value="<?php echo $predmet ?>" class="input_edit" autocomplete="off"></td>
								<td>
									<button name="predmet_uredjivanje_finish" value="<?php echo $predmet_id ?>">Uredi predmet</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->


		<!-- 										OCJENE - LISTA RAZREDA     							 -->

		<?php if(@$_GET["show"] == "ocjene_lista_razreda"){ ?>

			<?php if(!strpos($functions, "profesor") && $admin == 0) return header("location:panel.php"); ?>
			<h2>Ocjene</h2><br><br>
			<table>
				<tr>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<th>Razrednik</th>
					<th>Ucionica</th>
					<th>Alatke</th>
				</tr>
				<?php 
				$query = "SELECT * FROM razredi ORDER BY odjeljenje ASC";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					while($row = mysqli_fetch_assoc($result)){
						$razred_id = $row["razred_id"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						$razrednik = $row["razrednik"];
						$ucionica = $row["ucionica"];
						?>

						<tr>
							<td><?php echo $razred ?></td>
							<td><h3><?php echo $odjeljenje ?></h3></td>
							<td><?php echo $razrednik ?></td>
							<td><?php echo $ucionica ?></td>
							<form method="post" action="ocjene_tools.php">
								<td>
									<button name="ocjene_ucenici" value="<?php echo $razred_id ?>">Lista ucenika</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->

		<!-- 								OCJENE - LISTA UCENIKA					-->


		<?php if(@$_GET["show"] == "ocjene_lista_ucenika"){ ?>

			<?php if(!strpos($functions, "profesor") && $admin == 0) return header("location:panel.php"); ?>
			<h2>Ocjene</h2><br><br>
			<table>
				<tr>
					<th>Prezime i ime</th>
					<th>Razred</th>
					<th>Odjeljenje</th>
					<th>Alatke</th>
				</tr>
				<?php 

				if(!isset($_GET["razred_id"])) return header("location:panel.php?show=ocjene_lista_razreda");

				$query = "SELECT * FROM ucenici WHERE razred_id='".$_GET["razred_id"]."' ORDER BY ime_prezime ASC";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					while($row = mysqli_fetch_assoc($result)){
						$ucenik_id = $row["ucenik_id"];
						$ime_prezime = $row["ime_prezime"];
						$razred = $row["razred"];
						$odjeljenje = $row["odjeljenje"];
						?>

						<tr>
							<td><?php echo $ime_prezime ?></td>
							<td><?php echo $razred ?></td>
							<td><?php echo $odjeljenje ?></td>
							<form method="post" action="ocjene_tools.php">
								<td>
									<button name="ocjene_lista_predmeta" value="<?php echo $ucenik_id ?>">Ocjene</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>

		<!-- 	//////////////////////////////////////////// -->

		<!-- 								OCJENE - LISTA PREDMETA					-->


		<?php if(@$_GET["show"] == "ocjene_lista_predmeta"){ ?>

			<?php if(!strpos($functions, "profesor") && $admin == 0) return header("location:panel.php"); ?>
			<h2>Ocjene</h2><br><br>
			<table>
				<tr>
					<th>Predmet</th>
					<th>Alatke</th>
				</tr>
				<?php 

				if(!isset($_GET["razred"]) || !isset($_GET["odjeljenje"]) || !isset($_GET["ucenik_id"])) return header("location:panel.php?show=ocjene_lista_razreda");

				$ucenik_id = $_GET["ucenik_id"];
				$odjeljenje = $_GET["odjeljenje"];
				$razred = $_GET["razred"];


				$result = mysqli_query($db, "SELECT * FROM predmeti");
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$predmet_id = $row["predmet_id"];
						$predmet = $row["predmet"];
						$struka = $row["struka"];
						$razredi = $row["razredi"];

						?>
						<tr>
							<?php 
								if((isset($struka) && $struka == $odjeljenje) || $struka == ""){
									if((isset($razredi) && strpos($razredi, $razred)) || $struka == ""){
							?>
								<td><?php echo $predmet ?></td>
						
								<td>
									<a href="panel.php?show=ocjene_lista_ocjena&ucenik_id=<?php echo $ucenik_id ?>&predmet_id=<?php echo $predmet_id ?>"><button>Ocjene</button></a>
								</td>
							<?php 
									}
								}
							?>	
						</tr>


					<?php 
					}
				}

				?>
			</table>

		<?php } ?>
		
		<!-- 	//////////////////////////////////////////// -->

		<!-- 								OCJENE - LISTA OCJENA					-->


		<?php if(@$_GET["show"] == "ocjene_lista_ocjena"){ ?>

			<?php if(!strpos($functions, "profesor") && $admin == 0) return header("location:panel.php"); ?>
			<h2>Ocjene</h2><br><br>
			<table>
				<tr>
					<th>Prezime i Ime</th>
					<th>Predmet</th>
					<th>Ocjena</th>
					<th>Profesor</th>
					<?php if($admin > 0){ ?>
					<th>Alatke</th>						
					<?php } ?>
				</tr>
				<?php 


				if(!isset($_GET["predmet_id"]) || !isset($_GET["ucenik_id"])) return header("location:panel.php?show=ocjene_lista_razreda");

				$ucenik_id = $_GET["ucenik_id"];
				$predmet_id = $_GET["predmet_id"];

				$ucenik_res = mysqli_query($db, "SELECT ime_prezime FROM ucenici WHERE ucenik_id='$ucenik_id'");
				if($ucenik_row = mysqli_fetch_assoc($ucenik_res)){
					$ime_prezime = $ucenik_row["ime_prezime"];
				}
				$predmet_res = mysqli_query($db, "SELECT predmet FROM predmeti WHERE predmet_id='$predmet_id'");
				if($predmet_row = mysqli_fetch_assoc($predmet_res)){
					$predmet = $predmet_row["predmet"];
				}


				$result = mysqli_query($db, "SELECT * FROM ocjene WHERE ucenik_id='$ucenik_id' AND predmet_id='$predmet_id'");
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$ocjena_id = $row["ocjena_id"];
						$ocjena = $row["ocjena"];
						$profesor = $row["profesor"];

						?>
						<tr>
							<td><?php echo $ime_prezime; ?></td>
							<td><?php echo $predmet; ?></td>
							<td><?php echo $ocjena; ?></td>
							<td><?php echo $profesor; ?></td>
							<?php if($admin > 0){ ?>
							<td>
								<form method="post" action="ocjene_tools.php">
									<button name="ocjena_uredi" value="<?php echo $ocjena_id ?>">Uredi ocjenu</button>
									<button name="ocjena_izbrisi" value="<?php echo $ocjena_id ?>">Izbrisi ocjenu</button>
								</form>
							</td>
							<?php } ?>
						</tr>


					<?php 
					}
				}

				?>
			</table>

		<?php } ?>
		
		<!-- 	//////////////////////////////////////////// -->

		<!-- 							OCJENE - UREDJIVANJE      							 -->

		<?php if(@$_GET["show"] == "ocjene_uredi"){ ?>

			<?php if($admin == 0) return header("location:panel.php"); ?>
			<h2>Uredjivanje razreda</h2><br><br>
			<table>
				<tr>
					<th>Prezime i Ime</th>
					<th>Predmet</th>
					<th>Ocjena</th>
					<th>Profesor</th>
					<?php if($admin > 0){ ?>
					<th>Alatke</th>						
					<?php } ?>
				</tr>
				<?php 
				if(!isset($_GET["ocjena_id"])) return header("location:panel.php?show=razredi_lista");

				$query = "SELECT * FROM ocjene WHERE ocjena_id='".$_GET["ocjena_id"]."'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) >= 1){
					if($row = mysqli_fetch_assoc($result)){
						$ocjena_id = $_GET["ocjena_id"];
						$ucenik_id = $row["ucenik_id"];
						$predmet_id = $row["predmet_id"];
						$ocjena = $row["ocjena"];
						$profesor = $row["profesor"];

						$ucenik_res = mysqli_query($db, "SELECT ime_prezime FROM ucenici WHERE ucenik_id='$ucenik_id'");
						if($ucenik_row = mysqli_fetch_assoc($ucenik_res)){
							$ime_prezime = $ucenik_row["ime_prezime"];
						}
						$predmet_res = mysqli_query($db, "SELECT predmet FROM predmeti WHERE predmet_id='$predmet_id'");
						if($predmet_row = mysqli_fetch_assoc($predmet_res)){
							$predmet = $predmet_row["predmet"];
						}
						?>

						<tr>
							<form method="post" action="ocjene_tools.php">
							<td><?php echo $ime_prezime ?></td>
							<td><input type="text" name="ocjene_uredjivanje_predmet" value="<?php echo $predmet ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="ocjene_uredjivanje_ocjena" value="<?php echo $ocjena ?>" class="input_edit" autocomplete="off"></td>
							<td><input type="text" name="ocjene_uredjivanje_profesor" value="<?php echo $profesor ?>" class="input_edit" autocomplete="off"></td>
								<td>
									<button name="ocjene_uredjivanje_finish" value="<?php echo $ocjena_id ?>">Uredi ocjenu</button>
								</td>
							</form>
						</tr>

						<?php
					}
				}

				?>
			</table>

		<?php } ?>



		<!--	/////////////////////////////////////////// -->

		<!-- 														ADMINI - DODAJ 													 -->

		<?php if(@$_GET["show"] == "admin_dodaj"){ ?>

		<?php if($admin == 0) return header("location:panel.php"); ?>

		<h2>Dodavanje Admina</h2><br><br>
		<form class="dodaj_form" method="post" action="admin_tools.php">
			<input type="text" name="email" placeholder="E-mail korisnika" required="required">
			<input type="submit" name="dodaj" class="dodaj_form_submit">
		</form>

		<?php if(@$_GET["result"] == "exists") echo "<br><br><hr><br><h3>*** Taj korisnik vec ima Admina! ***</h3>"; 
			  else if(@$_GET["result"] == "success") echo "<br><br><hr><br><h3>*** Uspjesno ste dodali Admina! ***</h3>"; ?>

		<?php } ?>


		<!-- ////////////////////////////////////////////////////////////// -->

		<!-- 														ADMINI - DODAJ 													 -->

		<?php if(@$_GET["show"] == "admin_lista"){ ?>

		<?php if($admin == 0) return header("location:panel.php"); ?>

		<br><h2>Lista Admina</h2>
		<table>
			<tr>
				<th>Prezime i Ime</th>
				<th>E-mail</th>
				<th>Funkcije</th>
				<th>Alatke</th>
			</tr>
			<?php 

			$query = "SELECT ime_prezime,functions,email FROM ucenici WHERE admin='1'";
			$result = mysqli_query($db, $query);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$ime_prezime = $row["ime_prezime"];
					$functions = $row["functions"];
					$email = $row["email"];


					$tanan = explode(",", $functions);
					echo $tanan[0];


					?>

					<tr>
						<td><?php echo $ime_prezime ?></td>
						<td><?php echo $email ?></td>
						<td><?php echo $functions ?></td>
					</tr>

			<?php 
				}
			}

			?>
		</table>

		<?php } ?>

		<!-- ////////////////////////////////////////////////////////////// -->



	</div>

</body>
</html>