<?php $utilisateur = $data["utilisateur"] ?>

<h1>Utilisateur : <?= $utilisateur -> getPrenom() . " " . $utilisateur -> getNom() ?></h1>

<ul>
    <li>Date de naissance : <?= $utilisateur -> getDateNaissance() ?></li>
    <li>Adresse : <?= $utilisateur -> getAdresse() ?></li>
    <li>Code postal : <?= $utilisateur -> getCodePostal() ?></li>
    <li>Téléphone : <?= $utilisateur -> getTelephone() ?></li>
    <li>Cellulaire : <?= $utilisateur -> getCellulaire() ?></li>
    <li>Courriel : <?= $utilisateur -> getCourriel() ?></li>
    <li>Ville : </li>
    <li>Province : </li>
    <li>Pays : </li>
</ul>