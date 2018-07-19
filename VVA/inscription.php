<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8"/>
	</head>
	<body>
		<form method="post" action="trt_inscription.php">
		<label for="user">User:</label>
		<input type="text" name="user" id="user"/>
		
		<label for="motDePasse">Mot de passe:</label>
		<input type="password" name="motDePasse" id="motDePasse"/>

		<label for="confMotDePasse">Confirmer le mot de passe:</label>
		<input type="password" name="confMotDePasse" id="confMotDePasse"/>

		<label for="nomCompte">Nom:</label>
		<input type="text" name="nom" id="nom"/>
		
		<label for="prenomCompte">Prénom:</label>
		<input type="text" name="prenom" id="prenom"/>

		<label for="adresseMail">Adresse Email:</label>
		<input type="text" name="adresseMail" id="adresseMail"/>
		
		<label for="numeroTelephonePort">numero de téléphone portable:</label>
		<input type="number" name="numeroTelephonePort" id="numeroTelephonePort"/>

		<label for="numeroTelephone">numero Téléphone:</label>
		<input type="number" name="numeroTelephone" id="numeroTelephone"/>
		<input type="submit" name="submit" id="submit"/>
		</form>
	</body>
</html>
