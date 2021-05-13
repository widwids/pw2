<?php $utilisateur = $data["utilisateur"] ?>
<div class="compteWrapper">        
    <img class="logoCompte" src="assets/logo_icones/YVMA_logo_gold.svg">    

    <div class="compte">

        <h1><?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>
        <h3>"<?= $utilisateur -> getPseudonyme() ?>"</h3>

        <div class="compteColumns">
            <!-- <div>Id : <?= $utilisateur -> getId() ?></div> -->

            <div>Date de naissance</div>
            <div>Adresse</div>
            <div>Code postal</div>
            <div>Ville</div>
            <div>Province</div>
            <div>Pays</div>
            <div>Téléphone</div>
            <div>Cellulaire</div>
            <div>Courriel</div>

            <div><?= $utilisateur -> getDateNaissance() ?></div>
            <div><?= $utilisateur -> getAdresse() ?></div>
            <div><?= $utilisateur -> getCodePostal() ?></div>
            <div><?= $utilisateur -> getNomVilleFR() ?></div>
            <div><?= $utilisateur -> getNomProvinceFR() ?></div>
            <div><?= $utilisateur -> getNomPaysFR() ?></div>
            <div><?= $utilisateur -> getTelephone() ?></div>
            <div><?= $utilisateur -> getCellulaire() ?></div>
            <div><?= $utilisateur -> getCourriel() ?></div>

            <!--<div>Privilège : <?= $utilisateur -> getNomPrivilegeFR() ?></div>-->
        </div><br>

        <a href="index.php?Utilisateur&action=formulaireModifierUtilisateur"><button class="button" type="submit" value="Enregistrer">Modifier</button></a>

    </div>    
</div>
