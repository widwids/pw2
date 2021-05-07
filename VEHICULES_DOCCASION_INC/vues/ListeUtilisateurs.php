
<section class="yu-section">

    <div class="yu-table-btn-ajouter">
        <button class="yu-btn-ajouter">Ajouter un utilisateur</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-utilisateur">
        
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Cellulaire</th>
                <th>Téléphone</th>
                <th>Courriel</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data["utilisateurs"] as $utilisateur) { ?>

        <tr>
            <td><?= $utilisateur->prenom ?></td>
            <td><?= $utilisateur->nom ?></td>
            <td><?= $utilisateur->dateNaissance ?></td>
            <td><?= $utilisateur->adresse?></td>
            <td><?= $utilisateur->codePostal?></td>
            <td><?= $utilisateur->cellulaire?></td>
            <td><?= $utilisateur->telephone?></td>
            <td><?= $utilisateur->courriel?></td>
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
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" value="">
        </div>
        <div>
            <label for="nom">Nom</label>
            <input name="descriptionFR" id="nom" cols="30" rows="10"></input>
        </div>
        <div>
            <label for="dateNaissance">Date de naissance</label>
            <input type="date" name="dateNaissance" id="dateNaissance"></input>
        </div>
        <div>
            <label for="codePostal">Code postal</label>
            <input type="text" name="codePostal" value="">		
        </div>
        <div>
            <label for="adresse">Adresse</label>
            <input type="number" name="adresse" value="">
        </div>
        <div>
            <label for="codePostal">Code postal</label>
            <input name="codePostal" id="codePostal">
        </div>
        <div>
            <label for="cellulaire">Cellulaire</label>
            <input type="number" name="cellulaire" id="cellulaire">
        </div>
        <div>
        <div>
            <label for="telephone">Téléphone</label>
            <input type="number" name="telephone" id="telephone">
        </div>
        <div>
            <label for="courriel">Courriel</label>
            <input type="email" name="courriel" value="">		
        </div>
        <div>
            <label for="pseudonyme">Pseudonyme</label>
            <input type="text" name="pseudonyme" value="">		
        </div>
        <div>
            <label for="motDePasse">Pseudonyme</label>
            <input type="password" name="motDePasse" value="">		
        </div>
        <div>
            <label for="villeId">Ville</label>
            <select name="villeId" id="villeId">
                <option value="">Sélectionnez une Ville</option>
                    <?php foreach($data["ville"] as $ville) { ?>

                        <option value="<?= $groupeMP["idVille"] ?>"><?= $ville["nomVilleFR"]?></option>

                    <?php }?>
            </select>
        </div>1\
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-voiture>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
    <div>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" value="">
        </div>
        <div>
            <label for="nom">Nom</label>
            <input name="descriptionFR" id="nom" cols="30" rows="10"></input>
        </div>
        <div>
            <label for="dateNaissance">Date de naissance</label>
            <input type="date" name="dateNaissance" id="dateNaissance"></input>
        </div>
        <div>
            <label for="codePostal">Code postal</label>
            <input type="text" name="codePostal" value="">		
        </div>
        <div>
            <label for="adresse">Adresse</label>
            <input type="number" name="adresse" value="">
        </div>
        <div>
            <label for="codePostal">Code postal</label>
            <input name="codePostal" id="codePostal">
        </div>
        <div>
            <label for="cellulaire">Cellulaire</label>
            <input type="number" name="cellulaire" id="cellulaire">
        </div>
        <div>
        <div>
            <label for="telephone">Téléphone</label>
            <input type="number" name="telephone" id="telephone">
        </div>
        <div>
            <label for="courriel">Courriel</label>
            <input type="email" name="courriel" value="">		
        </div>
        <div>
            <label for="pseudonyme">Pseudonyme</label>
            <input type="text" name="pseudonyme" value="">		
        </div>
        <div>
            <label for="motDePasse">Pseudonyme</label>
            <input type="password" name="motDePasse" value="">		
        </div>
        <div>
            <label for="villeId">Ville</label>
            <select name="villeId" id="villeId">
                <option value="">Sélectionnez une Ville</option>
                    <?php foreach($data["ville"] as $ville) { ?>

                        <option value="<?= $groupeMP["idVille"] ?>"><?= $ville["nomVilleFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-voiture>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-supprimer">
    <button class="btn-ferme" data-js-btn-ferme-supprimer>&times;</button>
    <form class="yu-formulaire yu-formulaire-supprimer yu-modal-container">
        <div>
            <label>Êtes-vous sûr que vous voulez la supprimer?</label>
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
btnFermeSupprimer.addEventListener("click", () => { 
    yuModalSupprimer.style.width = "0" 
});


function ajouterEvenements()
{
    let btnsSupprimer = document.querySelectorAll(".yu-btn-supprimer"); 
    for(let i = 0; i<btnsSupprimer.length; i++)
    {
        btnsSupprimer[i].addEventListener("click", (evt) => {
            let noSerie = evt.target.parentNode.parentNode.querySelector('[data-js-noSerie]').innerHTML;
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = noSerie;
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let noSerie = evt.target.parentNode.parentNode.querySelector('[data-js-noSerie]').innerHTML;
            obtenirVoitureAJAX(noSerie);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirVoitureAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let voitureDonnees = jsonResponse['voiture'];
            console.log(voitureDonnees);
            
            formulaire.remplirFormulaire(voitureDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Voiture_AJAX&action=detailVoitureJson&noSerie=${id}`, true);
    xhttp.send();    

}

function obtenirVoituresAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['voitures'];
            console.log(jsonResponse);

            let table = document.querySelector("table tbody");
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let voiture = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td class="yu-image"><img src="./assets/images/${voiture["nomPhoto"]}.jpg" alt="car"></td>
                    <td data-js-noSerie>${voiture["noSerie"]}</td>
                    <td>${voiture["kilometrage"]}</td>
                    <td>${voiture["dateArrivee"]}</td>
                    <td>${voiture["prixAchat"]}</td>
                    <td>${voiture["nomMarque"]}</td>
                    <td>${voiture["nomModele"]}</td>
                    <td>${voiture["anneeId"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=VoitureListeJson", true);
    xhttp.send();

}

function ajouterVoitureAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirVoituresAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutVoiture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());

}

function modifierVoitureAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirVoituresAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=modifVoiture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());

}

function supprimerVoitureAJAX(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirVoituresAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=voiture&id=${id}`);
}

let btnAjouterVoiture = document.querySelector("[data-js-btn-ajouter-voiture]");
btnAjouterVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    ajouterVoitureAJAX();
    yuModalAjouter.style.width = "0";

});

let btnModifierVoiture = document.querySelector("[data-js-btn-modifier-voiture]");
btnModifierVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    modifierVoitureAJAX();
    yuModalModifier.style.width = "0";

});

let btnOui = document.querySelector('.yu-modal-supprimer button[name="btnOui"]'); 
btnOui.addEventListener("click", (evt) => {

    evt.preventDefault();
    supprimerVoitureAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";

});











</script>
