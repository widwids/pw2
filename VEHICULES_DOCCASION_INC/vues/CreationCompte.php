<h1>Création d'un compte</h1>
<form method="post">
    <label for="prenom">Prénom</label> 
	<input type="text" name="prenom" required><br>
    <label for="nom">Nom</label>
	<input type="text" name="nom" required><br>
    <label for="dateNaissance">Date de naissance</label>
	<input type="date" name="dateNaissance" required><br>
    <label for="adresse">Adresse</label> 
	<input type="text" name="adresse" required><br>
    <label for="codePostal">Code postal</label> 
	<input type="text" name="codePostal" required><br>
    <label for="villeId">Ville</label> 
    <select id="villeId" name="villeId">
        <option value="1">Montréal</option>
        <option value="2">Laval</option>
        <option value="3">Longueuil</option>
        <option value="4">Toronto</option>
    </select>
    <br>
    <label for="telephone">Téléphone</label> 
	<input type="tel" name="telephone" required><br>
    <label for="cellulaire">Cellulaire </label>
	<input type="tel" name="cellulaire"><br>
    <label for="courriel">Courriel </label>
	<input type="email" name="courriel"><br>
    <label for="pseudonyme">Pseudonyme</label> 
	<input type="text" name="pseudonyme" required><br>
    <label for="motDePasse">Mot de passe</label>
	<input type="password" name="motDePasse" required><br>
    <input type="hidden" name="action" value="insereUtilisateur"/>
	<br>
    <input class="submit" type="submit" value="Enregistrer"/>
</form>
<?php
    if($data["erreurs"] != "")
?>
<p><?= $data["erreurs"] ?></p>

<br>
<a href="index.php?Utilisateur&action=connexion">Déjà un compte? Connectez-vous ></a>