<?php
if(ISSET($_POST["submit"]) AND !EMPTY($_POST["semaine"]) OR !EMPTY($_GET["semaine"]))
{
	if(ISSET($_POST["submit"]) AND !EMPTY($_POST["semaine"]))
	{
		$nombreDeReservation = 0;

		$bdd = new PDo("mysql:host=localhost;dbname=vva;charset=utf8","root", "");
		$req = $bdd->prepare("SELECT r.NOHEB, r.DATEDEBSEM, r.USER, e.NOMETATRESA, h.NOMHEB FROM resa r, hebergement h, etat_resa e WHERE r.DATEDEBSEM = ? AND r.CODEETATRESA = e.CODEETATRESA AND r.NOHEB = h.NOHEB");
		$req->execute(ARRAY($_POST["semaine"]));
	}
	elseif(!EMPTY($_GET["semaine"]))
	{
		$nombreDeReservation = 0;

		$bdd = new PDo("mysql:host=localhost;dbname=vva;charset=utf8","root", "");
		$req = $bdd->prepare("SELECT r.NOHEB, r.DATEDEBSEM, r.USER, e.NOMETATRESA, h.NOMHEB FROM resa r, hebergement h, etat_resa e WHERE r.DATEDEBSEM = ? AND r.CODEETATRESA = e.CODEETATRESA AND r.NOHEB = h.NOHEB");
		$req->execute(ARRAY($_GET["semaine"]));
	}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h5>Résultat(s) de la recherche</h5>
			</div>
			<div class="card-body">
				<table class="table">
				<tr>
					<td>Hébergement</td>
					<td>Date</td>
					<td>User</td>
					<td>Etat</td>
					<td>Option</td>
				</tr>
		<?php
				while($donnees = $req->fetch())
				{	
					$nombreDeReservation++;
					if(ISSET($_GET["noHeb"]) AND $donnees["NOHEB"] == $_GET["noHeb"] AND $donnees["DATEDEBSEM"] == $_GET["semaine"])
					{
					?>
						<tr id="consulteDernierement">		
							<td><a href=detailHebergement.php?noHeb=<?php echo $donnees["NOHEB"];?>><?php echo $donnees["NOMHEB"];?></a></td>
							<td><?php echo $donnees["DATEDEBSEM"];?></td>
							<td><?php echo $donnees["USER"];?></td>
							<td><?php echo $donnees["NOMETATRESA"];?></td>
							<td><a href='detailReservation.php?noHeb=<?php echo $donnees['NOHEB'];?>&dateDebSem=<?php echo $donnees['DATEDEBSEM'];?>&nomEtatResa=<?php echo $donnees['NOMETATRESA'];?>'>Consulter pour modifier</a></td>
						</tr>
					<?php
					}
					else
					{
		?>			
					<tr>		
						<td><a href=detailHebergement.php?noHeb=<?php echo $donnees["NOHEB"];?>><?php echo $donnees["NOMHEB"];?></a></td>
						<td><?php echo $donnees["DATEDEBSEM"];?></td>
						<td><?php echo $donnees["USER"];?></td>
						<td><?php echo $donnees["NOMETATRESA"];?></td>
						<td><a href='detailReservation.php?noHeb=<?php echo $donnees['NOHEB'];?>&dateDebSem=<?php echo $donnees['DATEDEBSEM'];?>&nomEtatResa=<?php echo $donnees['NOMETATRESA'];?>'>Consulter pour modifier</a></td>
					</tr>
		<?php			
					}
				}
		?>
				</table>
		<?php
				if($nombreDeReservation == 0)
				{
		?>			
					<p>Il n'y a aucune réservation enregistrée pour la semaine du: <?php echo $_POST["semaine"];?></p>
		<?php			
				}
		}
		?>
			</div>
		</div>
	</div>
</div>
