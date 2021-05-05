<!-- Slider main container -->
 <!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
<?php 
    foreach($data['photos'] as $photo){
        // var_dump($photo['nomPhoto']);
?>
    <div class="swiper-slide">
            <img src="assets/images/<?= $photo['nomPhoto'] ?>.jpg">
    </div>
    
<?php
    }
?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<?php foreach ($data["voiture"] as $voiture) { ?>

<div class="nomMarque">
    <h1><?= $voiture["nomMarque"] ?></h1>
    <h1><?= $voiture["nomModele"] ?></h1>
</div>

<div class="details_container" data-component="VoitureSolo">
    <h1 class="titreDetails">Détails</h1>
    <div class="details">
        <div>
            <ul>
                <li>Prix: <?= number_format($voiture["prixAchat"] * 1.10, 2, ',', ' ') ?>$</li>
                <li>Marque: <?= $voiture["nomMarque"] ?></li>
                <li>Modèle: <?= $voiture["nomModele"] ?></li>
                <li>Année: <?= $voiture["anneeId"] ?></li>
                <li>No de série: <span data-js-noSerie><?= $voiture["noSerie"] ?></span></li>
                <li>Kilométrage: <?= $voiture["kilometrage"] ?></li>
                <li>Carburant: <?= $voiture["typeCarburantFR"] ?></li>
                <li>Type de véhicule: <?= $voiture["nomCorpsFR"] ?></li>
                <li>Traction: <?= $voiture["nomMotopro"] ?></li>
                <li>Transmission: <?= $voiture["nomTransmissionFR"] ?></li>
                <li>Date d'arrivée: <?= $voiture["dateArrivee"] ?></li>
<?php }?>
            </ul>
        </div>
        <div class="description">
            <p><?= $voiture["descriptionFR"] ?></p>
        </div>
    </div>

    <div class="reservation">
        <button class="reserver" data-js-reserver>Réservez ce véhicule</button>
    </div>
</div>


