<h1>Titre!!</h1>
<h1>Titre!!</h1>
<section class="product-list" data-component="">
<?php
	foreach ($data as $voiture) {
?>
	 <div class=".product-list__image-wrapper" data-js-inventaire="" data-js-produits="">
		<img src="assets/images/<?php echo $voiture["photoAccueil"]; ?>.jpg" class="product-list__image">
        <!-- <p><?php echo $voiture["noSerie"]; ?></p>  -->
		<p><?php echo $voiture["nomMarque"]; ?></p> 
		<p><?php echo $voiture["nomModele"]; ?> <?php echo $voiture["anneeId"]; ?></p> 
		<p><?php echo $voiture["prixAchat"]; ?> $</p> 
	</div> 
<?php
	}
?>

</section>