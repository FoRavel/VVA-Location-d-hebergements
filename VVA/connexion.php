<!DOCTYPE html>
<html>
	<head>
		<title>Connexion</title>
		<meta charset="utf-8">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="style2.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<?php
			include("headerNav.php");

			echo "<div class='row justify-content-center'>";
			echo "<div class='col-lg-3' >";
			echo "<div class='card' style='width: 20rem'>";
			echo "<div class='card-header'>";
			echo "<h5 class='card-title'>Connexion</h5>";
			echo "</div>";
			echo "<div class='card-body'>";
			if(ISSET($_GET["erreur"]))
			{
				echo $_GET["erreur"];
			}
			if(ISSET($_GET["redirectionVers"]))
			{
				echo "<form method='post' action='trt_connexion.php?redirectionVers=$_GET[redirectionVers]'>";
			}
			else
			{
			
				echo "<form  method='post' action='trt_connexion.php'>";
			}
				echo "<div class='form-group'>";
				echo "<label for='User'>Utilisateur</label>";
				echo "<input type='text' class='form-control' name='user'/>";
				echo "</div>";
				echo "<div class='form-group'>";
				echo "<label for='mdp'>Mot de passe</label>";
				echo "<input type='password' class='form-control' name='mdp'/>";
				echo "</div>";
				echo "<input type='submit' class='btn btn-primary' name='submit' value='Se connecter'/>";			
				echo "</form>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			?>
		</div>
	</body>
</html> 