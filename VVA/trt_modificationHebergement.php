<!-- <!DOCTYPE HTML>
<html>
<head>

</head>
<body>
</body>
</html> -->
<?php

if(!ISSET($_POST["submit"]))
{
	header("location:modificationHebergement.php");
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
		header("location: modificationHebergement.php?erreur=$erreur&noHeb=$_GET[noHeb]");
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
	$erreur .= "Erreur format: Le format du tarif doit être sous forme numérique décimale ou entière, sans le symbole €. (exemple: 152.13)</br>";
	$saisiEstCorrecte = false;
}


$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root","");
//Vérifier qu'un hébergement ne porte pas déjà ce nom
$req = $bdd->prepare("SELECT NOHEB, NOMHEB FROM hebergement WHERE NOMHEB = :nomheb");
$req -> bindValue(":nomheb", $nomHeb, PDO::PARAM_STR);
$req -> execute();
if($donnees = $req -> fetch())
{
	//Si le nom trouvé en base de donnée est identique à celui qui était initialement assigné alors accepté la saisie.
	if($donnees["NOMHEB"] == $nomHeb)
	{
		$saisiEstCorrecte = true;
	}
	else
	{
		$erreur .= "Erreur nom: Un hébergement porte déjà ce nom, deux hébergements ne peuvent pas porter la même appellation.";
		$saisiEstCorrecte = false;
	}
}

if($saisiEstCorrecte == true)
{
	$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
	$req = $bdd->prepare("UPDATE hebergement SET CODETYPEHEB = :codeTypeHeb, NOMHEB = :nomHeb, NBPLACEHEB = :nbPlaceHeb, SURFACEHEB = :surfaceHeb, INTERNET = :internet, ANNEEHEB = :anneeHeb, SECTEURHEB = :secteurHeb, ORIENTATIONHEB = :orientation, ETATHEB = :etatHeb, DESCRIHEB = :descriHeb, PHOTOHEB = :photoHeb, TARIFSEMHEB = :tarifSemHeb WHERE NOHEB = :noHeb");
	if($req->execute(ARRAY(
		"codeTypeHeb" => $codeTypeHeb, 
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
		"tarifSemHeb" => $tarifSemHeb,
		"noHeb" => $_GET["noHeb"])))
	{
		echo "Modification prise en compte.";
		echo "<a href=detailHebergement.php?noHeb=".$_GET['noHeb'].">Voir la modification</a>";
	}
	else
	{
		echo "La requête ne s'est pas exécutée.";	
	}
}
else
{
	echo $erreur;
}
?>