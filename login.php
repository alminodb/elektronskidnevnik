<!DOCTYPE html>

<?php
    require_once("connection.php");

    session_start();
    if(@$_SESSION["logged"] == "true") header("location:index.php");
?>

<html>
<head>
	<title>eDnevnik | Prijava</title>
	<link rel="stylesheet" type="text/css" href="login-style.css">
</head>
<body>
	<div class="login">
    	<h1>Prijava</h1>
    	<form action="login_action.php" method="post">
            <!-- PHP DIO / ERRORS -->
            <?php 
                if(@$_GET["login"] == "failed"){
            ?>
    		<div class="error">
    			<p style="text-align: center; color: #A31821; font-size: 15px; text-shadow: 1px 1px 2px rgba(0,0,0,0.6); font-weight: bold;">
    				* Netacni e-mail i lozinka *
    			</p>
    		</div>

            <?php 
                }
                else if(@$_GET["login"] == "empty"){
            ?>

            <div class="error">
                <p style="text-align: center; color: #A31821; font-size: 15px; text-shadow: 1px 1px 2px rgba(0,0,0,0.6); font-weight: bold;">
                    * Polja ne smiju ostati prazna *
                </p>
            </div>

            <?php 
                }
            ?>

            <!-- ///////////////////// -->

        	<input type="email" name="email" placeholder="E-mail" required="required" />
			<input type="password" name="password" placeholder="Lozinka" required="required" />
        	<button type="submit" class="btn btn-primary btn-block btn-large" name="login">Prijavi se</button>
			<hr style="height: 0.5px; border-color: #424B54; box-shadow: 0px 0px 2px black;">
        	<a href="index.php">
        		<- Vrati se na pocetnu.
        	</a>
    	</form>
	</div>
</body>
</html>