<?php

$DateEnCours = new DateTime("now");
		
$anneeEnCours = $DateEnCours->format("Y");
$anneeSuivante = $anneeEnCours+1;

$intervalle = new DateInterval("P1M");

$DernierMoisDeLAnnee = new DateTime("$anneeEnCours/12/31");
$periodeAnneeActuelle = new DatePeriod($DateEnCours, $intervalle, $DernierMoisDeLAnnee);

$dernierMoisAnneeSuivante = new DateTime($anneeSuivante."/12/31");
$premierMoisAnneeSuivante = new DateTime($anneeSuivante."/01/01");
$periodeAnneeSuivante = new DatePeriod($premierMoisAnneeSuivante, $intervalle, $dernierMoisAnneeSuivante );
echo "<option value='' disabled>Mois</option>";
if(ISSET($_POST["annee"]) AND $_POST["annee"] == $anneeSuivante)
{
	foreach($periodeAnneeSuivante as $mois)
	{
		
		echo "<option value=".$mois->format('n').">".$mois->format("F")."</option>";
	}
}
else
{
	foreach($periodeAnneeActuelle as $mois)
	{

		echo "<option value=".$mois->format('n').">".$mois->format("F")."</option>";
	}
}

?>