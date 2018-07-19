

<header class="page-header">
<h1>Village Vacances Alpes <small>- Location d'hébergements</small></h1>	
</header>
<!-- <nav class="navbar navbar-default"> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="collapse navbar-collapse" id="navbarNav">
	<ul class="nav navbar-nav">
	<li class="nav-item"><a class='nav-link' href="rechercheHebergement.php">Rechercher hébergement</a></li>
	<?php 
	if(!ISSET($_SESSION["user"]))
	{
		echo "<li class='nav-item'><a class='nav-link' href='connexion.php'>Se connecter</a></li>";
	}
	else
	{
		echo "<li class='nav-item'><a class='nav-link' href='deconnexion.php'>Se déconnecter</a></li>";
	}
	if(ISSET($_SESSION["typeUtil"]) AND $_SESSION["typeUtil"] == "loc")		
	{ 
		echo "<li class='nav-item'><a class='nav-link' href='creerHebergement.php'>Enregistrer nouvel hébergement</a></li>";
		echo "<li class='nav-item'><a class='nav-link' href='rechercheReservation.php'>Gestion des réservations</a></li>";
	}
	?>
	</ul>
</div>

</nav>
