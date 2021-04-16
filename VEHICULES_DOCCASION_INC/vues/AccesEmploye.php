<ul>

<?php $utilisateurs = $data["utilisateurs"];

foreach ($utilisateurs as $utilisateur) {
?>
    <li><?= $utilisateur -> getPseudonyme() ?></li>

<?php 
}
?>

</ul>