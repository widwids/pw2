<h1>Nouvel uttilisateur</h1>
<section class="creationCompteWrapper">
    <form method="post" class="creationCompte">
        <label for="prenom">Prénom</label> <br>
        <input type="text" name="prenom" placeholder="Prénom" required><br>
        <label for="nom">Nom</label><br>
        <input type="text" name="nom" placeholder="Nom" required><br>
        <label for="dateNaissance">Date de naissance</label><br>
        <input type="date" name="dateNaissance" placeholder="YYYY-MM-DD" required><br>
        <label for="adresse">Adresse</label> <br>
        <input type="text" name="adresse" placeholder="123 Votre Rue" required><br>
        <label for="codePostal">Code postal</label> <br>
        <input type="text" name="codePostal" placeholder="XXX XXX" required><br>
        <label for="telephone">Téléphone</label> <br>
        <input type="tel" name="telephone" placeholder="XXX-XXX-XXXX" required><br>
        <label for="cellulaire">Cellulaire </label><br>
        <input type="tel" name="cellulaire"placeholder="XXX-XXX-XXXX" ><br>
        <label for="courriel">Courriel </label><br>
        <input type="email" name="courriel"placeholder="xyz@email.xyz" required><br>
        <label for="pseudonyme">Pseudonyme</label> <br>
        <input type="text" name="pseudonyme" placeholder="Identifiant" required><br>
        <label for="motDePasse">Mot de passe</label><br>
        <input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
        <label for="villeId">Ville</label> <br>
        <select id="villeId" name="villeId">
<?php foreach ($data["villes"] as $ville) { ?>
                <option value="<?= $ville["idVille"] ?>"><?= $ville["nomVilleFR"] ?></option>
<?php } ?>
        </select>
        <br>
        <input type="hidden" name="action" value="insereUtilisateur"/>
        <br>
        <button type="submit" value="Enregistrer">Enregistrer</button>
        <a href="index.php?Utilisateur&action=connexion">Connexion</a>
    </form>
</section>    
<?php
    if($data["erreurs"] != "")
?>
<p><?= $data["erreurs"] ?></p>

<br>
