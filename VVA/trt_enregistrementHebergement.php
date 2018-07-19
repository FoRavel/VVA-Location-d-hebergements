<?php

if(!ISSET($_POST["submit"]))
{
	header("location: creerHebergement.php");
	exit();
}
else
{
	$saisiVide = 0;
	if(ISSET($_POST["submit"]))
	{
		foreach($_POST as $key => $value)
		{
			if(EMPTY($_POST[$key]))
			{
				$saisiVide++;
			}
		}
	}
	if($saisiVide>0)
	{
		$erreur = "<p>Erreur: Toutes les informations n'ont pas été renseignées. L'envoi du formulaire n'a donc pas été prise en compte.</p>";
		header("location: creerHebergement.php?erreur=$erreur");
		exit();
	}
}

$nomHeb = $_POST["nomHebergement"];
$codeTypeHeb = $_POST["typeHebergement"];
$nbPlace = $_POST["nombrePlace"];
$surface = $_POST["surface"];
$internet = $_POST["internet"];
$anneeConstruction = $_POST["anneeConstruction"];
$secteur = $_POST["secteur"];
$orientation = $_POST["orientation"];
$etatHeb = $_POST["etatHebergement"];
$descriHeb = $_POST["description"];
$tarifSemHeb = $_POST["tarif"];
$photo = $_POST["photoHebergement"];
$erreur = "";
$saisiEstCorrecte = true;
//Si la valeur du tarif est décimale et qu'elle comporte une virgule, remplacer celle-ci par un point.
$regexMatchTarif = "#^[0-9]+[.,]?[0-9]*$#";
$regexReplaceTarif = "#,#";

if(preg_match($regexMatchTarif, $tarifSemHeb))
{
	$tarifSemHeb = preg_replace($regexReplaceTarif, ".", $tarifSemHeb);
}
else
{
	$erreur .= "<li>Erreur format: Le format du tarif doit être sous forme numérique décimale ou entière, sans le symbole €. (exemple: 152.13)</li></br>";
	$saisiEstCorrecte = false;
}


$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
//Vérifier qu'un hébergement ne porte pas déjà ce nom
$req = $bdd->prepare("SELECT NOHEB FROM hebergement WHERE NOMHEB = :nomheb");
$req -> bindValue(":nomheb", $nomHeb, PDO::PARAM_STR);
$req -> execute();
if($donnees = $req -> fetch())
{
	$erreur .= "<li>Erreur nom: Un hébergement porte déjà ce nom, deux hébergements ne peuvent pas porter la même appellation.</li>";
	$saisiEstCorrecte = false;
}

if($saisiEstCorrecte == true)
{
	$req2 = $bdd->prepare("INSERT INTO hebergement(CODETYPEHEB, NOMHEB, NBPLACEHEB, SURFACEHEB, INTERNET, ANNEEHEB, SECTEURHEB, ORIENTATIONHEB, ETATHEB, DESCRIHEB, PHOTOHEB, TARIFSEMHEB) VALUES (:codeTypeHeb, :nomHeb, :nbPlaceHeb, :surfaceHeb, :internet, :anneeHeb, :secteurHeb, :orientation, :etatHeb, :descriHeb, :photoHeb, :tarifSemHeb)");
	if($req2->execute(ARRAY("codeTypeHeb" => $codeTypeHeb, 
						"nomHeb" => $nomHeb,
						"nbPlaceHeb" => $nbPlace,
						"surfaceHeb" => $surface,
						"internet" => $internet,
						"anneeHeb" => $anneeConstruction,
						"secteurHeb" => $secteur,
						"orientation" => $orientation,
						"etatHeb" => $etatHeb,
						"descriHeb" => $descriHeb,
						"photoHeb" => $photo,
						"tarifSemHeb" => $tarifSemHeb)))
	{
		echo "L'hébergement a été crée <br>";
		echo "<a href='rechercheHebergement.php'>Retour</a> ou <a href='creerHebergement.php'>Créer à nouveau</a>";
	}
}
else
{
	echo "<h3>Erreurs:</h3>";
	echo "<ul>".$erreur."</ul>";
	echo "<a href=creerHebergement.php>Retour à la page précédente.</a>";
}

?>

<!-- $saisiEstCorrecte = true;
//Si la valeur du tarif est décimale et qu'elle comporte une virgule, remplacer celle-ci par un point.
$regexMatchTarif = "#^[0-9]+[.,]?[0-9]*$#";
$regexReplaceTarif = "#,#";

if(preg_match($regexMatchTarif, $tarifSemHeb))
{
	$tarifSemHeb = preg_replace($regexReplaceTarif, ".", $tarifSemHeb);
}
else
{
	$erreur .= "Erreur format: Le format du tarif doit être sous forme numérique décimale ou entière, sans le symbole €. (exemple: 152.13)</br>";
	$saisiEstCorrecte = false;
}


$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
//Vérifier qu'un hébergement ne porte pas déjà ce nom
$req = $bdd->prepare("SELECT NOHEB FROM hebergement WHERE NOMHEB = :nomheb");
$req -> bindValue(":nomheb", $nomHeb, PDO::PARAM_STR);
$req -> execute();
if($donnees = $req -> fetch())
{
	$erreur .= "Erreur nom: Un hébergement porte déjà ce nom, deux hébergements ne peuvent pas porter la même appellation.";
	$saisiEstCorrecte = false;
}

if($saisiEstCorrecte == true)
{
	$req2 = $bdd->prepare("INSERT INTO hebergement(CODETYPEHEB, NOMHEB, NBPLACEHEB, SURFACEHEB, INTERNET, ANNEEHEB, SECTEURHEB, ORIENTATIONHEB, ETATHEB, DESCRIHEB, PHOTOHEB, TARIFSEMHEB) VALUES (:codeTypeHeb, :nomHeb, :nbPlaceHeb, :surfaceHeb, :internet, :anneeHeb, :secteurHeb, :orientation, :etatHeb, :descriHeb, :photoHeb, :tarifSemHeb)");
	if($req2->execute(ARRAY("codeTypeHeb" => $codeTypeHeb, 
						"nomHeb" => $nomHeb,
						"nbPlaceHeb" => $nbPlace,
						"surfaceHeb" => $surface,
						"internet" => $internet,
						"anneeHeb" => $anneeConstruction,
						"secteurHeb" => $secteur,
						"orientation" => $orientation,
						"etatHeb" => $etatHeb,
						"descriHeb" => $descriHeb,
						"photoHeb" => $photo,
						"tarifSemHeb" => $tarifSemHeb)))
	{
		echo "L'hébergement a été crée";
		echo "<a href='rechercheHebergement.php'>Retour</a>";
	}
}
else
{
	echo $erreur."</br>";
	echo "<a href=creerHebergement.php>Retour à la page précédente.</a>";
}
 -->