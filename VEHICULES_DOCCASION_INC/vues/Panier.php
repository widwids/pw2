<section class="panier" data-component="Panier">
    <div data-js-panier>
        <h1>Panier</h1>
        <div data-js-articles></div><br>
        <p class="sous-total">Sous-total : <span data-js-sousTotal></span>$</p><br>
    </div>
    <button class="caisse" data-js-caisse>Passez à la caisse</button>

    <div class="hidden" data-js-choix>
        <button data-js-connecter>Connectez-vous.</button>
        <button data-js-creer>Créez un compte.</button>
    </div>

    <div class="hidden connexionWrapper haut" data-js-connexion>
        <form method="post" class="login">
            <h2>Connexion</h2>
            <label for="pseudonyme">Nom d'utilisateur</label>
            <input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required data-js-pseudonyme><br>
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" placeholder="Mot de passe" required data-js-motDePasse><br>
            <br>
            <input type="submit" value="Se connecter" data-js-btnConnexion>
        </form>
        <a class="lien" href="#" data-js-retour>Nouvel utilisateur? Créez un compte.</a>
    </div>

    <div class="hidden creationCompteWrapper" data-js-creation>
        <form method="post" class="creationCompte">
            <h2>Création de compte</h2>
            <label for="prenom">Prénom</label> <br>
            <input type="text" name="prenom" placeholder="Prénom" required><br>
            <label for="nom">Nom</label><br>
            <input type="text" name="nom" placeholder="Nom" required><br>
            <label for="dateNaissance">Date de naissance</label><br>
            <input type="date" name="dateNaissance" placeholder="AAAA-MM-JJ" required><br>
            <label for="adresse">Adresse</label> <br>
            <input type="text" name="adresse" placeholder="123 Votre Rue" required><br>
            <label for="codePostal">Code postal</label> <br>
            <input type="text" name="codePostal" placeholder="XXX XXX" required><br>
            <label for="telephone">Téléphone</label> <br>
            <input type="tel" name="telephone" placeholder="XXX-XXX-XXXX" required><br>
            <label for="cellulaire">Cellulaire </label><br>
            <input type="tel" name="cellulaire"placeholder="XXX-XXX-XXXX" ><br>
            <label for="courriel">Courriel </label><br>
            <input type="email" name="courriel"placeholder="xyz@email.xyz" ><br>
            <label for="pseudonyme">Pseudonyme</label> <br>
            <input type="text" name="pseudonyme" placeholder="Identifiant" required><br>
            <label for="motDePasse">Mot de passe</label><br>
            <input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
            <label for="villeId">Ville</label> <br>
            <select id="villeId" name="villeId" data-js-ville>
<?php foreach ($data["villes"] as $ville) { ?>
                <option value="<?= $ville["idVille"] ?>"><?= $ville["nomVilleFR"] ?></option>
<?php } ?>
            </select>
            <br>
            <input type="submit" value="Enregistrer" data-js-btnCreation>
        </form>
        <a class="lien" href="#" data-js-retourConnecte>Un compte? Connectez-vous.</a>
    </div>

<?php if(isset($_SESSION["utilisateur"])) { ?>
    
    <div class="hidden" data-js-commande>
        <div class="commande">

            <div classe="modePaiement">
                <label for="modePaiement">Mode de paiement</label>
                <select name="modePaiement" data-js-modePaiement>
                    <option value='' selected disabled>Choisissez le mode de paiement</option>
<?php foreach ($data["modePaiement"] as $modePaiement) { ?>
                    <option value="<?= $modePaiement["idModePaiement"] ?>"><?= $modePaiement["nomModeFR"] ?></option>
<?php } ?>
                </select>
            </div>
                
            <div class="expedition">
                <label for="expedition">Mode d'expédition</label>
                <select name="expedition" data-js-expedition>
                    <option value='' selected disabled>Choisissez le mode d'expédition</option>
<?php foreach ($data["expeditions"] as $expedition) { ?>
                    <option value="<?= $expedition["idExpedition"] ?>"><?= $expedition["nomExpeditionFR"] ?></option>
<?php } ?>
                </select>
            </div>
        </div>

        <div class="paiement">
            <div classe="taxes">
                <h2>Taxes</h2>
    <?php foreach ($data["taxes"] as $taxe) { ?>
                <p><?= $taxe["nomTaxeFR"] ?> <span data-js-taux><?= $taxe["taux"] ?></span>%</p>
    <?php } ?>
            </div>

            <h2 class="sous-total">Total: <span data-js-total></span>$</h2>
        </div>
        <br>
        <button class="caisse" data-js-button>Commander</button>
    </div>

<?php } ?>

    <div class="hidden" data-js-confirmer>
        <div class="complete">
            <h2>Commande complétée.</h2>
            <p>Merci.</p>
        </div>
    </div>
</section>