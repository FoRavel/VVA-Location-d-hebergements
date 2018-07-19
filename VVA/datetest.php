<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post">
	<select name="month">
		<option value="may">May</option>
		<option value="june">June</option>
	</select>
	<input type="submit" name="submit">
</form>
<?php

	$actualMonth = new DateTime("now");
	$a = $actualMonth->format("F");
	$premierMercredi = new DateTime("first Saturday of june");
	$dernierJourMois = new DateTime("first day of july");
	$interval = new DateInterval("P7D");
	$period = new DatePeriod($premierMercredi, $interval, $dernierJourMois);

	foreach($period as $day)
	{
		$ole = $day->format("Y-m-d");	
		$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");
		$req = $bdd->exec("INSERT INTO semaine(DATEDEBSEM, DATEDEBSEM) value($ole, '2018-12-10')");
				
	}
	/*
	if(isset($_POST["submit"]))
	{

		$selectedMonth = $_POST["month"];
		$nextMonthValue = $selectedMonth->format("m");
		$nextMonth = new DateTime("2018-$nextMonthValue-01");
		
		$premierMercredi = new DateTime("first Saturday of $selectedMonth");
		$dernierJourMois = new DateTime("first day of next month");
		$interval = new DateInterval("P7D");
		$period = new DatePeriod($premierMercredi, $interval, $dernierJourMois);

		foreach($period as $day)
		{
			echo $day->format("Y-m-d") . "<br>";
		}
		*/
		
	
?>

