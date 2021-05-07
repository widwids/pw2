<section class="panier" data-component="Panier">
    <div data-js-panier>
        <h1>Panier</h1>
        <div data-js-articles></div><br>
        <p class="sous-total">Sous-total : <span data-js-sousTotal></span>$</p><br>
    </div>
    <button class="caisse" data-js-caisse>Passez à la caisse</button>

    <div class="hidden" data-js-choix>
        <button data-js-connecter>Un compte? Connectez-vous.</button>
        <button data-js-creer>Nouvel utilisateur? Créez un compte.</button>
    </div>

    <div class="hidden" data-js-connexion>
        <form method="post">
            <h2>Connectez-vous</h2>
            <label for="pseudonyme">Nom d'utilisateur</label>
            <input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required data-js-pseudonyme><br>
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" placeholder="Mot de passe" required data-js-motDePasse><br>
            <br>
            <input type="submit" value="Se connecter" data-js-btnConnexion>
        </form>
        <button data-js-retour>Nouvel utilisateur? Créez un compte.</button>
    </div>

    <div class="hidden" data-js-creation>
        <form method="post">
            <h2>Créez un compte</h2>
            <label for="prenom">Prénom</label> 
            <input type="text" name="prenom" required data-js-prenom><br>
            <label for="nom">Nom</label>
            <input type="text" name="nom" required data-js-nom><br>
            <label for="dateNaissance">Date de naissance</label>
            <input type="date" name="dateNaissance" required data-js-date><br>
            <label for="adresse">Adresse</label> 
            <input type="text" name="adresse" required data-js-adresse><br>
            <label for="codePostal">Code postal</label> 
            <input type="text" name="codePostal" required data-js-postal><br>
            <label for="telephone">Téléphone</label> 
            <input type="tel" name="telephone" required data-js-telephone><br>
            <label for="cellulaire">Cellulaire </label>
            <input type="tel" name="cellulaire" data-js-cellulaire><br>
            <label for="courriel">Courriel </label>
            <input type="email" name="courriel" data-js-courriel><br>
            <label for="pseudonyme">Pseudonyme</label> 
            <input type="text" name="pseudonyme" required data-js-pseudo><br>
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" required data-js-mdp><br>
            <label for="villeId">Ville</label>
            <select id="villeId" name="villeId" data-js-ville>
<?php foreach ($data["villes"] as $ville) { ?>
                <option value="<?= $ville["idVille"] ?>"><?= $ville["nomVilleFR"] ?></option>
<?php } ?>
            </select>
            <br>
            <br>
            <input class="submit" type="submit" value="Enregistrer" data-js-btnCreation>
        </form>
        <button data-js-retourConnecte>Un compte? Connectez-vous.</button>
    </div>

<?php if(isset($_SESSION["utilisateur"])) { ?>
    
    <div class="hidden" data-js-commande>
        <p>Taxes</p>

<?php foreach ($data["taxes"] as $taxe) { ?>
        <p><?= $taxe["nomTaxeFR"] ?> <span data-js-taux><?= $taxe["taux"] ?></span>%</p>
<?php } ?>
        <h3>Total: <span data-js-total></span>$</h3><br>
        <label for="modePaiement">Mode de paiement</label>
        <select name="modePaiement">
<?php foreach ($data["modePaiement"] as $modePaiement) { ?>
            <option value="<?= $modePaiement["idModePaiement"] ?>"><?= $modePaiement["nomModeFR"] ?></option>
<?php } ?>
        </select>
        <button data-js-button>Commander</button>
    </div>
<?php } ?>

    <div class="hidden" data-js-confirmer>
        <h2>Commande complétée.</h2>
        
    </div>
</section>