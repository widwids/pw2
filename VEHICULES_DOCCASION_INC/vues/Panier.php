<section class="panier" data-component="Panier">
    <div data-js-panier>
        <h1>Panier (en construction)</h1>
        <div data-js-articles></div><br>
        <p>Sous-total : <span data-js-sousTotal></span>$</p><br>
    </div>
    <button data-js-caisse>Passez à la caisse</button>

<?php if(isset($_SESSION["utilisateur"])) { ?>
    
    <div style="display:none" data-js-commande>
        <p>Taxes</p>

<?php foreach ($data["taxes"] as $taxe) { ?>
        <p><?= $taxe["nomTaxeFR"] ?> <span data-js-taux><?= $taxe["taux"] ?></span>%</p>
<?php } ?>
        <h3>Total: <span data-js-total></span>$</h3><br>
        <button data-js-button>Commander</button>
    </div>
<?php } ?>
    <div style="display:none" data-js-connexion>
        <form method="post">
            <label for="pseudonyme">Nom d'utilisateur</label>
            <input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required data-js-pseudonyme><br>
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" placeholder="Mot de passe" required data-js-motDePasse><br>
            <input type="hidden" name="action" value="authentification">
            <br>
            <input type="submit" value="Se connecter" data-js-btnConnexion>
        </form>
    </div>
</section>