<?php
//METHODE DES CONDITIONS
session_start(); 
$erreur = null;
if(!ISSET($_POST["semaine"]) OR !$_POST["nbOccupant"] > 0)
{
	if(!ISSET($_POST["semaine"]))
	{
		$erreur .= "<li>Sélectionner une semaine.</li>";
	}
	if(!$_POST["nbOccupant"] > 0)
	{
		$erreur .= "<li>Indiquer un nombre d'occupant supérieur  à 0. </li>";
	}
}
else
	if(ISSET($_POST["semaine"]) AND $_POST["nbOccupant"] > 0)
	{
		$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
		$req = $bdd->prepare("INSERT INTO resa(NOHEB, DATEDEBSEM, USER,	CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA) VALUES(:noHeb, :dateDebSem, :user, :codeEtatResa, NOW(), :dateArrhes, :montantArrhes, :nbOccupant, :tarifSemResa)");
		if($req->execute(ARRAY("noHeb" => $_GET["noHeb"],
							"dateDebSem" => $_POST["semaine"],
							"user" => $_SESSION["user"],
							"codeEtatResa" => "1",
							"dateArrhes" => null,
							"montantArrhes" => null,
							"nbOccupant" => $_POST["nbOccupant"],
							"tarifSemResa" => $_GET["tarifSemHeb"])))
		{
			echo "Votre réservation a été prise en compte";
		}
	}
	if($erreur !=null)
	{	
		echo "<h3>Erreurs:</h3>";	
		echo "<ul>".$erreur."</ul>";
	}
echo "<a href='detailHebergement.php?noHeb=$_GET[noHeb]'>Retour la vue de l'hébergement</a>";

/* 
METHODE DES BOOLEENS
session_start(); 
$saisiEstCorrecte = true;
if(!ISSET($_POST["semaine"]) AND ISSET($_POST["nbOccupant"]) AND $_POST["nbOccupant"] >= 1)
{
	$erreur .= "Sélectionner une semaine.</br>";
	$saisiEstCorrecte = false;
}
if(!$_POST["nbOccupant"] > 0)
{
	$erreur .= "Indiquer un nombre d'occupant supérieur  à 0. </br>";
	$saisiEstCorrecte = false;
}
if($saisiEstCorrecte == true;)
{
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("INSERT INTO resa(NOHEB, DATEDEBSEM, USER,	CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA) VALUES(:noHeb, :dateDebSem, :user, :codeEtatResa, NOW(), :dateArrhes, :montantArrhes, :nbOccupant, :tarifSemResa)");
	if($req->execute(ARRAY("noHeb" => $_GET["noHeb"],
						"dateDebSem" => $_POST["semaine"],
						"user" => $_SESSION["user"],
						"codeEtatResa" => "1",
						"dateArrhes" => null,
						"montantArrhes" => null,
						"nbOccupant" => $_POST["nbOccupant"],
						"tarifSemResa" => $_GET["tarifSemHeb"])))
	{
		echo "Votre réservation a été prise en compte";
	}
}
else
	if($saisiEstCorrecte == false)
{
	echo $erreur;
}
echo "<a href='detailHebergement.php?noHeb=$_GET[noHeb]'>Retour la vue de l'hébergement</a>";
*/

/*<?php
//METHODE INITIALE
session_start(); 
if(ISSET($_POST["semaine"]) AND ISSET($_POST["nbOccupant"]) AND $_POST["nbOccupant"] >= 1)
{
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("INSERT INTO resa(NOHEB, DATEDEBSEM, USER,	CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA) VALUES(:noHeb, :dateDebSem, :user, :codeEtatResa, NOW(), :dateArrhes, :montantArrhes, :nbOccupant, :tarifSemResa)");
	if($req->execute(ARRAY("noHeb" => $_GET["noHeb"],
						"dateDebSem" => $_POST["semaine"],
						"user" => $_SESSION["user"],
						"codeEtatResa" => "1",
						"dateArrhes" => null,
						"montantArrhes" => null,
						"nbOccupant" => $_POST["nbOccupant"],
						"tarifSemResa" => $_GET["tarifSemHeb"])))
	{
		echo "Votre réservation a été prise en compte";
	}
}
else
{
	echo "Vous n'avez pas renseigné toutes les informations de réservation.";
	echo "<a href='detailHebergement.php?noHeb=$_GET[noHeb]'>Retour la vue de l'hébergement</a>";
}

*/