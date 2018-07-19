<?php

$aujourdhui = new DateTime("today");
$intervalle = new DateInterval("P1M");
$anneesEnCours = $aujourdhui->format("Y");
$dernierMoisAnnee = new DateTime($anneesEnCours."/12/31");
$iteration = new DatePeriod($aujourdhui, $intervalle, $dernierMoisAnnee);

foreach($iteration as $mois)
{
	echo $mois->format("F");
}


$anneeSuivante = $anneesEnCours+1;
$dernierMoisAnneeSuivante = new DateTime($anneeSuivante."/12/31");
$premierMoisAnneeSuivante = new DateTime($anneeSuivante."/01/01");
$iteration = new DatePeriod($premierMoisAnneeSuivante, $intervalle, $dernierMoisAnneeSuivante );

foreach($iteration as $mois)
{
	echo $mois->format("F");
}

