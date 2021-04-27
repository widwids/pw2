
<section class="yu-section">

    <div class="yu-table-groupeMP">
        <a class="yu-btn-ajouter" href="index.php?Utilisateur&action=FormulaireAjouterGroupeMP">Ajouter groupe motopropulseur</a>
    </div>

    <table class="yu-table yu-table-groupeMP">
               
        <tr>
            <th>Nom motopropulseur</th>
            <th>Visibilité</th>
            <th>Actions</th>
        </tr>

    <?php foreach ($data as $groupeMP) { ?>

        <tr>
            <td><?= $groupeMP["nomMotopro"]?></td>
            <td><?= ($groupeMP["visibilite"] ==1) ? "OUI" : "NON" ?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>
    
    <?php }?>

    </table>

</section>