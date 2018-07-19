<?php
session_start();
//Si l'utilisateur n'est pas connecté, ou que ce n'est pas un administrateur le rediriger vers la page de connexion. La connexion dirigera directement l'utilisateur vers la page de réservation.
if(!ISSET($_SESSION["user"]) OR $_SESSION["typeUtil"] != "loc")
{
	$erreur = "<p>ERREUR: Page inaccessible.</p>";
	$page = "rechercheReservation.php";
	header("location:connexion.php?erreur=$erreur&redirectionVers=$page");
}
if(!ISSET($_POST["mois"]))
{
	header("location:rechercheReservation.php");
}
else
{
	//Afficher les dates supérieurs à la date actuelle et qui correspondent au mois choisi dans la liste
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("SELECT DISTINCT DATEDEBSEM FROM resa WHERE MONTH(DATEDEBSEM) = ? AND DATEDEBSEM > CURDATE() ");
	$req->execute(ARRAY($_POST["mois"]));
	while($donnees = $req->fetch())
	{
		echo "<option value=$donnees[DATEDEBSEM]>$donnees[DATEDEBSEM]</option>";
	}
}
?>