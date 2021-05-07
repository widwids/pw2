<header class="header" data-component="Header">
	<nav class="navbar">
		<span><img class="logo" src="assets/logo_icones/YVMA_logo_gold.svg"></span>
        <div class="brand"><a href="index.php" class="brand_text">YVMA</a></div>

		<div class="menu">
			<ul class="liens">
				<li><a href="index.php?Voiture&action=listeVoituresNonAdmin">Salle de montre</a></li>
				<li><a href="#">Promotions</a></li>
				<li><a href="index.php?Voiture&action=aPropos">À propos</a></li>
				<?php if(isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {?>
					<div class="dropdown">
						<a href="#" class="gestion" data-js-gestion>Gestion</a>
						<div class="dropdown-content hide" data-js-dropdown>
							<div class="content">
								<span>Gestion Voiture</span>
								<a href="index.php?Voiture&action=ListeVehicule">Liste de véhicules</a>
								<a href="index.php?Voiture&action=ListeGroupeMP">Motopropulseurs</a>
								<a href="index.php?Voiture&action=ListeCorps">Types de véhicules</a>
								<a href="index.php?Voiture&action=ListeCarburant">Carburants</a>
								<a href="index.php?Voiture&action=ListeModele">Marques/Modèles</a>
								<a href="index.php?Voiture&action=ListeTransmission">Transmission</a>
							</div>
							<div class="vertical_line"></div>
							<div class="content">
								<span>Gestion Utilisateur</span>
								<a href="#">Ajouter un utilisateur</a>
								<a href="#">Liste d'utilisateurs</a>
								<a href="#">Villes</a>
								<a href="#">Provinces/Pays</a>
								<a href="#">Taxes</a>
								<a href="#">Commandes</a>
							</div>
						</div>
						<?php } ?>
					</ul>
				</div>
		
		
		<div class="cart" data-js-cart>
		<?php if(!isset($_SESSION["utilisateur"])) {?>
			<span class="connexion"><a href="index.php?Utilisateur&action=connexion">Connexion</a></span>
			<?php } else if(isset($_SESSION["utilisateur"])){ ?>
			<div class="container_connexion">
				<span class="connexion" data-js-menu-user><a href="index.php?Utilisateur&action=compte">Votre&nbsp;Compte</a></span>
				<span><a class="deconnexion" href="index.php?Utilisateur&action=deconnexion">Déconnexion</a></span>
			</div>
		</div>
<?php } ?>
            <a href="index.php?commande&action=afficheCommande&idCommande=1"><img class="handshake_icon" src="assets/logo_icones/handshake.png" data-js-cart></img></a>
        </div>

		<div class="ham_icon" data-js-hamburger>
			<div></div>
			<div></div>
			<div></div>
		</div>

		<div class="hamburger">
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