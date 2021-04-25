<h2>Utilisateurs</h2>
<ul>
<?php $utilisateurs = $data["utilisateurs"];

foreach ($utilisateurs as $utilisateur) {
?>
    <li><?= "{$utilisateur -> getPseudonyme()} : {$utilisateur -> getPrenom()} {$utilisateur -> getNom()}" ?></li>
<?php 
}
?>
</ul><br>

<h2>Villes</h2>
<ul>
<?php
foreach($data["villes"] as $ville) {
?>
    <li><?= $ville['nomVilleFR'] ?></li>
<?php
}
?>
</ul><br>

<h2>Provinces</h2>
<ul>
<?php
foreach($data["provinces"] as $province) {
?>
    <li><?= $province['nomProvinceFR'] ?></li>
<?php
}
?>
</ul><br>

<h2>Pays</h2>
<ul>
<?php
foreach($data["pays"] as $pays) {
?>
    <li><?= $pays['nomPaysFR'] ?></li>
<?php
}
?>
</ul><br>

<h2>Taxes</h2>
<ul>
<?php
foreach($data["taxes"] as $taxe) {
?>
    <li><?= $taxe['nomTaxeFR'] ?></li>
<?php
}
?>
</ul><br>

<h2>Privileges</h2>
<ul>
<?php
foreach($data["privileges"] as $privilege) {
?>
    <li><?= $privilege['nomPrivilegeFR'] ?></li>
<?php
}
?>
</ul>