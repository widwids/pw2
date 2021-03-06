
<section class="yu-section">

    <div class="yu-table-voiture yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter un véhicule</button>
    </div>

    <div class="yu-table-responsive">        
    <table class="yu-table yu-table-voiture" data-component="Pagination">
        
        <thead>
            <tr>
                <th>Photo</th>
                <th>№ Série</th>
                <th>Kilométrage</th>
                <th>Date Arrivée</th>
                <th>Prix Achat</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Année</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data["voitures"] as $voiture) { ?>

        <tr>
            <td class="yu-image"><img src="./assets/images/<?= $voiture["nomPhoto"] ?>.jpg" alt="car"></td>
            <td data-js-noSerie><?= $voiture["noSerie"]?></td>
            <td><?= $voiture["kilometrage"] ?></td>
            <td class="yu-date-arr"><?= $voiture["dateArrivee"]?></td>
            <td><?= $voiture["prixAchat"]?></td>
            <td><?= $voiture["nomMarque"]?></td>
            <td><?= $voiture["nomModele"]?></td>
            <td><?= $voiture["anneeId"]?></td>
            <td class="yu-actions"><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

            
        <?php }?>

        </tbody>




    </table>
    </div>

</section>


<section class="yu-modal yu-modal-ajouter">
    
    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container" enctype="multipart/form-data">
        <div>
            <label for="noSerie">№ Série</label>
            <input type="text" name="noSerie" value="" data-js-nserie required>
        </div>
        <div>
            <label for="descriptionFR">Description en français</label>
            <textarea name="descriptionFR" id="descriptionFR" cols="30" rows="10" required></textarea >
        </div>
        <div>
            <label for="descriptionEN">Description en anglais</label>
            <textarea name="descriptionEN" id="descriptionEN" cols="30" rows="10" required></textarea>
        </div>
        <div>
            <label for="kilometrage">Kilométrage</label>
            <input type="number" name="kilometrage" value="" required>
        </div>
        <div>
            <label for="dateArrivee">Date d'arrivée</label>
            <input type="date" name="dateArrivee" id="dateArrivee" required>
        </div>
        <div>
            <label for="prixAchat">Prix d'achat</label>
            <input type="number" name="prixAchat" id="prixAchat" required>
        </div>
        <div>
            <label for="groupeMPid">Motopropulseur</label>
            <select name="groupeMPId" id="groupeMPid" >
                <option value="">Sélectionnez le motopropulseur</option>
                    <?php foreach($data["motopropulseur"] as $groupeMP) { ?>

                        <option value="<?= $groupeMP["idMotopro"] ?>"><?= $groupeMP["nomMotopro"]?></option>

                    <?php }?>
            </select>
        </div>
            <label for="corpsId">Type de véhicule</label>
            <select name="corpsId" id="corpsId">
                <option value="">Sélectionnez un type de véhicule</option>
                    <?php foreach($data["corps"] as $corp) { ?>

                        <option value="<?= $corp["idCorps"] ?>"><?= $corp["nomCorpsFR"]?></option>

                    <?php }?>
            </select>
        <div>
            <label for="carburantId">Carburant</label>
            <select name="carburantId" id="carburantId">
                <option value="">Sélectionnez un carburant</option>
                    <?php foreach($data["carburant"] as $carburant) { ?>

                        <option value="<?= $carburant["idCarburant"] ?>"><?= $carburant["typeCarburantFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="modeleId">Modèle</label>
            <select name="modeleId" id="modeleId">
                <option value="">Sélectionnez un modèle</option>
                    <?php foreach($data["modele"] as $modele) { ?>

                        <option value="<?= $modele["idModele"] ?>"><?= $modele["nomModele"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="transmissionId">Transmission</label>
            <select name="transmissionId" id="transmissionId">
                <option value="">Sélectionnez une transmission</option>
                    <?php foreach($data["transmission"] as $transmission) { ?>

                        <option value="<?= $transmission["idTransmission"] ?>"><?= $transmission["nomTransmissionFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="anneeId">Année</label>
            <select name="anneeId" id="anneeId">
                <option value="">Sélectionnez une année</option>
                    <?php foreach($data["annee"] as $annee) { ?>

                        <option value="<?= $annee["annee"] ?>"><?= $annee["annee"]?></option>

                    <?php }?>
            </select>
        </div>
        <div data-js-photos>
            <div class="yu-file">
                <label>Photo principale</label>
                <label for="imgPrincipale">Sélectionnez une image</label>
                <input type="file" id="imgPrincipale" name="imgPrincipale" accept=".jpg, .jpeg" data-js-ordre="1">
                <div class="yu-image-container">
                    <img src="" alt="">
                </div>
            </div>
            <button data-js-btn-ajouter-photos>+</button>
        </div>
        <div>
            <input type="hidden" name="visibilite" checked>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-voiture>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="noSerie">№ Série</label>
            <input type="text" name="noSerie" value="" data-js-nserie required>
        </div>
        <div>
            <label for="descriptionFR">Description en français</label>
            <textarea name="descriptionFR" id="descriptionFR" cols="30" rows="10" required></textarea>
        </div>
        <div>
            <label for="descriptionEN">Description en anglais</label>
            <textarea name="descriptionEN" id="descriptionEN" cols="30" rows="10" required></textarea>
        </div>
        <div>
            <label for="kilometrage">Kilométrage</label>
            <input type="number" name="kilometrage" value="" required>
        </div>
        <div>
            <label for="dateArrivee">Date d'arrivée</label>
            <input type="date" name="dateArrivee" id="dateArrivee" required>
        </div>
        <div>
            <label for="prixAchat">Prix d'achat</label>
            <input type="number" name="prixAchat" id="prixAchat" required>
        </div>
        <div>
            <label for="groupeMPId">Motopropulseur</label>
            <select name="groupeMPId" id="groupeMPid">
                <option value="">Sélectionnez le motopropulseur</option>
                    <?php foreach($data["motopropulseur"] as $groupeMP) { ?>

                        <option value="<?= $groupeMP["idMotopro"] ?>"><?= $groupeMP["nomMotopro"]?></option>

                    <?php }?>
            </select>
        </div>
            <label for="corpsId">Type de véhicule</label>
            <select name="corpsId" id="corpsId">
                <option value="">Sélectionnez un type de véhicule</option>
                    <?php foreach($data["corps"] as $corp) { ?>

                        <option value="<?= $corp["idCorps"] ?>"><?= $corp["nomCorpsFR"]?></option>

                    <?php }?>
            </select>
        <div>
            <label for="carburantId">Carburant</label>
            <select name="carburantId" id="carburantId">
                <option value="">Sélectionnez un carburant</option>
                    <?php foreach($data["carburant"] as $carburant) { ?>

                        <option value="<?= $carburant["idCarburant"] ?>"><?= $carburant["typeCarburantFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="modeleId">Modèle</label>
            <select name="modeleId" id="modeleId">
                <option value="">Sélectionnez un modèle</option>
                    <?php foreach($data["modele"] as $modele) { ?>

                        <option value="<?= $modele["idModele"] ?>"><?= $modele["nomModele"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="transmissionId">Transmission</label>
            <select name="transmissionId" id="transmissionId">
                <option value="">Sélectionnez une transmission</option>
                    <?php foreach($data["transmission"] as $transmission) { ?>

                        <option value="<?= $transmission["idTransmission"] ?>"><?= $transmission["nomTransmissionFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="anneeId">Année</label>
            <select name="anneeId" id="anneeId">
                <option value="">Sélectionnez une année</option>
                    <?php foreach($data["annee"] as $annee) { ?>

                        <option value="<?= $annee["annee"] ?>"><?= $annee["annee"]?></option>

                    <?php }?>
            </select>
        </div>
        <div data-js-photos>
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
            <label>Êtes-vous sûr de vouloir supprimer?</label>
        </div>
        <div>
            <button type="submit" name="btnOui" value="Oui" class="yu-btn yu-btn-supprimer" data-js-id=""> Oui </button>
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
            console.log("voitureDonnees",voitureDonnees[0]);
            
            formulaire.remplirFormulaire(voitureDonnees[0]);           
            formulaire.remplirPhotosFormulaire(jsonResponse['photos']);
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
                    <td class="yu-date-arr">${voiture["dateArrivee"]}</td>
                    <td>${voiture["prixAchat"]}</td>
                    <td>${voiture["nomMarque"]}</td>
                    <td>${voiture["nomModele"]}</td>
                    <td>${voiture["anneeId"]}</td>
                    <td class="yu-actions"><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=VoitureListeJson", true);
    xhttp.send();

}

function ajouterVoitureAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);
    formulaire.envoyerPhotos();

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
    formulaire.envoyerPhotos();

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
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterVoitureAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierVoiture = document.querySelector("[data-js-btn-modifier-voiture]");
btnModifierVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierVoitureAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerVoitureAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});


function showImage(src,target) {
  var fr=new FileReader();
  fr.onload = function(e) { target.src = e.target.result; };
  fr.readAsDataURL(src.files[0]); 
}

yuModalAjouter.addEventListener("change", (evt) => 
{
    if(evt.target.type == "file"){
        let filename = evt.target.value.split(/(\\|\/)/g).pop();
        evt.target.previousElementSibling.innerHTML = filename;

        showImage(evt.target, evt.target.parentNode.querySelector("img"));

    }
});

yuModalAjouter.querySelector("[data-js-btn-ajouter-photos]").addEventListener("click", (evt) => 
{
    evt.preventDefault();
    let rnd = Math.round(Math.random()*1000);
    let previousOrdre = evt.target.previousElementSibling.querySelector('input').dataset.jsOrdre;
    previousOrdre = parseInt(previousOrdre) + 1;

    let nFile = document.createElement("div");
    nFile.classList.add("yu-file");
    nFile.innerHTML =
    `
        <div class="yu-file">
            <label>Photo secondaire</label>
            <label for="imgSecondaire${rnd}">Sélectionnez une image</label>
            <input type="file" id="imgSecondaire${rnd}" name="imgSecondaire[]" accept=".jpg, .jpeg" data-js-ordre="${previousOrdre}">
            <div class="yu-image-container">
                    <img src="" alt="">
            </div>
        </div>
    `;

    evt.target.parentNode.insertBefore(nFile, evt.target);


});




</script>
