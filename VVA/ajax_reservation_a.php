<?php
session_start();

$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
		$req = $bdd->prepare("INSERT INTO resa(NOHEB, DATEDEBSEM, USER,	CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA) VALUES(:noHeb, :dateDebSem, :user, :codeEtatResa, NOW(), :dateArrhes, :montantArrhes, :nbOccupant, :tarifSemResa)");
		if($req->execute(ARRAY("noHeb" => $_POST["noHeb"],
							"dateDebSem" => $_POST["semaine"],
							"user" => $_SESSION["user"],
							"codeEtatResa" => "1",
							"dateArrhes" => null,
							"montantArrhes" => null,
							"nbOccupant" => $_POST["nbOccupant"],
							"tarifSemResa" => $_POST["tarifSemHeb"])))
		{
			echo "Votre réservation a été prise en compte";
		}
