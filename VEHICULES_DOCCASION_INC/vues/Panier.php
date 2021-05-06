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
        <h2>Connectez-vous</h2>
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

    <div style="display:none" data-js-creation>
        <h2>Créez un compte</h2>
        <form method="post">
            <label for="prenom">Prénom</label> 
            <input type="text" name="prenom" required><br>
            <label for="nom">Nom</label>
            <input type="text" name="nom" required><br>
            <label for="dateNaissance">Date de naissance</label>
            <input type="date" name="dateNaissance" required><br>
            <label for="adresse">Adresse</label> 
            <input type="text" name="adresse" required><br>
            <label for="codePostal">Code postal</label> 
            <input type="text" name="codePostal" required><br>
            <label for="telephone">Téléphone</label> 
            <input type="tel" name="telephone" required><br>
            <label for="cellulaire">Cellulaire </label>
            <input type="tel" name="cellulaire"><br>
            <label for="courriel">Courriel </label>
            <input type="email" name="courriel"><br>
            <label for="pseudonyme">Pseudonyme</label> 
            <input type="text" name="pseudonyme" required><br>
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" required><br>
            <label for="villeId">Ville</label> 
            <select id="villeId" name="villeId">
                <option value="1">Montréal</option>
                <option value="2">Laval</option>
                <option value="3">Longueuil</option>
                <option value="4">Toronto</option>
            </select>
            <br>
            <input type="hidden" name="action" value="insereUtilisateur"/>
            <br>
            <input class="submit" type="submit" value="Enregistrer"/>
        </form>
    </div>
</section>