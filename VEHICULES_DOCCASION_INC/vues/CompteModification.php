<?php $utilisateur = $data["utilisateur"];
?>
<div class="compteWrapper">        
    <img class="logoCompte" src="assets/logo_icones/YVMA_logo_gold.svg">    

    <div class="compte">

        <h1><?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>
        <h3>"<?= $utilisateur -> getPseudonyme() ?>"</h3>

        <form method="post">
            <input type="hidden" value="<?= $utilisateur -> getId() ?>">
            <div class="compteColumns">
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

                <input type="text" name = "nom" value = "<?= $utilisateur -> getNom() ?>" required>
                <input type="text" name = "prenom" value = "<?= $utilisateur -> getPrenom() ?>" required>
                <input type="text" name = "pseudonyme" value = "<?= $utilisateur -> getPseudonyme() ?>" required>
                <input type="text" name = "dateNaissance" value = "<?= $utilisateur -> getDateNaissance() ?>" required>
                <input type="text" name = "adresse" value = "<?= $utilisateur -> getAdresse() ?>" required>
                <input type="text" name = "codePostal" value = "<?= $utilisateur -> getCodePostal() ?>" required>
                <input type="text" name = "telephone" value = "<?= $utilisateur -> getTelephone() ?>" required>
                <input type="text" name = "cellulaire" value = "<?= $utilisateur -> getCellulaire() ?>">
                <input type="text" name = "courriel" value = "<?= $utilisateur -> getCourriel() ?>" required>
                <select id="villeId" name="villeId">
                <?php
                    foreach ($data["villes"] as $ville) { 
                        if($utilisateur -> getNomVilleFR() == $ville["nomVilleFR"]) {
                        ?>
                            <option style="color: black" value="<?= $ville["idVille"] ?>" selected><?= $ville["nomVilleFR"] ?></option>
                        <?php
                        } else {
                        ?>
                            <option style="color: black" value="<?= $ville["idVille"] ?>"><?= $ville["nomVilleFR"] ?></option>
                        <?php 
                        }
                    }
                ?>
                </select><br>
            </div><br>
            <input type="hidden" name="action" value="modifierUtilisateur"/><br>
            <button class="button" type="submit" value="Enregistrer">Enregistrer</button>
        </form>
    </div>    
</div>
