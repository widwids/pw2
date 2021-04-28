
<section class="yu-section">

    <div class="yu-table-modele">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterModele">Ajouter modèle</a>
    </div>

    <table class="yu-table yu-table-modele">
               
        <tr>
            <th>Nom du modèle</th>
            <th>Marque</th>
            <th>Visibilité</th>
            <th>Actions</th>
        </tr>

    <?php foreach ($data as $modele) { ?>

        <tr>
            <td><?= $modele["nomModele"]?></td>
            <td><?= $modele["nomMarque"]?></td>
            <td><?= ($modele["visibilite"] ==1) ? "OUI" : "NON" ?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

    <?php }?> 

    </table>

</section>