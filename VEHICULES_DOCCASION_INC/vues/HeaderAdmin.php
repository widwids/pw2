<?php include_once('Header.php')?>
<header class="header-admin" data-component="Header">
	<picture>
		<!-- <img src="./assets/images/YVMA_logo_gold.svg" alt="">
		<a href="#" class="brand_text">YVMA</a> -->
	</picture>
	<ul class="menu-principale">
		<li class="parent-menu-deroulant"><a href="#">Gestion de véhicule</a>
			<ul class="menu-deroulant">
				<li><a href="index.php?Voiture&action=ListeVehicule">Liste de véhicules</a></li>
				<li><a href="index.php?Voiture&action=ListeGroupeMP">Motopropulseurs</a></li>
				<li><a href="index.php?Voiture&action=ListeCorps">Types de véhicules</a></li>
				<li><a href="index.php?Voiture&action=ListeCarburant">Carburants</a></li>
				<li><a href="index.php?Voiture&action=ListeModele">Modèles</a></li>
				<li><a href="index.php?Voiture&action=ListeMarque">Marques</a></li>
				<li><a href="index.php?Voiture&action=ListeAnnee">Années</a></li>				
				<li><a href="index.php?Voiture&action=ListeTransmission">Transmission</a></li>
			</ul>
		</li>
		<li class="parent-menu-deroulant"><a href="#">Gestion d’utilisateur</a>
			<ul class="menu-deroulant">
				<li><a href="">Ajouter un utilisateur</a></li>
				<li><a href="">Liste d'utilisateurs</a></li>
				<li><a href="">Villes</a></li>
				<li><a href="">Provinces/Pays</a></li>
				<li><a href="">Taxes</a></li>
				<li><a href="">Commandes</a></li>
			</ul>
		</li>
		<!-- <li class="parent-menu-deroulant"><a href="#">John Doe(administrateur)</a>
			<ul class="menu-deroulant">
				<li><a href="">Mon compte</a></li>
				<li><a href="index.php?Utilisateur&action=deconnexion">Fermer la session</a></li>
			</ul>
		</li>
		<li><a href="#">FR</a></li> -->
	</ul>
</header>

<script>

	document.querySelector(".navbar").style = "border-bottom: none";


</script>