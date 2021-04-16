<h1>Création d'un compte</h1>
<form action="index.php?Utilisateur" method="post">
    <label for="pseudonyme">Pseudonyme</label> 
	<input type="text" name="pseudonyme" required><br>
    <label for="motDePasse">Mot de passe</label>
	<input type="password" name="motDePasse" required><br>
    <label for="dateNaissance">Date de naissance</label>
	<input type="date" name="dateNaissance" required><br>
    <label for="adresse">Adresse</label> 
	<input type="text" name="adresse" required><br>
    <label for="codePostal">Code postal</label> 
	<input type="text" name="codePostal" required><br>
    <label for="nomVille">Ville</label> 
	<input type="text" name="nomVille" required><br>
    <label for="nomProvince">Province</label> 
	<input type="text" name="nomProvince" required><br>
    <label for="nomPays">Pays</label> 
	<input type="text" name="nomPays" required><br>
    <label for="telephone">Téléphone</label> 
	<input type="text" name="telephone" required><br>
    <label for="cellulaire">Cellulaire </label> 
	<input type="text" name="cellulaire">
    <input type="hidden" name="action" value="insereUsager"/>
	<br>
    <input class="submit" type="submit" value="Enregistrer"/>
</form>
<?php
    if($data["erreurs"] != "")
?>
<p><?= $data["erreurs"] ?></p>