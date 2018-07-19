<?php

session_start();

if(!ISSET($_POST["submit"]))
{
	//Des contrôles de validité présents sur la page ciblée par le header peuvent induire une redirection vers la page de connexion si ces contrôles ne sont pas respectés.
	header("location:rechercheReservation.php");
}

	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("UPDATE resa SET CODEETATRESA = ? WHERE DATEDEBSEM =? AND NOHEB = ?");
	if($req->execute(ARRAY($_POST["modifEtat"], $_GET["dateDebSem"], $_GET["noHeb"])))
		echo "La modification a été prise en compte.";
		echo "<a href=detailReservation.php?noHeb=$_GET[noHeb]&dateDebSem=$_GET[dateDebSem]>Voir la modification</a>";


