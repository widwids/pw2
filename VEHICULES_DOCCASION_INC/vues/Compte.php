<?php $utilisateur = $data["utilisateur"] ?>

<h1>Utilisateur : <?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>

<ul>
    <li>Id : <?= $utilisateur -> getId() ?></li>
    <li>Date de naissance : <?= $utilisateur -> getDateNaissance() ?></li>
    <li>Adresse : <?= $utilisateur -> getAdresse() ?></li>
    <li>Code postal : <?= $utilisateur -> getCodePostal() ?></li>
    <li>Ville : <?= $utilisateur -> getNomVilleFR() ?></li>
    <li>Province : <?= $utilisateur -> getNomProvinceFR() ?></li>
    <li>Pays : <?= $utilisateur -> getNomPaysFR() ?></li>
    <li>Téléphone : <?= $utilisateur -> getTelephone() ?></li>
    <li>Cellulaire : <?= $utilisateur -> getCellulaire() ?></li>
    <li>Courriel : <?= $utilisateur -> getCourriel() ?></li>
    <li>Pseudonyme : <?= $utilisateur -> getPseudonyme() ?></li>
    <li>Privilège : <?= $utilisateur -> getNomPrivilegeFR() ?></li>
</ul>