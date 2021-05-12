<?php $utilisateur = $data["utilisateur"] ?>
<div class="compteWrapper">        
    <img class="logoCompte" src="assets/logo_icones/YVMA_logo_gold.svg">    

    <div class="compte">

        <h1><?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>
        <h3>"<?= $utilisateur -> getPseudonyme() ?>"</h3>

        <div class="columns">
            <!-- <div>Id : <?= $utilisateur -> getId() ?></div> -->

            <div>Nom</div>
            <div>Prenom</div>
            <div>Identifiant</div>
            <div>Date de naissance</div>
            <div>Adresse</div>
            <div>Code postal</div>
            <div>Téléphone</div>
            <div>Cellulaire</div>
            <div>Courriel</div>
            <div>Ville</div>



            <input type="text" name = "nom" placeholder = "<?= $utilisateur -> getNom() ?>" required>
            <input type="text" name = "prenom" placeholder = "<?= $utilisateur -> getPrenom() ?>" required>
            <input type="text" name = "identifiant" placeholder = "<?= $utilisateur -> getPseudonyme() ?>" required>
            <input type="text" name = "dateNaissance" placeholder = "<?= $utilisateur -> getDateNaissance() ?>" required>
            <input type="text" name = "adresse" placeholder = "<?= $utilisateur -> getAdresse() ?>" required>
            <input type="text" name = "codePostal" placeholder = "<?= $utilisateur -> getCodePostal() ?>" required>
            <input type="text" name = "telephone" placeholder = "<?= $utilisateur -> getTelephone() ?>" required>
            <input type="text" name = "cellulaire" placeholder = "<?= $utilisateur -> getCellulaire() ?>">
            <input type="text" name = "courriel" placeholder = "<?= $utilisateur -> getCourriel() ?>" required>
            <select id="villeId" name="villeId">
                <?php foreach ($data["villes"] as $ville) { ?>
                    <option value="<?= $ville["idVille"] ?>"><?= $ville["nomVilleFR"] ?></option>
                <?php } ?>
            </select>

            <!--<div>Privilège : <?= $utilisateur -> getNomPrivilegeFR() ?></div>-->
        </div><br>

        <a href="">Enregistrer</a>

    </div>    
</div>

<!-- <h2>Changer le mot de passe</h2>

<form method="post">
		<label for="pseudonyme">Nom d'utilisateur :</label>
		<input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required><br>
		<label for="motDePasse">Nouveau mot de passe :</label>
		<input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
        <input type="hidden" name="action" value="modifierMotDePasse">
		<br>
		<input type="submit" value="Modifier"/>
</form>-->