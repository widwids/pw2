<section class="yu-section">

    <div class="yu-table-facture yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter une facture</button>
    </div>

    <div class="yu-table-responsive">
        <table class="yu-table yu-table-facture">
            <thead>
                <tr>
                    <th>No Facture</th>
                    <th>Nom client</th>
                    <th>No série</th>
                    <th>Date</th>
                    <th>Prix final</th>
                    <th>Mode de paiement</th>
                    <th>Expédition</th>
                </tr>
            </thead>

            <tbody>

<?php foreach ($data['factures'] as $facture) { ?>

                <tr>
                    <td data-js-noFacture><?= $facture["noFacture"]?></td>
                    <td><?= $facture["prenom"]?> <?= $facture["nom"]?></td>
                    <td><?= $facture["serieNo"] ?></td>
                    <td><?= $facture["dateFacture"]?></td>
                    <td><?= $facture["prixFinal"]?></td>
                    <td><?= $facture["nomModeFR"]?> / <?= $facture["nomModeEN"]?></td>
                    <td><?= $facture["nomExpeditionFR"]?> / <?= $facture["nomExpeditionEN"]?></td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>

<?php }?>
            </tbody>
        </table>
    </div>

</section>

<section class="yu-modal yu-modal-ajouter">

    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="noFacture">No Commande</label>
            <select name="noFacture" id="noFacture">
                <option value="" selected hidden disabled>Sélectionnez un numéro de commande</option>
