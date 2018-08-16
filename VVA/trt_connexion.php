<?php
if(ISSET($_POST["user"]) AND ISSET($_POST["mdp"]))
{
	$user = $_POST["user"];
	$mdp = $_POST["mdp"];

	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("SELECT USER, MDP, TYPECOMPTE FROM compte WHERE user = ? AND mdp = ?");
	$req->execute(ARRAY($user, $mdp));
	if(!$donnees = $req->fetch())
	{
		echo "Aucun utilisateur ne correspond à ces identifiants.";
		echo "<br><a href='connexion.php'>Retour à la page de connexion</a>";
	}
	else
	{
		session_start();
		$_SESSION["user"] = $user;
		$_SESSION["typeUtil"] = $donnees["TYPECOMPTE"];
		//L'utilisateur est dirigé vers une page particulière (url stocké dans le tableau $_GET) lorsqu'il a été redirigé vers la page de connexion après avoir tenté d'accéder à la page en question...
		if(ISSET($_GET["redirectionVers"]))
		{
			$redirectionVers = $_GET["redirectionVers"];
			/*if($redirectionVers == "rechercheReservation.php");*/
			header("location: $redirectionVers");
		}

		else
		{
			header("location: rechercheHebergement.php");
		}
	}
}
