<?php

$user = $_POST["user"];
$mdp = $_POST["motDePasse"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$adrMail = $_POST["adresseMail"];
$noTel = $_POST["numeroTelephone"];
$noPort= $_POST["numeroTelephonePort"];


echo $_POST["user"];
echo $_POST["motDePasse"];
echo $_POST["nom"];
echo $_POST["prenom"];
echo $_POST["adresseMail"];
echo $_POST["numeroTelephone"];
echo $_POST["numeroTelephonePort"];

$bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
$req = $bdd->prepare("INSERT INTO compte(USER, MDP,NOMCPTE,PRENOMCPTE,DATEINSCRIP,DATEFERME, TYPECOMPTE,ADRMAILCPTE, NOTELCPTE, NOPORTCPTE) VALUES(:user, :mdp, :nomCpte, :prenomCpte:, NOW(), NOW(), 'utilisateur', :adrMailCpte, :noTelCpte, :noPortCpte)");
$req->execute(ARRAY("user"=> $user,
					"mdp"=> $mdp,
					"nomCpte"=>$nom,
					"prenomCpte"=>$prenom,
					"nomCpte"=>$nom,
					"adrMailCpte"=>$adrMail,
					"noTelCpte"=>$noTel,
					"noPortCpte"=>$noPort));

