<h1 class="centre">Ouverture de session</h1>
	<form action="index.php?Utilisateur" method="post">
		<label for="pseudonyme">Nom d'utilisateur (obligatoire) :</label>
		<input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required><br>
		<label for="motDePasse">Mot de passe (obligatoire) :</label>
		<input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
        <input type="hidden" name="action" value="authentification">
		<br>
		<input type="submit" value="Se connecter"/>
	</form>
	
<?php
	if($data["erreurs"] != "")
?>
	<p style="color:red"><?= $data["erreurs"] ?></p><br>
	
	<a href="index.php?Utilisateur&action=creationCompte">Nouvel utilisateur? Créez un compte ></a>
