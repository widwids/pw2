<header class="header" data-component="Header">
	<nav class="navbar">
		<span><img class="logo" src="assets/logo_icones/YVMA_logo_gold.svg"></span>
        <div class="brand"><a href="index.php" class="brand_text">YVMA</a></div>

		<div class="menu">
			<ul class="liens">
				<li><a href="index.php?Voiture&action=listeVoituresNonAdmin">Salle de montre</a></li>
				<li><a href="index.php#promo">Promotions</a></li>
				<li><a href="index.php?Voiture&action=aPropos">À propos</a></li>
				<li><a href="index.php#contact">Contact</a></li>
				<li><a href="index.php?Utilisateur&action=deconnexion">Déconnexion</a></li>
				<!-- <li><a href="index.php?Utilisateur&action=langue">EN/FR</a></li> -->
			</ul>
		</div>		
		
		<div class="cart" data-js-cart>
<?php if(!isset($_SESSION["utilisateur"])) { ?>
			<span class="connexion"><a href="index.php?Utilisateur&action=connexion">Connexion</a></span>
<?php } ?>
            <span class="nbItems" data-js-nbItems>0</span>
            <a href="index.php?commande&action=afficheCommande&idCommande=1"><img class="handshake_icon" src="assets/logo_icones/handshake.png" data-js-cart></img></a>
        </div>

		


		<div class="ham_icon" data-js-hamburger>
			<div></div>
			<div></div>
			<div></div>
		</div>

		<div class="hamburger slideMenu">
			<ul class="liens_ham">
<?php if(isset($_SESSION["utilisateur"])) { ?>
				<li><a href="index.php?Utilisateur&action=compte">Compte utilisateur</a></li>
<?php } ?>
				<li><a href="index.php?Voiture&action=listeVoituresNonAdmin">Salle de montre</a></li>
				<li><a href="#">Promotions</a></li>
				<li><a href="index.php?Voiture&action=aPropos">À propos</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="#">EN/FR</a></li>
<?php if(isset($_SESSION["utilisateur"])) { ?>
				<li><a href="index.php?Utilisateur&action=deconnexion">Déconnexion</a></li>
<?php } ?>
			</ul>
		</div>
    </nav>
</header>