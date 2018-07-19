
<?php session_start();

if(!ISSET($_SESSION["user"]))
{
	$erreur = "<p>ERREUR: Vous devez être connecté pour accéder à cette page.</p>";
	$page = "rechercheReservation.php";
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
	<title>Recherche de réservation</title>
	<meta charset="utf-8"/>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="style2.css" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		<?php include("headerNav.php");?>
		<div class="card">
			<div class="card-header">
				<h5>Rechercher des réservations</h5>
			</div>
			<div class="card-body">
				<p>Cette interface permet de lister toutes les réservations enregistrées pour la date sélectionnée ci-dessous.</p>
				<form method="post">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="mois" >Mois:</label>
								<select name="mois" id="mois" class="form-control">
									
									<?php
									//RECHERCHE PAR SEMAINE

									$Mois = array("1" =>"Janvier", "2" => "Février", "3"=>"Mars", "4"=>"Avril", "5" => "Mai", "6" => "Juin", "7" => "Juillet", "8" => "Août", "9" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Décembre");
									
									/*$dateActuelle = new DateTime("now");
									$anneeActuel = $dateActuelle ->format("Y");
									$dernierJourAnnee = new DateTime("31-12-$anneeActuel");
									$intervalle = new DateInterval("P1M");
									$periode = new DatePeriod($dateActuelle, $intervalle, $dernierJourAnnee);*/
									
									//Liste tous les mois compris entre la date actuelle et le dernier jour de l'année. Et formatage en français du nom du mois.
									foreach($Mois as $numero => $mois)
									{
										echo "<option value=".$numero.">".$mois."</option>";

									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="semaine">Semaine:</label>
								<select name="semaine" id="semaine" class="form-control">
								<?php
								$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
									$req = $bdd->query("SELECT DISTINCT DATEDEBSEM FROM resa WHERE MONTH(DATEDEBSEM) = 1 AND DATEDEBSEM > CURDATE()");
									while($donnees = $req->fetch())
									{
										echo "<option value=$donnees[DATEDEBSEM]>".$donnees["DATEDEBSEM"]."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>	
					<div class="form-group">
						<input type="submit" name="submit" id="rechercherResa" class="btn btn-primary" />
					</div>								
				</form>
			</div>
		</div>	
	<?php 
	include("trt_rechercheReservation.php"); 
	?>

	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
	$("#mois").on("change", function(e){
		$.post(
			"ajax_rechercheReservation.php",
			{
				mois:$("#mois").val()
			},
			function(data)
			{
				$("#semaine").html(data);
			},
			"text"
		);
	});
</script>
</body>
</html>