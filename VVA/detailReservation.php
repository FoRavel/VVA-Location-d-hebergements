
<!DOCTYPE html>
<html>
	<head>
		<title>Recherche de réservation</title>
		<meta charset="utf-8"/>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="style2.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
		<?php include("headerNav.php");?>
	<?php

	/*session_start();

	if(!ISSET($_SESSION["user"]))
	{
		$erreur = "<p>ERREUR: Vous devez être connecté pour accéder à cette page.</p>
		$page = "rechercheReservation.php
		header("location:connexion.php?erreur=$erreur&redirectionVers=$page");
	}
	else
		if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] != "loc")
		{
			$erreur = "<p>Accès refusé: Vous devez être administrateur pour accéder à cette page. <a href=rechercheHebergement.php>Retour vers la page d'accueil</a></p>";
			header("location:erreurAffichage.php?erreur=$erreur");
		}*/
	/*if(!ISSET($_GET['noHeb']) OR !ISSET($_GET['dateDebSem']))
	{
		header("location:rechercheReservation.php");
	}*/
	if(ISSET($_GET['noHeb']) AND ISSET($_GET['dateDebSem']))
	{
		?>
		<div class="card">
			<div class="card-header">
				<h5>Informations sur la réservation sélectionnée</h5>
			</div>
			<div class="card-body">
		<?php
				$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
				$req = $bdd->prepare("SELECT r.NOHEB, r.DATEDEBSEM, r.USER, r.DATEARRHES, r.MONTANTARRHES, r.NBOCCUPANT, r.TARIFSEMRESA, r.MONTANTARRHES, e.CODEETATRESA, e.NOMETATRESA FROM resa r, etat_resa e WHERE r.NOHEB = :noHeb AND r.DATEDEBSEM = :dateDebSem AND e.CODEETATRESA = r.CODEETATRESA");
				$req->execute(ARRAY("noHeb" => $_GET["noHeb"], "dateDebSem" => $_GET["dateDebSem"]));
				$donnees = $req->fetch();

				$req2 = $bdd->query("SELECT CODEETATRESA, NOMETATRESA FROM etat_resa");
		?>
				<table class="table">
				<tr>
					<td>Date</td>
					<td>User</td>
					<td>Date Arrhes</td>
					<td>Montant Arrhes</td>
					<td>nombre Occupant</td>
					<td>tarif semaine</td>
					<td>Etat</td>
					<td>Modifier</td>
				</tr>
				<tr>
					<td><?php echo $donnees["DATEDEBSEM"];?></td>
					<td><?php echo $donnees["USER"];?></td>
					<td><?php echo $donnees["DATEARRHES"];?></td>
					<td><?php echo $donnees["MONTANTARRHES"];?></td>
					<td><?php echo $donnees["NBOCCUPANT"];?></td>
					<td><?php echo $donnees["TARIFSEMRESA"];?></td>
					<td><?php echo $donnees["NOMETATRESA"];?></td>
					<td><form method=post action=modifEtatResa.php?noHeb=<?php echo $donnees['NOHEB'];?>&dateDebSem=<?php echo $donnees['DATEDEBSEM'];?>><select name=modifEtat>
		<?php
					while($donnees2 = $req2->fetch())
					{
						echo "<option value=".$donnees2['CODEETATRESA'].">".$donnees2['NOMETATRESA']."</option>";
					}
		?>
					</select><input type='submit' name='submit' value='modifier'></form></td>
					</tr>	
				</table>
				<a href=detailHebergement.php?noHeb=<?php echo $_GET['noHeb'];?>>Retour à la vue de l'hébergement</a>
				<a href="rechercheReservation.php?semaine=<?php echo $donnees['DATEDEBSEM'];?>&noHeb=<?php echo $donnees['NOHEB'];?>">Retour aux résultats de la recherche</a>	
			</div>
		</div>
		<?php
	}
		?>
		</div>
	</body>
</html>