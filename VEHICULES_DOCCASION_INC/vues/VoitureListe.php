<h1>SALLE DE MONTRE</h1>

<div class="filtre" data-component="Filtre">
	<select data-js-filtre="nomMarque" class="select">
		<option selected disabled hidden>Choisir par marque</option>
<?php foreach ($data["marques"] as $marque) { ?>
		<option value="<?= $marque["nomMarque"] ?>"><?= $marque["nomMarque"] ?></option>
<?php } ?>
	</select>

	<select data-js-filtre="nomModele" class="select">
		<option selected disabled hidden>Choisir par modèle</option>
<?php foreach ($data["modeles"] as $modele) { ?>
		<option value="<?= $modele["nomModele"] ?>"><?= $modele["nomModele"] ?></option>
<?php } ?>
	</select>

	<select data-js-filtre="anneeId" class="select">
		<option selected disabled hidden>Choisir par année</option>
<?php foreach ($data["annees"] as $annee) { ?>
		<option value="<?= $annee["annee"] ?>"><?= $annee["annee"] ?></option>
<?php } ?>
	</select>

	<select data-js-filtre="prixAchat" class="select">
		<option selected disabled hidden>Trier par prix</option>
		<option value="prixAchat ASC">Prix croissant</option>
		<option value="prixAchat DESC">Prix décroissant</option>
	</select>
</div>

<section class="product-list" data-js-voitures>
<?php
	foreach ($data['voitures'] as $voiture) {
?>
	<a href="index.php?Voiture&action=detailVoiture&noSerie=<?= $voiture['noSerie']?>">
		<div class="product-card" data-js-inventaire="" data-js-produits="">
			<div class="product-image">
				<img src="assets/images/<?php echo $voiture["nomPhoto"]; ?>.jpg" class="product-list__image">
			</div>

			<div class=product-info>
				<!-- <p><?=$voiture["noSerie"] ?></p>  -->
				<h3><?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"]; ?> <?= $voiture["anneeId"]; ?></h3> 

				<small>
				<li><?= $voiture["nomCorpsFR"] ?> </li>
                <li><?= $voiture["kilometrage"] ?> Km</li>
				<li>Carburant: <?= $voiture["typeCarburantFR"] ?></li>
                <li>Traction: <?= $voiture["nomMotopro"] ?></li>
                <li>Transmission: <?= $voiture["nomTransmissionFR"] ?></li>
                <li>No de série: <span data-js-noSerie><?= $voiture["noSerie"] ?></span></li>
                <li>Date d'arrivée: <?= $voiture["dateArrivee"] ?></li></small>
				
				<h2><?= number_format($voiture["prixAchat"] * 1.25, 2, ',', ' ') ?> $</h2>
			</div>
		</div>
	</a>
<?php
	}
?>

</section>