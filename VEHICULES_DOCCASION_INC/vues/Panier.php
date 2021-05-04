<section data-component="Panier">
    <div data-js-panier>
        <h1>Panier (en construction)</h1>
        <div data-js-articles></div><br>
        <p data-js-sousTotal></p><br>
        <button data-js-button>Commander</button>
    </div>
<?php if(isset($_SESSION["utilisateur"])) { ?>
    
    <div data-js-commande>
        <p>Taxes</p>

<?php foreach ($data["taxes"] as $taxe) { ?>
    <p><?= $taxe["nomTaxeFR"] ?> <?= $taxe["taux"] ?></p>
<?php } ?>
    </div>
<?php } ?>
</section>