<?php session_start(); 

if(!ISSET($_SESSION["user"]))
{
	//L'utilisateur une fois connecté est immédiatement redirigé vers cette page.
	$erreur = "<p>Accès refusé: Vous devez être connecté pour accéder à cette page.</p>";
	$page = "modificationHebergement.php";
	header("location:connexion.php?erreur=$erreur&redirectionVers=$page");
	exit();
}
else
	if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] != "loc")
	{
		$erreur = "<p>Accès refusé: Vous devez être administrateur pour accéder à la page modificationHebergement.php. <a href=rechercheHebergement.php>Retour vers la page d'accueil</a></p>";
		header("location: erreurAffichage.php?erreur=$erreur");
		exit();
	}

if(!ISSET($_GET["noHeb"]))
{
	$erreur = "<p>Il est nécessaire de rechercher et choisir un hébergement à modifier pour accéder à cette page. <a href=rechercheHebergement.php>Rechercher un hébergement</a></p>";
	header("location:erreurAffichage.php?erreur=$erreur");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier un hébergement</title>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>Modifier l'hébergement</h1>
	<?php
	if(ISSET($_GET["erreur"]))
	{
		echo $_GET["erreur"];
	}
	?>
	<form method="post" action="trt_modificationHebergement.php?noHeb=<?php echo $_GET["noHeb"]?>">
	<?php
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
	$req = $bdd->prepare("SELECT NOMHEB, NBPLACEHEB, SURFACEHEB, INTERNET, ANNEEHEB, SECTEURHEB, ORIENTATIONHEB, ETATHEB, DESCRIHEB, PHOTOHEB, TARIFSEMHEB FROM hebergement WHERE NOHEB = :noheb");
	$req->execute(ARRAY("noheb" => $_GET["noHeb"]));
	$donnees = $req->fetch();
	?>

		<label for="nomHebergement">Nom:</label>
		<input type="text" name="nomHebergement" value=<?php echo $donnees['NOMHEB'] ?> id="nomHebergement"/>

		<label for="typeHebergement">Type:</label>
		<select name="typeHebergement" id="typeHebergement">
			<?php
			$bdd2 = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
			$req2 = $bdd2->query("SELECT CODETYPEHEB, NOMTYPEHEB FROM type_heb");
			while($donnees2 = $req2->fetch())
			{
				echo "<option value=".$donnees2['CODETYPEHEB'].">".$donnees2['NOMTYPEHEB']."</option>";
			}
			?>
		</select>

		<label for="nombrePlace">Nombre de place:</label>
		<input type="number" name="nombrePlace" value=<?php echo $donnees['NBPLACEHEB']?> id="nombrePlace"/>

		<label for="surface">Surface:</label>
		<input type="number" name="surface" value=<?php echo $donnees['SURFACEHEB']?> id="surface"/>

		<label for="internet">Internet:</label>
		<?php 
		if($donnees['INTERNET'] == 1)
		{
			echo "<input type='radio' name='internet' value='1' checked/>Oui";
			echo "<input type='radio' name='internet' value='0'/>Non";
		}
		else
		{
			echo "<input type='radio' name='internet' value='1' />Oui";
			echo "<input type='radio' name='internet' value='0' checked/>Non";
		}
		?>
		<label for="anneeConstruction">Année construction:</label>
		<select name="anneeConstruction" id="anneeConstruction">
			<?php
				//Itérer les années à partir de l'année 1900 jusqu'à l'année actuelle
				$anneeActuelle = new DateTime("this year");
				$retourVersLePassee = new DateTime("01-01-1900");
				$intervalle = new DateInterval("P1Y");
				$periode = new DatePeriod($retourVersLePassee, $intervalle, $anneeActuelle);

				foreach($periode as $annee)
				{
					echo "<option value=".$annee->format('Y').">".$annee->format('Y')."</option>";
				}
			?>
		</select>

		<label for="secteur">Secteur</label>
		<input type="text" name="secteur" id="secteur" value="<?php echo $donnees['SECTEURHEB']?>"/>

		<label for="orientation">Orientation:</label>
		<input type="text" name="orientation" id="orientation" value="<?php echo $donnees['ORIENTATIONHEB'] ?>"/>

		<label for="etatHebergement">Etat:</label>
		<?php 
		if($donnees["ETATHEB"] == "Rénové")
		{
			echo "<input type='radio' name='etatHebergement' value='Rénové' checked />Rénové";
			echo "<input type='radio' name='etatHebergement' value='En rénovation'/>En rénovation";
		}
		else
		{
			echo "<input type='radio' name='etatHebergement' value='Rénové'/>Rénové";
			echo "<input type='radio' name='etatHebergement' value='En rénovation' checked/>En rénovation";
		}
		?>
		<label for="description">Description</label>
		<textarea name="description" id="description"><?php echo $donnees["DESCRIHEB"]?></textarea>

		<label for="tarifSemaine">Tarif/semaine</label>
		<input type="text" name="tarif" id="tarif" value="<?php echo $donnees['TARIFSEMHEB']?>"/>

		<label for="photoHebergment">Photo</label>
		<input type="text" name="photoHebergement" id="photoHebergment" value="<?php echo $donnees['PHOTOHEB']?>"/>
		
		<input type="submit" name="submit" value="Enregistrer" id="enregistrer"/>
	</form>
</body>
</html>