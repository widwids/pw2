<section class="" data-component="">
<h1>Bonsfjijasf</h1>
<?php
	foreach ($data as $voiture) {
?>
	 <div class="" data-js-inventaire="" data-js-produits="">
		<img src="assets/images/<?php echo $voiture["photoAccueil"]; ?>.jpg" class="gallery__image">
        <p><?php echo $voiture["noSerie"]; ?></p> 
		<p><?php echo $voiture["dateArrivee"]; ?></p> 
		<p><?php echo $voiture["prixAchat"]; ?> $</p> 
	</div> 
<?php
	}
?>

</section>