<h1>SALLE DE MONTRE</h1>

<div class="filtre">
	<select data-js-btn-filtre-marque class="select">
		<option selected disabled hidden>Choisir par marque</option>
		<option value="saab">Saab</option>
		<option value="mercedes">Mercedes</option>
		<option value="audi">Audi</option>
	</select>

	<select data-js-btn-filtre-prix class="select">
		<option selected disabled hidden>Trier par prix</option>
		<option value="Trop cher">Trop cher</option>
		<option value="Vidange">Vidange</option>
	</select>
</div>

<section class="product-list" data-component="">
<?php
//var_dump($data);
	foreach ($data as $voiture) {
?>
	<div class="product-card" data-js-inventaire="" data-js-produits="">
		<div class="product-image">
	 		<img src="assets/images/<?php echo $voiture["nomPhoto"]; ?>.jpg" class="product-list__image">
		</div>
		<div class=product-info>
			<!-- <p><?php echo $voiture["noSerie"]; ?></p>  -->
			<p><?php echo $voiture["nomMarque"]; ?> <?php echo $voiture["nomModele"]; ?> <?php echo $voiture["anneeId"]; ?></p> 
			<p><?php echo $voiture["kilometrage"]; ?> Km</p> 
			<p>Date d'arrivée : <?php echo $voiture["dateArrivee"]; ?></p> 
			<p></p> 
			<h2><?php echo $voiture["prixAchat"]; ?> $</h2>
		</div> 
	</div> 
<?php
	}
?>

</section>