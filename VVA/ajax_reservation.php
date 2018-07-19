<?php
session_start();
/*$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
$req = $bdd->prepare("SELECT DATE_FORMAT(DATEDEBSEM, '%d/%m') as d FROM semaine WHERE MONTH(DATEDEBSEM) = ?");
$req->execute(ARRAY($_POST["mois"]));
while($donnees = $req->fetch())
{
	echo "<option value=".$donnees['DATEDEBSEM'].">".$donnees["d"]."</option>";
}*/

//Sélectionner les réservations qui ne sont pas déjà enregistrées pour l'hébergement sélectionné.

if(!ISSET($_SESSION["user"]))
{
		$erreur = "<p>ERREUR: Page inaccessible.</p>";
		$page = "rechercheReservation.php";
		header("location:connexion.php?erreur=$erreur&redirectionVers=$page");
}

if(!ISSET($_GET["noHeb"]) OR !ISSET($_POST["mois"]))
{
	header("location:rechercheReservation.php");
}

$nombreDeSemaines = 0;

$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
$req = $bdd->prepare("SELECT DATEDEBSEM, DATE_FORMAT(DATEDEBSEM, 'Du %W %d %M') as dd, DATEFINSEM, DATE_FORMAT(DATEFINSEM, ' au %W %d %M') as df  FROM semaine WHERE DATEDEBSEM NOT IN (SELECT DATEDEBSEM FROM resa WHERE NOHEB = ?) AND MONTH(DATEDEBSEM) = ? AND YEAR(DATEDEBSEM) = ? AND DATEDEBSEM > CURDATE()");
$req->execute(ARRAY($_GET["noHeb"], $_POST["mois"], $_POST["annee"]));
echo "<option value='' disabled>Semaine</option>";

while($donnees = $req->fetch())
{
	$nombreDeSemaines++;	
	echo "<option value=".$donnees['DATEDEBSEM'].">".$donnees["dd"].$donnees["df"]."</option>";
}

if($nombreDeSemaines == 0)
{
	echo "<option disabled selected>Pas de semaine disponible</option>";
}
?>