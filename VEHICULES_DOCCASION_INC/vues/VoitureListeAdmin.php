
<section class="yu-section">

    <div class="yu-table-voiture">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterVoiture">Ajouter un véhicule</a>
    </div>

    <table class="yu-table yu-table-voiture">
        
        <tr>
            <th>Photo</th>
            <th>№ Série</th>
            <th>Kilométrage</th>
            <th>Date Arrivée</th>
            <th>Prix Achat</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Année</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data as $voiture) { ?>

        <tr>
            <td class="yu-image"><img src="./assets/images/<?= $voiture["nomPhoto"] ?>.jpg" alt="car"></td>
            <td><?= $voiture["noSerie"]?></td>
            <td><?= $voiture["kilometrage"] ?></td>
            <td><?= $voiture["dateArrivee"]?></td>
            <td><?= $voiture["prixAchat"]?></td>
            <td><?= $voiture["nomMarque"]?></td>
            <td><?= $voiture["nomModele"]?></td>
            <td><?= $voiture["anneeId"]?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

            
        <?php }?>




    </table>

</section>