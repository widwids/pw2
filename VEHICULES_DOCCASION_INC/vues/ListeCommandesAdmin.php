<section class="yu-section">

    <div class="yu-table-commande yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter une commande</button>
    </div>

    <table class="yu-table yu-table-commande">
            
        <thead>
            <tr>
                <th>No Commande</th>
                <th>No Série</th>
                <th>Prix de vente</th>
                <th>Dépôt</th>
                <th>Statut</th>
                <th>Expédition</th>
                <th>Mode de Paiement</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data["commandes"] as $commande) { ?>

            <tr>
                <td data-js-commandeNo><?= $commande["commandeNo"]?></td>
                <td><?= $commande["voitureId"]?></td>
                <td><?= $commande["prixVente"]?></td>
                <td><?= $commande["depot"]?></td>
                <td><?= $commande["nomStatutFR"]?></td>
                <td><?= $commande["nomExpeditionFR"]?></td>
                <td><?= $commande["nomModeFR"]?></td>
                <td><?= $commande["dateCommande"]?></td>
                <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
            </tr>

        <?php }?>

        </tbody>


    </table>

</section>

<section class="yu-modal yu-modal-ajouter">
    
    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="voitureId">No de Série</label>
            <input type="text" name="voitureId" value="" required>
        </div>
        <div>
            <label for="prixVente">Prix de vente</label>
            <input type="text" name="prixVente" value="" required>
        </div>
        <div>
            <label for="depot">Dépôt</label>
            <input type="text" name="depot" value="">
        </div>
        <label for="statutId">Statut</label>
        <select name="statutId">
            <option value="" selected hidden disabled>Veuillez choisir le statut de la commande</option>
<?php foreach ($data["statuts"] as $statut) { ?>           
            <option value="<?= $statut["idStatut"] ?>"><?= $statut["nomStatutFR"] ?></option>
<?php } ?>
        </select>
        <label for="expeditionId">Expédition</label>
        <select name="expeditionId">
            <option value="" selected hidden disabled>Veuillez choisir un mode d'expédition</option>
<?php foreach ($data["expeditions"] as $expedition) { ?>           
            <option value="<?= $expedition["idExpedition"] ?>"><?= $expedition["nomExpeditionFR"] ?></option>
<?php } ?>
        </select>
        <label for="modePaiementNo">Mode de paiement</label>
        <select name="modePaiementNo">
            <option value="" selected hidden disabled>Veuillez choisir un mode de paiement</option>
<?php foreach ($data["modePaiement"] as $modePaiement) { ?>           
            <option value="<?= $modePaiement["idModePaiement"] ?>"><?= $modePaiement["nomModeFR"] ?></option>
<?php } ?>
        </select>
        <label for="usagerId">Utilisateur</label>
        <select name="usagerId">
            <option value="" selected hidden disabled>Veuillez choisir un utilisateur</option>
<?php foreach ($data["utilisateurs"] as $utilisateur) { ?>           
            <option value="<?= $utilisateur["idUtilisateur"] ?>">
                <?= $utilisateur["prenom"] ?> <?= $utilisateur["nom"] ?>
            </option>
<?php } ?>
        </select>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-commande>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <input type="hidden" name="noCommande">
        </div>
        <div>
            <label for="voitureId">No de Série</label>
            <input type="text" name="voitureId" value="" required>
        </div>
        <div>
            <label for="prixVente">Prix de vente</label>
            <input type="text" name="prixVente" value="" required>
        </div>
        <div>
            <label for="depot">Dépôt</label>
            <input type="text" name="depot" value="" required>
        </div>
        <label for="statutId">Statut</label>
        <select name="statutId">
            <option value="" selected hidden disabled>Veuillez choisir le statut de la commande</option>
<?php foreach ($data["statuts"] as $statut) { ?>           
            <option value="<?= $statut["idStatut"] ?>"><?= $statut["nomStatutFR"] ?></option>
<?php } ?>
        </select>
        <label for="expeditionId">Expédition</label>
        <select name="expeditionId">
            <option value="" selected hidden disabled>Veuillez choisir un mode d'expédition</option>
