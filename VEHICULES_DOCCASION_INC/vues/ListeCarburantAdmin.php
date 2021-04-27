
<section class="yu-section">

    <div class="yu-table-carburant">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterCarburant">Ajouter carburant</a>
    </div>

    <table class="yu-table yu-table-carburant">
               
        <tr>
            <th>Type de carburant en français</th>
            <th>Type de carburant en anglais</th>
            <th>Visibilité</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data as $carburant) { ?>

            <tr>
                <td><?= $carburant["typeCarburantFR"]?></td>
                <td><?= $carburant["typeCarburantEN"]?></td>
                <td><?= ($carburant["visibilite"] ==1) ? "OUI" : "NON" ?></td>
                <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
            </tr>

        <?php }?>


    </table>

</section>