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
			<p><?php echo $voiture["nomMarque"]; ?></p> 
			<p><?php echo $voiture["nomModele"]; ?> <?php echo $voiture["anneeId"]; ?></p> 
			<p><?php echo $voiture["prixAchat"]; ?> $</p>
		</div> 
	</div> 
<?php
	}
?>

</section>