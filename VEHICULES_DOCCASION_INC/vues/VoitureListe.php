<h1>SALLE DE MONTRE</h1>

<div class="filtre">
	<select data-js-btn-filtre-marque class="select">
		<option selected disabled hidden>Choisir par marque</option>
<?php foreach ($data["marques"] as $marque) { ?>
		<option value="<?= $marque["nomMarque"] ?>"><?= $marque["nomMarque"] ?></option>
<?php } ?>
	</select>

	<select data-js-btn-filtre-marque class="select">
		<option selected disabled hidden>Choisir par modèle</option>
<?php foreach ($data["modeles"] as $modele) { ?>
		<option value="<?= $modele["nomModele"] ?>"><?= $modele["nomModele"] ?></option>
<?php } ?>
	</select>

	<select data-js-btn-filtre-marque class="select">
		<option selected disabled hidden>Choisir par année</option>
<?php foreach ($data["annees"] as $annee) { ?>
		<option value="<?= $annee["annee"] ?>"><?= $annee["annee"] ?></option>
<?php } ?>
	</select>

	<select data-js-btn-filtre-prix class="select">
		<option selected disabled hidden>Trier par prix</option>
<?php foreach ($data["voitures"] as $voiture) { ?>
		<option value="<?= number_format($voiture["prixAchat"] * 1.10, 2, ',', ' ') ?>">
			<?= number_format($voiture["prixAchat"] * 1.10, 2, ',', ' ') ?>
		</option>
<?php } ?>
	</select>
</div>

<section class="product-list" data-component="">
<?php
//var_dump($data);
	foreach ($data as $voiture) {
?>
	<a href="index.php?Voiture&action=detailVoiture&noSerie=<?= $voiture['noSerie']?>">
		<div class="product-card" data-js-inventaire="" data-js-produits="">
			<div class="product-image">
				<img src="assets/images/<?php echo $voiture["nomPhoto"]; ?>.jpg" class="product-list__image">
			</div>
			<div class=product-info>
				<!-- <p><?=$voiture["noSerie"] ?></p>  -->
				<p><?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"]; ?> <?= $voiture["anneeId"]; ?></p> 
				<p><?= $voiture["kilometrage"]; ?> Km</p> 
				<p>Date d'arrivée : <?= $voiture["dateArrivee"] ?></p> 
				<p></p> 
				<h2><?= number_format($voiture["prixAchat"] * 1.10, 2, ',', ' ') ?> $</h2>
			</div> 
		</div>
	</a>
<?php
	}
?>

</section>