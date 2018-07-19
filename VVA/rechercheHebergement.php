<?php 
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Rechercher un hébergement</title>
		<meta charset="utf-8"/>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="style2.css" rel="stylesheet">
	</head>
	<body>
	<div class="container-fluid">
	<?php include("headerNav.php") ?>
	<h1>Rechercher des hébergements</h1>
	<?php

	/*if(ISSET($_POST["submit"]))
	{
		$saisiVide = 0;
		foreach($_POST as $key => $value)
		{
			if(EMPTY($_POST[$key]) AND $_POST[$key] == null)
			{
				$saisiVide++;
			}
		}
		if($saisiVide>0)
		{
			$erreur = "<p>Erreur: Toutes les informations n'ont pas été renseignées. L'envoi du formulaire n'a donc pas été prise en compte.</p>";
			header("location: rechercheHebergement.php?erreur=$erreur");
		}
	}*/

	if(ISSET($_GET["erreur"]))
	{
		echo $_GET["erreur"];
	}
	?>
	<!-- ZONE PANEL DE RECHERCHE-->
	<div class="row">
		<div class="col-lg-3">
			<div class="card">
				<div class="card-header">
					<h5>Critères attendus</h5>
				</div>
				<div class="card-body">
					<form method="post">
						<fieldset class="form-group">
							<label>Type:</label>
							<!-- Requête SQL lister tous les types d'hébergement-->
							
								<?php
								$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
								$requete = $bdd->query("SELECT CODETYPEHEB, NOMTYPEHEB FROM type_heb");
								while($donnees = $requete->fetch())
								{
									echo "<div class='form-check'>";
									echo "<input type='checkbox'  name='code[]'  value='".$donnees['CODETYPEHEB']."'/><label class='form-check-label'>".$donnees['NOMTYPEHEB']."</label>";
									echo "</div>"; 
								}
								?>
						</fieldset>		
						<div class="form-group">
							<label for="surfaceHabitableMini">Surface mini. habitable (en m2) souhaitée: </label>
							<input type="number" class="form-control" name="surface"/>	
							<!-- input type="range" name="surface" value="25" min="0" max="50"/>  -->		
						</div>
						<div class="form-group">
							<label for="nombreDePlace">Nombre de place minimum souhaité:</label>
							<input type="number" class="form-control" name="nombreDePlace"/>
						</div>
						<fieldset class="form-group">
							<label>Connexion internet:</label>
							<div class='form-check'>
								<input type="radio"   name="connexion" value="1"/><label for="oui" class='form-check-label'>Oui</label>
							</div>
							<div class='form-check'>
								<input type="radio" name="connexion" value="0"/><label for="Peu importe" class='form-check-label'>Peu importe</label>
							</div>			
						</fieldset>
						<div class="form-group">
							<label for="tarif">Tarif maximum de la semaine:</label>
							<input type="text" class="form-control" name="tarif"/>					
						</div>

						<input type="submit" name="submit" value="Rechercher" class="btn btn-primary"/>
					</form>
				</div>
			</div>
		</div>
		<!-- ZONE AFFICHAGE HEBERGEMENTS-->
		<div class="col-lg-9">
		<?php

		if(!ISSET($_POST["submit"]) AND !ISSET($_GET["submit"]))
		{
			?>
			<div class="alert alert-primary" role="alert">
  			Effectuez une recherche grâce au panel "Critères attendus".
			<?php
		}
		else
		{
			$saisiVide = 0;
			foreach($_POST as $key => $value)
			{
				if(EMPTY($_POST[$key]) AND $_POST[$key] == null)
				{
					$saisiVide++;
				}
			}
			if($saisiVide>0)
			{
				?>
				<div class="alert alert-warning" role="alert">
	  			Veuillez renseigner tous les critères pour préciser la recherche.
				</div>
				<?php
			}
			else
			{
			if(ISSET($_GET["nombreDePlace"]) && ISSET($_GET["surface"]) && ISSET($_GET["tarif"]) && ISSET($_GET["code"]) && ISSET($_GET["submit"]))
			{
				$_POST["nombreDePlace"] = $_GET["nombreDePlace"];
				$_POST["surface"] = $_GET["surface"];
				$_POST["tarif"] = $_GET["tarif"];
				$_POST["code"] = $_GET["code"];
				$_POST["submit"] = $_GET["submit"];
			}
			
			$codeTypeHeb = implode(",",$_POST["code"]);	

			$nombreDeHebergement = 0;
			$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
			
			//Compte du nombre de pages requises pour 4 hébegrements par page
			$req = $bdd->prepare("SELECT COUNT(NOHEB) as nombreDHebergement 
								  FROM hebergement
								  WHERE CODETYPEHEB IN ($codeTypeHeb)
								  AND NBPLACEHEB >= :nbPlaceHeb
								  AND SURFACEHEB >= :surfaceHeb
								  AND TARIFSEMHEB <= :tarifsemHeb");
			$req->execute(ARRAY(/*"codeTypHeb" => implode("," , $_POST["code"]),*/
								"nbPlaceHeb" => $_POST["nombreDePlace"],
								"surfaceHeb" => $_POST["surface"],
								"tarifsemHeb" => $_POST["tarif"])); 
			$donnees = $req->fetch();
			$nombreProduitParPage = 4;
			$nombreDePage = ceil($donnees["nombreDHebergement"]/$nombreProduitParPage);
			
			if(empty($_GET["numeroPageChoisi"]))
				$numeroPageActuel = 1;
			else
				$numeroPageActuel = $_GET["numeroPageChoisi"];

			$rangPremierProduit = ($numeroPageActuel-1)*$nombreProduitParPage;

			$req = $bdd->prepare("SELECT NOHEB, CODETYPEHEB,NOMHEB, NBPLACEHEB,SURFACEHEB, INTERNET, ANNEEHEB, SECTEURHEB, ORIENTATIONHEB, ETATHEB, SUBSTRING(DESCRIHEB, 1, 20) as DESCRIHEB, PHOTOHEB, TARIFSEMHEB 
								  FROM hebergement
								  WHERE CODETYPEHEB IN ($codeTypeHeb)
								  AND NBPLACEHEB >= :nbPlaceHeb
								  AND SURFACEHEB >= :surfaceHeb
								  AND TARIFSEMHEB <= :tarifsemHeb
								  LIMIT $rangPremierProduit, $nombreProduitParPage");					
			$req->execute(ARRAY(/*"codeTypHeb" => implode("," , $_POST["code"]),*/
								"nbPlaceHeb" => $_POST["nombreDePlace"],
								"surfaceHeb" => $_POST["surface"],
								"tarifsemHeb" => $_POST["tarif"])); 
			echo "<div class='row justify-content-md-center'>";
						
			while($donnees = $req->fetch())
			{
				if($nombreDeHebergement%2 == 0)
				{
					echo "</div>";
					echo "<div class='row justify-content-md-center'>";
				}
				$nombreDeHebergement++;
				echo "<div class='col-lg-5'>";
					echo "<div class='card'>";
						echo "<img class='card-img-top' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22363%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20363%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1607856a673%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A18pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1607856a673%22%3E%3Crect%20width%3D%22363%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22135.45000076293945%22%20y%3D%2298.27999954223632%22%3E363x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' alt='Card image cap'>";
						
						echo "<div class='card-header'>";
			    			echo "<ul>";
				    			echo "<div class='row justify-content-center'>";
					    			echo "<div class='col-lg-3'>";
										echo "<li><img src='png/glyphicons-496-bed-alt.png' alt='Nombre de place disponibles'/> ".$donnees["NBPLACEHEB"]."</li>";
									echo "</div>";
									echo "<div class='col-lg-3'>";
										echo "<li><img src='png/glyphicons-778-ruler-alt.png'> ".$donnees["SURFACEHEB"]."m²</li>";
									echo "</div>";
									echo "<div class='col-lg-3'>";
										echo "<li><img src='png/glyphicons-74-wifi.png' alt='Connexion internet'> ".$donnees["INTERNET"]."</li>";
									echo "</div>";
									echo "<div class='col-lg-3'>";
										echo "<li><img src='png/glyphicons-734-nearby-square.png'> ".$donnees["SECTEURHEB"]."</li>";
									echo "</div>";
				    			echo "</div>";
			    			echo "</ul>";
		  				echo "</div>";
						
						echo "<div class='card-body'>";
							echo "<ul>";				
								echo "<h4 class='card-title'><li>".$donnees["NOMHEB"]."</li></h4>";
								echo "<h6 class='card-subtitle mb-2 text-muted'><li>".$donnees["TARIFSEMHEB"]."€/semaine</li></h6>";

								//echo "<li>Description: ".$donnees["DESCRIHEB"]."[...]</li>";
								echo "<li>Année construction: ".$donnees["ANNEEHEB"]."</li>";
								echo "<li>Orientation: ".$donnees["ORIENTATIONHEB"]."</li>";
								echo "<li>Etat: ".$donnees["ETATHEB"]."</li>";
								/*$popoverContent = "Année construction: ".$donnees["ANNEEHEB"];
								$popoverContent .= "Orientation: ".$donnees["ORIENTATIONHEB"];
								$popoverContent .= "Etat: ".$donnees["ETATHEB"];*/
								echo "<button type='button' class='btn btn-outline-info btn-sm' data-container='body' data-toggle='popover' data-placement='top' data-content='".$donnees["DESCRIHEB"]."'>Description</button>";
									//echo "<li>".$donnees["PHOTOHEB"]."</li>";
									
									//gestionnaire
									echo "<li><a href='detailHebergement.php?noHeb=$donnees[NOHEB]'>Détails</a></li>";
									
								if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] == "loc")
								{
									echo "<li><a href='modificationHebergement.php?noHeb=$donnees[NOHEB]'>Modifier</a></li>";
									echo "<li><a href='detailHebergement.php?noHeb=$donnees[NOHEB]'>Voir les réservations</a></li>";
								}				
							echo "</ul>";
						echo "</div>";	
					echo "</div>";
				echo "</div>";
			}
			echo "</div>";		
			if($nombreDeHebergement == 0)
				echo "<p>Aucun hébergement ne correspond à vos critères</p>";
			?>
			<nav aria-label = "page navigation">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				        <span class="sr-only">Previous</span>
		     		</a>
				</li>
				<?php
				$code = http_build_query(array('code'=>$_POST["code"]));
				for($i = 1; $i<=$nombreDePage; $i++)
				{	
					?>
					 <li class="page-item"><a class="page-link" href="rechercheHebergement.php?submit=<?php echo $_POST['submit'];?>&numeroPageChoisi=<?php echo $i;?>&nombreDePlace=<?php echo $_POST['nombreDePlace'];?>&surface=<?php echo $_POST['surface'];?>&tarif=<?php echo $_POST['tarif'];?>&<?php echo $code;?>"><?php echo $i; ?></a></li>
					 <?php
				}
				?>
				<li class="page-item">
			      <a class="page-link" href="#" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			        <span class="sr-only">Next</span>
			      </a>
			    </li>
			</ul>
			</div>
			</div>
			</nav>
			<?php
			}
		}
		?>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.bundle.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<script>
		$(function() {
		  $('[data-toggle="popover"]').popover();
		});
		</script>
	</body>
</html>