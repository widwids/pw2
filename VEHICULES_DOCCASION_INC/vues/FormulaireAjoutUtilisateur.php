<h1>Création d'un compte</h1>
<form action="index.php?Utilisateur" method="post">
    <label for="pseudonyme">Pseudonyme</label> 
	<input type="text" name="pseudonyme" required><br>
    <label for="motDePasse">Mot de passe</label>
	<input type="password" name="motDePasse" required><br>
    <input type="hidden" name="action" value="insereUsager"/>
	<br>
    <input class="submit" type="submit" value="Enregistrer"/>
</form>
<?php
    if($data["erreurs"] != "")
?>
<p><?= $data["erreurs"] ?></p>