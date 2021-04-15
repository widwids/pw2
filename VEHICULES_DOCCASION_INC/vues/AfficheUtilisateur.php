<?php $utilisateur = $data["utilisateur"] ?>

<h1>Utilisateur : <?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>

<ul>
    <li>Date de naissance : <?= $utilisateur -> getDateNaissance() ?></li>
    <li>Adresse : <?= $utilisateur -> getAdresse() ?></li>
    <li>Code postal : <?= $utilisateur -> getCodePostal() ?></li>
    <li>Ville : <?= $utilisateur -> getNomVille() ?></li>
    <li>Province : <?= $utilisateur -> getNomProvince() ?></li>
    <li>Pays : <?= $utilisateur -> getNomPays() ?></li>
    <li>Téléphone : <?= $utilisateur -> getTelephone() ?></li>
    <li>Cellulaire : <?= $utilisateur -> getCellulaire() ?></li>
    <li>Courriel : <?= $utilisateur -> getCourriel() ?></li>
    <li>Pseudonyme : <?= $utilisateur -> getPseudonyme() ?></li>
</ul>