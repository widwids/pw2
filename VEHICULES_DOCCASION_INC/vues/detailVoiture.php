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


<div class="details">
    <h1 class="titreDetails">Détails</h1>
    <ul>
        <li>Marque: Ferrari</li>
        <li>Modèle: La ferrari</li>
        <li>Année: 2013</li>
        <li>Couleur: Rouge</li>
        <li>Kilométrage: 18 850Km</li>
        <li>Carburant: Essence Standard</li>
        <li>Type de véhicule: Supercar</li>
        <li class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Aenean et dolor et libero egestas porttitor et maximus nisl. 
            Suspendisse vitae leo ut sapien dapibus dapibus a ut sem.
        </li>
    </ul>
</div>

<div class="nomMarque">
    <h1>Ferrari</h1>
    <h1>LA FERRARI</h1>
</div>