<?php foreach($data["commandes"] as $commande) { ?>
                <option value="<?= $commande["noCommande"] ?>">
                    <?= $commande["noCommande"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="prixFinal">Prix final</label>
            <input type="text" name="prixFinal" required>
        </div>
        <div>
            <label for="idUsager">Utilisateur</label>
            <select name="idUsager" id="idUsager">
                <option value="" selected hidden disabled>Sélectionnez un utilisateur</option>
<?php foreach($data["utilisateurs"] as $utilisateur) { ?>
                <option value="<?= $utilisateur["idUtilisateur"] ?>">
                    <?= $utilisateur["prenom"] ?> <?= $utilisateur["nom"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="serieNo">Voiture</label>
            <select name="serieNo" id="serieNo">
                <option value="" selected hidden disabled>Sélectionnez une voiture</option>
<?php foreach($data["voitures"] as $voiture) { ?>
                <option value="<?= $voiture["noSerie"] ?>">
                    <?= $voiture["noSerie"] ?> : 
                    <?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"] ?> <?= $voiture["anneeId"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="modePaiementId">Mode de paiement</label>
            <select name="modePaiementId" id="modePaiementId">
                <option value="" selected hidden disabled>Sélectionnez un mode de paiement</option>
<?php foreach($data["modePaiement"] as $modePaiement) { ?>
                <option value="<?= $modePaiement["idModePaiement"] ?>">
                    <?= $modePaiement["nomModeFR"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="expeditionNo">Expédition</label>
            <select name="expeditionNo" id="expeditionNo">
                <option value="" selected hidden disabled>Veuillez choisir un mode d'expédition</option>
<?php foreach ($data["expeditions"] as $expedition) { ?>           
                <option value="<?= $expedition["idExpedition"] ?>"><?= $expedition["nomExpeditionFR"] ?></option>
<?php } ?>
            </select>            
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-facture>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-modifier">

    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="noFacture">No Commande</label>
            <select name="noFacture" id="noFacture">
                <option value="" selected hidden disabled>Sélectionnez un numéro de commande</option>
<?php foreach($data["commandes"] as $commande) { ?>
                <option value="<?= $commande["noCommande"] ?>">
                    <?= $commande["noCommande"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="prixFinal">Prix final</label>
            <input type="text" name="prixFinal" required>
        </div>
        <div>
            <label for="idUsager">Utilisateur</label>
            <select name="idUsager" id="idUsager">
                <option value="" selected hidden disabled>Sélectionnez un utilisateur</option>
<?php foreach($data["utilisateurs"] as $utilisateur) { ?>
                <option value="<?= $utilisateur["idUtilisateur"] ?>">
                    <?= $utilisateur["prenom"] ?> <?= $utilisateur["nom"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="serieNo">Voiture</label>
            <select name="serieNo" id="serieNo">
                <option value="" selected hidden disabled>Sélectionnez une voiture</option>
<?php foreach($data["voitures"] as $voiture) { ?>
                <option value="<?= $voiture["noSerie"] ?>">
                    <?= $voiture["noSerie"] ?> : 
                    <?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"] ?> <?= $voiture["anneeId"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="modePaiementId">Mode de paiement</label>
            <select name="modePaiementId" id="modePaiementId">
                <option value="" selected hidden disabled>Sélectionnez un mode de paiement</option>
<?php foreach($data["modePaiement"] as $modePaiement) { ?>
                <option value="<?= $modePaiement["idModePaiement"] ?>">
                    <?= $modePaiement["nomModeFR"] ?>
                </option>
<?php }?>
            </select>
        </div>
        <div>
            <label for="expeditionNo">Expédition</label>
            <select name="expeditionNo" id="expeditionNo">
                <option value="" selected hidden disabled>Veuillez choisir un mode d'expédition</option>
<?php foreach ($data["expeditions"] as $expedition) { ?>           
                <option value="<?= $expedition["idExpedition"] ?>"><?= $expedition["nomExpeditionFR"] ?></option>
<?php } ?>
            </select>                   
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-facture>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-supprimer">
    <button class="btn-ferme" data-js-btn-ferme-supprimer>&times;</button>
    <form class="yu-formulaire yu-formulaire-supprimer yu-modal-container">
        <div>
            <label>Êtes-vous sûr de vouloir supprimer cette facture?</label>
        </div>
        <div>
            <button type="submit" name="btnOui" value="Oui" class="yu-btn yu-btn-supprimer" data-js-id>Oui</button>
            <button type="submit" name="btnNon" value="Non" class="yu-btn yu-btn-modifier">Non</button>
        </div>
    </form>
</section>

<script>

let yuModalAjouter = document.querySelector(".yu-modal-ajouter"); 
let btnFermeAjouter = document.querySelector("[data-js-btn-ferme-ajouter]"); 
btnFermeAjouter.addEventListener("click", () => { yuModalAjouter.style.width = "0" });

let btnAjouter = document.querySelector(".yu-btn-ajouter"); 
btnAjouter.addEventListener("click", () => { yuModalAjouter.style.width = "100%"; });

let yuModalModifier = document.querySelector(".yu-modal-modifier"); 
let btnFermeModifier = document.querySelector("[data-js-btn-ferme-modifier]"); 
btnFermeModifier.addEventListener("click", () => { yuModalModifier.style.width = "0" });

let yuModalSupprimer = document.querySelector(".yu-modal-supprimer"); 
let btnFermeSupprimer = document.querySelector("[data-js-btn-ferme-supprimer]"); 
btnFermeSupprimer.addEventListener("click", () => { yuModalSupprimer.style.width = "0" });

function ajouterEvenements() {
    let btnsSupprimer = document.querySelectorAll(".yu-btn-supprimer"); 
    for(let i = 0; i<btnsSupprimer.length; i++)
    {
        btnsSupprimer[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-noFacture]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-noFacture]').innerHTML; 
            obtenirFactureAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }
}

ajouterEvenements();

function obtenirFactureAJAX(id) {

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let factureDonnees = jsonResponse['facture'];
            console.log("factureDonnees",factureDonnees);
            
            formulaire.remplirFormulaire(factureDonnees);           
        }
    };

    xhttp.open("GET", `index.php?Commande&action=afficheFactureAJAX&noFacture=${id}`, true);
    xhttp.send();
}

function obtenirFacturesAJAX() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['factures'];
            console.log(jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let facture = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-noFacture>${facture["noFacture"]}</td>
                    <td>${facture["prenom"]} ${facture["nom"]}</td>
                    <td>${facture["voitureId"]}></td>
                    <td>${facture["dateFacture"]}</td>
                    <td>${facture["prixFinal"]}</td>
                    <td>${facture["nomModeFR"]} / ${facture["nomModeEN"]}</td>
                    <td>${facture["nomExpeditionFR"]} / ${facture["nomExpeditionEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
        }
    };

    xhttp.open("GET", "index.php?Commande&action=listeFacturesAJAX", true);
    xhttp.send();
}

function ajouterFactureAJAX() {
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response ajouter", this.response);
            obtenirFacturesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Commande&action=ajouterFacture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log(formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierFactureAJAX() {
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirFacturesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Commande&action=modifierFacture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerFactureAJAX(id) {
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirFacturesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Commande&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=facture&id=${id}`);
}

let btnAjouterFacture = document.querySelector("[data-js-btn-ajouter-facture]");
btnAjouterFacture.addEventListener("click", (evt) => {
    evt.preventDefault();
    ajouterFactureAJAX();
    yuModalAjouter.style.width = "0";
});

let btnModifierFacture = document.querySelector("[data-js-btn-modifier-facture]");
btnModifierFacture.addEventListener("click", (evt) => {
    evt.preventDefault();
    modifierFactureAJAX();
    yuModalModifier.style.width = "0";
});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui") {
        supprimerFactureAJAX(evt.target.dataset.jsId);
        yuModalSupprimer.style.width = "0";
    } else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

