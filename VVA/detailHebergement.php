<?php session_start(); 

if(!ISSET($_GET["noHeb"]))
{
	header("location:rechercheHebergement.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Détails de l'hébergement</title>
	<meta charset="utf-8"/>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="style2.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<?php include("headerNav.php");?>
	<h1>Détail de l'hébergement:</h1>
	<?php
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("SELECT NOHEB, CODETYPEHEB,NOMHEB, NBPLACEHEB,SURFACEHEB, INTERNET, ANNEEHEB, SECTEURHEB, ORIENTATIONHEB, ETATHEB, DESCRIHEB, PHOTOHEB, TARIFSEMHEB
						  FROM hebergement
						  WHERE NOHEB = ?");
	$req->execute(ARRAY($_GET["noHeb"]));
	$donnees = $req->fetch();

	/*echo "<ul>";
		echo "<li>".$donnees["NOMHEB"]."</li>";
		echo "<li>".$donnees["NBPLACEHEB"]."</li>";
		echo "<li>".$donnees["SURFACEHEB"]."</li>";
		echo "<li>".$donnees["INTERNET"]."</li>";
		echo "<li>".$donnees["ANNEEHEB"]."</li>";
		echo "<li>".$donnees["SECTEURHEB"]."</li>";
		echo "<li>".$donnees["ORIENTATIONHEB"]."</li>";
		echo "<li>".$donnees["ETATHEB"]."</li>";
		echo "<li>".$donnees["DESCRIHEB"]."</li>";
		echo "<li>".$donnees["PHOTOHEB"]."</li>";
		echo "<li>".$donnees["TARIFSEMHEB"]."</li>";		
	echo "</ul>";*/

	//ROW CONTENANT L'AFFICHAGE DE l'HEBERGEMENT ET DU PANNEAU DE RESERVATION ~> l.203
	?>
	<div class="row">
		<!--AFFICHAGE DE l'HEBERGEMENT -->
		<div class="col-lg-8">
			<div class='card'>
				<img class='card-img-top' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22363%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20363%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1607856a673%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A18pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1607856a673%22%3E%3Crect%20width%3D%22363%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22135.45000076293945%22%20y%3D%2298.27999954223632%22%3E363x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' alt='Card image cap'>
				
				<div class='card-header'>
					<ul>
		    			<div class='row justify-content-center'>
			    			<div class='col-lg-3'>
								<li><img src='png/glyphicons-496-bed-alt.png' alt='Nombre de place disponibles'/><?php echo $donnees["NBPLACEHEB"];?></li>
							</div>
							<div class='col-lg-3'>
								<li><img src='png/glyphicons-778-ruler-alt.png'><?php echo $donnees["SURFACEHEB"];?>m²</li>
							</div>
							<div class='col-lg-3'>
								<li><img src='png/glyphicons-74-wifi.png' alt='Connexion internet'><?php echo $donnees["INTERNET"];?></li>
							</div>
							<div class='col-lg-3'>
								<li><img src='png/glyphicons-734-nearby-square.png'><?php echo $donnees["SECTEURHEB"];?></li>
							</div>
		    			</div>
					</ul>
				</div>
				<div class='card-body'>
					<ul>	
					<h4 class='card-title'><li><?php echo $donnees["NOMHEB"];?></li></h4>
						<h6 class='card-subtitle mb-2 text-muted'><li><?php echo $donnees["TARIFSEMHEB"];?>€/semaine</li></h6>

						<li>Année construction:<?php echo  $donnees["ANNEEHEB"];?></li>
						<li>Orientation: <?php echo $donnees["ORIENTATIONHEB"];?></li>
						<li>Etat: <?php echo $donnees["ETATHEB"];?></li>
						<li><?php echo $donnees["DESCRIHEB"];?><li>
						
						
						<?php	
						//Réservées au gestionnaire
						if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] == "loc")
						{
							echo "<li><a href='modificationHebergement.php?noHeb=$donnees[NOHEB]'>Modifier les caractéristiques</a></li>";
						}
						?>				
					</ul>
				 </div>
		 	</div>
	 	</div>
	 
	 <?php
	$nbPlace = $donnees["NBPLACEHEB"];
	$tarifSemHeb = $donnees["TARIFSEMHEB"];

	$req->closeCursor();

	//PANNEAU RESERVATION 
	?>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<h5>Réserver cet hébergement:</h5>
				</div>
				<div class="card-body">
					<?php
					if(ISSET($_SESSION["user"]) OR ISSET($_SESSION["loc"]))
					{
						echo "<div class='alert alert-info' role='alert'>";
						echo "La durée d'une réservation est d'une semaine. Une réservation est effective d'un samedi, à celui de la semaine suivante. Si vous souhaitez réserver pour plusieurs semaines, réitérez le processus de réservation autant de fois que nécessaire.";
						echo "</div>";
						//Création des listes déroulantes pour le choix des dates de réservations
						$DateEnCours = new DateTime("now");
						
						$anneeEnCours = $DateEnCours->format("Y");
						$anneeSuivante = $anneeEnCours+1;
						
						$intervalle = new DateInterval("P1M");
						
						$DernierMoisDeLAnnee = new DateTime("$anneeEnCours/12/31");
						$periodeAnneeActuelle = new DatePeriod($DateEnCours, $intervalle, $DernierMoisDeLAnnee);

						$dernierMoisAnneeSuivante = new DateTime($anneeSuivante."/12/31");
						$premierMoisAnneeSuivante = new DateTime($anneeSuivante."/01/01");
						$periodeAnneeSuivante = new DatePeriod($premierMoisAnneeSuivante, $intervalle, $dernierMoisAnneeSuivante );
						/*
						echo "<ul>";
						echo "<li><a href='detailHebergement.php?noHeb=$_GET[noHeb]'>". $anneeEnCours ."</a></li>";
						echo "<li><a href='detailHebergement.php?anneeResa=$anneeSuivante&noHeb=$_GET[noHeb]'>". $anneeSuivante ."</a></li>";
						echo "</ul>";
						*/
						?>
						<form method="post" action="trt_Reservation.php?noHeb=<?php echo $_GET['noHeb']?>&tarifSemHeb=<?php echo $tarifSemHeb?>">
							<div class="form-group">
								<label for="annee">Année</label>
								<select name="annee" class="form-control" id="annee">
									<option value="" disabled>Année</option>
								<?php
									echo "<option value=".$anneeEnCours."selected>".$anneeEnCours."</option>";
									echo "<option value=".$anneeSuivante.">".$anneeSuivante."</option>";
								?>
								</select>
							</div>	
							<div class="form-group">
								<label for="mois">Mois</label>
								<select name="mois" class="form-control" id="mois">
									<option value="" disabled>Mois</option>
									<?php									
									foreach($periodeAnneeActuelle as $mois)
									{
										if($mois->format('n') == $DateEnCours->format('n'))
										{
											echo "<option value=".$mois->format('n')."selected>".$mois->format("F")."</option>";
										}
										else
										{
											echo "<option value=".$mois->format('n').">".$mois->format("F")."</option>";
										}							
									}
									?>
								</select>
							</div>
							<div class="form-group">		
								<label for="semaine">Semaine</label>
								<select name="semaine" id="semaine" class="form-control">
									<option value="" disabled>Semaine</option>				
									<?php
									$nombreDeSemaine = 0;
									$bdd2 = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
									$req2 = $bdd2->query("SELECT DATEDEBSEM, DATE_FORMAT(DATEDEBSEM, 'Du %W %d %M') as dd, DATEFINSEM, DATE_FORMAT(DATEFINSEM, ' au %W %d %M') as df FROM semaine WHERE DATEDEBSEM > CURDATE() AND MONTH(DATEDEBSEM) = 	MONTH(CURDATE()) AND YEAR(DATEDEBSEM) = YEAR(CURDATE()) AND DATEDEBSEM NOT IN (SELECT DATEDEBSEM FROM resa WHERE NOHEB = $_GET[noHeb])");
									while($donnees2 = $req2->fetch())
									{
										$nombreDeSemaine++;
										echo "<option value=".$donnees2['DATEDEBSEM'].">".$donnees2["dd"].$donnees2["df"]."</option>";
									}
									$req2->closeCursor();
									?>	
								</select>
							</div>
							<div class="form-group">	
								<label for="nbOccupant">Nombre d'occupant(s):</label>
								<select name="nbOccupant" id="nbOccupant" class="form-control">
									<?php
									for($i = 0; $i<=$nbPlace; $i++)
									{
										echo "<option value=".$i.">".$i."</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<input type="submit"  name="confirmerReservation" value="Réserver" id="confirmerReservation" class="btn btn-primary"/>
							</div>
						</form>
					
				
			
		
					<?php

			
				
					}
					elseif (!ISSET($_SESSION["user"])) 
					{
						echo "<p><a href=connexion.php?redirectionVers=detailHebergement.php?noHeb=$_GET[noHeb]>Connectez-vous</a> pour réserver.</p>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
	//AFFICHAGE DES RESERVATIONS ENREGISTREES LIE A CET HEBERGEMENT
	if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] == "loc") 
	{
		?>
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-header">
						<h5>Liste des réservations enregistrées pour cet hébergement:</h5>
					</div>	
					<div class="card-body">				
						<?php
						
						$bdd3 = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
						$req3 = $bdd->prepare("SELECT r.NOHEB, r.DATEDEBSEM, r.USER, e.NOMETATRESA, s.DATEFINSEM FROM resa r, semaine s, etat_resa e WHERE r.NOHEB = ? AND r.CODEETATRESA = e.CODEETATRESA AND r.DATEDEBSEM = s.DATEDEBSEM AND s.DATEFINSEM > CURDATE()");
						$req3->execute(ARRAY($_GET["noHeb"]));
						$i = 0;
						?>
						 <table class="table">
						 	<thead>
								 <tr>
								 <td>Date</td>
								 <td>User</td>
								 <td>Etat</td>
								 <td>Option</td>
								 </tr>
							 <thead>
							 <tbody>
							<?php
							while($donnees3 = $req3->fetch())
							{
								$i++;
								echo "<tr>";
								echo "<td>Du ".$donnees3["DATEDEBSEM"]." au ".$donnees3["DATEFINSEM"]."</td>";
								echo "<td>".$donnees3["USER"]."</td>";
								echo "<td>".$donnees3["NOMETATRESA"]."</td>";
								echo "<td><a href='detailReservation.php?noHeb=$donnees3[NOHEB]&dateDebSem=$donnees3[DATEDEBSEM]&nomEtatResa=$donnees3[NOMETATRESA]'>Consulter pour modifier</a></td>";
								echo "</tr>";		
							}
							?>
							</tbody>
						</table>
						<?php
						if($i == 0)
						{
							echo "Aucune réservation pour cet hébergement.";
						}	
						?>
					</div>	
				</div>
			</div>
		</div>
		<?php	
	}
	?>

	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			/*var $dateResa = null;
			$("#ajx_semaine li").on("click", function(e)
			{
				$dateResa = $(this ).attr("id");
			});

			$("#confirmerReservation").on("click", function(e){
				e.preventDefault();

				$.post
				(
					"ajax_reservation_a.php",
					{
						nbOccupant: $("#nbOccupant").val(),
						semaine: $dateResa,
						noHeb: <?php echo $_GET['noHeb'] ?>,
						tarifSemHeb: <?php echo $tarifSemHeb ?>
					},
					function(data)
					{
						alert(data);
					},
					"text"
				);	
			});*/

			$("#annee").on("change", function(e)	
			{				
				$.post
				(
					"ajax_reservation_mois.php?",
					{
						annee: $("#annee").val()
					},
					function(data)
					{
						$("#mois").html(data);
						$("#mois").trigger("change");
					},
					"text"
				);
				
			});

			$("#mois").on("change", function(e)
			{
				$.post
				(
					"ajax_reservation.php?noHeb=<?php echo $_GET['noHeb']?>",
					{
						mois: $("#mois").val(),
						annee: $("#annee").val()
					},
					function(data)
					{
						$("#semaine").html(data);
					},
					"text"
				);
			});
			
		});
		
	</script>
</body>
</html>
<!-- Afficher liste semaine en fonction du mois choisi