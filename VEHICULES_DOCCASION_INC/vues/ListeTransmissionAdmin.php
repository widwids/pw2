
<section class="yu-section">

    <div class="yu-table-transmission">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterTransmission">Ajouter transmission</a>
    </div>

    <table class="yu-table yu-table-transmission">
               
        <tr>
            <th>Nom du transmission en français</th>
            <th>Nom du transmission en anglais</th>
            <th>Visibilité</th>
            <th>Actions</th>
        </tr>

    <?php foreach ($data as $transmission) { ?>

        <tr>
            <td><?= $transmission["nomTransmissionFR"]?></td>
            <td><?= $transmission["nomTransmissionEN"]?></td>
            <td><?= ($transmission["visibilite"] ==1) ? "OUI" : "NON" ?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

    <?php }?>

    </table>

</section>