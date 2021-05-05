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
        </div><?php   
        }?>
            
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

<div>
<div class="details_container" data-component="VoitureSolo">
    <div class="details">
        <div>
            <ul>
            <h1><?= number_format($voiture["prixAchat"] * 1.10, 2, ',', ' ') ?>$</h1><br><br><br><br>

            <b><li><?= $voiture["nomCorpsFR"] ?> </li>
                <li><?= $voiture["anneeId"] ?></li>
                <li><?= $voiture["kilometrage"] ?> Km</li></b><br><br><br>

                <small><li>Carburant: <?= $voiture["typeCarburantFR"] ?></li>
                <li>Traction: <?= $voiture["nomMotopro"] ?></li>
                <li>Transmission: <?= $voiture["nomTransmissionFR"] ?></li>
                <li>No de série: <span data-js-noSerie><?= $voiture["noSerie"] ?></span></li>
                <li>Date d'arrivée: <?= $voiture["dateArrivee"] ?></li></small><br><br>
                <?php }?>
            </ul>
        </div>
    </div>

    <div class="reservation">
        <button class="reserver" data-js-reserver>Réservez ce véhicule</button>
    </div>
</div>

<div class="description">
<h1><?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"] ?></h1>    <p><?= $voiture["descriptionFR"] ?></p>
</div>

</div>
