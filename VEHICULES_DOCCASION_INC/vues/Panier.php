<section data-component="Panier">
    <div data-js-panier>
        <h1>Panier (en construction)</h1>
        <div data-js-articles></div><br>
        <p>Sous-total : <span data-js-sousTotal></span>$</p><br>
    </div>
<?php if(isset($_SESSION["utilisateur"])) { ?>
    
    <div data-js-commande>
        <p>Taxes</p>

<?php foreach ($data["taxes"] as $taxe) { ?>
        <p><?= $taxe["nomTaxeFR"] ?> <span data-js-taux><?= $taxe["taux"] ?></span></p>
<?php } ?>
        <h3>Total: <span data-js-total></span>$</h3><br>
        <button data-js-button>Commander</button>
    </div>
<?php } ?>
</section>