<?php foreach ($data["expeditions"] as $expedition) { ?>           
            <option value="<?= $expedition["idExpedition"] ?>"><?= $expedition["nomExpeditionFR"] ?></option>
<?php } ?>
        </select>
        <label for="modePaiementNo">Mode de paiement</label>
        <select name="modePaiementNo">
            <option value="" selected hidden disabled>Veuillez choisir un mode de paiement</option>
<?php foreach ($data["modePaiement"] as $modePaiement) { ?>           
            <option value="<?= $modePaiement["idModePaiement"] ?>"><?= $modePaiement["nomModeFR"] ?></option>
<?php } ?>
        </select>
        <label for="idUtilisateur">Utilisateur</label>
        <select name="idUtilisateur">
            <option value="" selected hidden disabled>Veuillez choisir un utilisateur</option>
<?php foreach ($data["utilisateurs"] as $utilisateur) { ?>           
            <option value="<?= $utilisateur["idUtilisateur"] ?>">
                <?= $utilisateur["prenom"] ?> <?= $utilisateur["nom"] ?>
            </option>
<?php } ?>
        </select>        
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-commande>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-supprimer">
    <button class="btn-ferme" data-js-btn-ferme-supprimer>&times;</button>
    <form class="yu-formulaire yu-formulaire-supprimer yu-modal-container">
        <div>
            <label>Êtes-vous sûr de vouloir supprimer cette commande?</label>
        </div>
        <div>
            <button type="submit" name="btnOui" value="Oui" class="yu-btn yu-btn-supprimer" data-js-id>Oui</button>
            <button type="submit" name="btnNon" value="Non" class="yu-btn yu-btn-modifier">Non</button>
        </div>
    </form>
</section>

<script type="text/javascript">

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
    let btnsSupprimer = document.querySelectorAll(".yu-btn-supprimer"),
        btnsModifier = document.querySelectorAll(".yu-btn-modifier");

    for(let i = 0; i < btnsSupprimer.length; i++) {
        btnsSupprimer[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-commandeNo]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id;
            yuModalSupprimer.style.width = "100%";
        });
    }
    
    for(let i = 0; i < btnsModifier.length; i++) {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-commandeNo]').innerHTML; 
            obtenirCommandeAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }
}

ajouterEvenements();

function obtenirCommandeAJAX(id) {

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            console.log(this.response);
            let jsonResponse = JSON.parse(this.response);             
            let commandeDonnees = jsonResponse;
            
            formulaire.remplirFormulaire(commandeDonnees);           
        }
    };

    xhttp.open("GET", `index.php?Commande&action=afficheCommande&commandeNo=${id}`, true);
    xhttp.send();
}

function obtenirCommandesAJAX() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.response);

            let table = document.querySelector("table tbody");
            table.innerHTML = "";

            for(let i = 0; i < jsonResponse.length; i++) {
                let commande = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-commandeNo><?= $commande["commandeNo"]?></td>
                    <td>${commande["voitureId"]}</td>
                    <td>${commande["prixVente"]}</td>
                    <td>${commande["depot"]}</td>
                    <td>${commande["nomStatutFR"]}</td>
                    <td>${commande["nomExpeditionFR"]}</td>
                    <td>${commande["nomModeFR"]}</td>
                    <td>${commande["dateCommande"]}</td>
                    <td>
                        <button class="yu-btn-modifier yu-btn">Modifier</button>
                        <button class="yu-btn-supprimer yu-btn">Supprimer</button>
                    </td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
        }
    };

    xhttp.open("GET", "index.php?Commande&action=afficheCommandesAJAX", true);
    xhttp.send();
}

function ajouterCommandeAJAX() {
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
            obtenirCommandesAJAX();
    };

    xhttp.open("POST", "index.php?Commande&action=ajouterCommandeEmploye", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierCommandeAJAX() {
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirCommandesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Commande&action=modifierCommande", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimercommandeAJAX(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenircommandesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Commande&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=commande&id=${id}`);
}

let btnAjouterVoiture = document.querySelector("[data-js-btn-ajouter-commande]");
btnAjouterVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    ajouterCommandeAJAX();
    yuModalAjouter.style.width = "0";

});

let btnModifierVoiture = document.querySelector("[data-js-btn-modifier-commande]");
btnModifierVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    modifierCommandeAJAX();
    yuModalModifier.style.width = "0";

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerCommandeAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    } else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>