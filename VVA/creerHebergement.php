<?php 
session_start(); 
//Si l'utilisateur n'est pas connecté, ou que ce n'est pas un administrateur le rediriger vers la page de connexion. La connexion dirigera directement l'utilisateur vers la page de réservation.

if(!ISSET($_SESSION["user"]))
{
	$erreur = "<p>ERREUR: Vous devez être connecté pour accéder à cette page.</p>";
	$page = "creerHebergement.php";
	header("location:connexion.php?erreur=$erreur&redirectionVers=$page");
}
else
	if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] != "loc")
	{
		$erreur = "<p>Accès refusé: Vous devez être administrateur pour accéder à cette page. <a href=rechercheHebergement.php>Retour vers la page d'accueil</a></p>";
		header("location:erreurAffichage.php?erreur=$erreur");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enregistrement d'un nouvel hébergement</title>
		<meta charset="utf-8"/>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="style2.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<?php include("headerNav.php");?>
			
			<?php

			if(ISSET($_GET["erreur"]))
			{
				echo $_GET["erreur"];
			}

			 ?>
			 <div class="card">
			 	<div class="card-header">
			 		<h5>Enregistrer un nouvel hébergement</h5>
			 	</div>
			 	<div class="card-body">
					<form method="post" action="trt_enregistrementHebergement.php">
						<div class="form-group row">
							<label for="nomHebergement" class="col-lg-2 col-form-label">Nom de l'hébergement:</label>
							<div class="col-lg-10">
								<input type="text" name="nomHebergement" id="nomHebergement" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group row">
							<label for="typeHebergement" class="col-lg-2 col-form-label">Type:</label>
							<div class="col-lg-10">
								<select name="typeHebergement" id="typeHebergement" class="form-control">
									<?php
									$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
									$req = $bdd->query("SELECT CODETYPEHEB, NOMTYPEHEB FROM type_heb");
									while($donnees = $req->fetch())
									{
										echo "<option value=".$donnees['CODETYPEHEB'].">".$donnees['NOMTYPEHEB']."</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="nombrePlace" class="col-lg-2 col-form-label">Nombre de place:</label>
							<div class="col-lg-10">
								<input type="number" name="nombrePlace" id="nombrePlace" class="form-control" value="" />
							</div>
						</div>
						<div class="form-group row">
							<label for="surface" class="col-lg-2 col-form-label">Surface (m²):</label>
							<div class="col-lg-10">
								<input type="number" name="surface" id="surface" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group row">
							<label for="internet" class="col-lg-2">Connexion à internet:</label>
							<div class="col-lg-10">
								<div class="form-check">
									<input type="radio" name="internet"  value="1"/>Oui
								</div>	
								<div class="form-check">
									<input type="radio" name="internet" value="0"/>Non
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="anneeConstruction" class="col-lg-2 col-form-label">Année de construction:</label>
							<div class="col-lg-10">
								<select name="anneeConstruction" id="anneeConstruction" class="form-control">
									<?php
										//Itérer les années à partir de l'année 1950 jusqu'à l'année actuelle.
										$anneeActuelle = new DateTime("this year");
										$retourVersLePassee = new DateTime("01-01-1950");
										$intervalle = new DateInterval("P1Y");
										$periode = new DatePeriod($retourVersLePassee, $intervalle, $anneeActuelle);

										foreach($periode as $annee)
										{
											echo "<option value=".$annee->format('Y').">".$annee->format('Y')."</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="secteur" class="col-lg-2 col-form-label">Secteur:</label>
							<div class="col-lg-10">
								<input type="text" name="secteur" id="secteur" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group row">
							<label for="orientation" class="col-lg-2 col-form-label">Orientation:</label>
							<div class="col-lg-10">
								<input type="text" name="orientation" id="orientation" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group row">
							<label for="etatHebergement" class="col-lg-2 ">Etat:</label>
							<div class="col-lg-10">
								<div class="form-check">
									<input type="radio" name="etatHebergement" value="Rénové"/>Rénové
								</div>
								<div class="form-check">
									<input type="radio" name="etatHebergement" value="En rénovation"/>En rénovation
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="description" class="col-lg-2 col-form-label">Description:</label>
							<div class="col-lg-10">
								<textarea name="description" id="description" class="form-control" value="Description"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="tarifSemaine" class="col-lg-2 col-form-label">Tarif/semaine (€):</label>
							<div class="col-lg-10">
								<input type="text" name="tarif" id="tarif" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group row">
							<label for="photoHebergment"  class="col-lg-2 col-form-label">Photo:</label>
							<div class="col-lg-10">
								<input type="text" name="photoHebergement" id="photoHebergment" class="form-control" value=""/>
							</div>
						</div>
						<div class="form-group ">
							<input type="submit" name="submit" value="Enregistrer" id="enregistrer" class="btn btn-primary"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>

