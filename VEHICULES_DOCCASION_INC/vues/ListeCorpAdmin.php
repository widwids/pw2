
<section class="yu-section">

    <div class="yu-table-corp">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterCorp">Ajouter corp</a>
    </div>

    <table class="yu-table yu-table-corp">
               
        <tr>
            <th>Nom du corp en français</th>
            <th>Nom du corp en anglais</th>
            <th>Visibilité</th>
            <th>Actions</th>
        </tr>

    <?php foreach ($data as $corp) { ?>

        <tr>
            <td><?= $corp["nomCorpsFR"]?></td>
            <td><?= $corp["nomCorpsEN"]?></td>
            <td><?= ($corp["visibilite"] ==1) ? "OUI" : "NON" ?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

    <?php }?>

    </table>

</section>