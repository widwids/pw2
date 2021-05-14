
<section class="yu-section">

    <div class="yu-table-transmission yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter transmission</button>
    </div>

    <table class="yu-table yu-table-transmission" data-component="Pagination">
            
        <thead>
            <tr>
                <th>id</th>
                <th>Nom de la transmission en français</th>
                <th>Nom de la transmission en anglais</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data as $transmission) { ?>

        <tr>
            <td data-js-idTransmission><?= $transmission["idTransmission"]?></td>
            <td><?= $transmission["nomTransmissionFR"]?></td>
            <td><?= $transmission["nomTransmissionEN"]?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

    <?php }?>

    </tbody>

    </table>

</section>

<section class="yu-modal yu-modal-ajouter">
    
    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="nomTransmissionFR">Nom du transmission en français</label>
            <input type="text" name="nomTransmissionFR" value="" required>
        </div>
        <div>
            <label for="nomTransmissionEN">Nom du transmission en anglais</label>
            <input type="text" name="nomTransmissionEN" value="" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-transmission>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <input type="hidden" name="idTransmission">
        </div>
        <div>
            <label for="nomTransmissionFR">Nom de la transmission en français</label>
            <input type="text" name="nomTransmissionFR" value="" required>
        </div>
        <div>
            <label for="nomTransmissionEN">Nom de la transmission en anglais</label>
            <input type="text" name="nomTransmissionEN" value="" required>
        </div>
        <div>
            <input type="hidden" name="visibilite" checked>		
	    </div>           
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-transmission>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-supprimer">
    <button class="btn-ferme" data-js-btn-ferme-supprimer>&times;</button>
    <form class="yu-formulaire yu-formulaire-supprimer yu-modal-container">
        <div>
            <label>Êtes-vous sûr que vous voulez supprimer?</label>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idTransmission]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id;
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idTransmission]').innerHTML; 
            obtenirTransmissionAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirTransmissionAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let transmissionDonnees = jsonResponse;
            console.log(transmissionDonnees);
            
            formulaire.remplirFormulaire(transmissionDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Voiture_AJAX&action=detailTransmissionJson&idTransmission=${id}`, true);
    xhttp.send();    

}

function obtenirTransmissionsAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);
            console.log(jsonResponse);

            let table = document.querySelector("table tbody");
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let transmission = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idTransmission>${ transmission["idTransmission"]}</td>
                    <td>${ transmission["nomTransmissionFR"]}</td>
                    <td>${ transmission["nomTransmissionEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=TransmissionListeJson", true);
    xhttp.send();

}

function ajouterTransmissionAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test");
            obtenirTransmissionsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutTransmission", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierTransmissionAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirTransmissionsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=modifTransmission", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerTransmissionAJAX(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirTransmissionsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=transmission&id=${id}`);
}

let btnAjouterTransmission = document.querySelector("[data-js-btn-ajouter-transmission]");
btnAjouterTransmission.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterTransmissionAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierTransmission = document.querySelector("[data-js-btn-modifier-transmission]");
btnModifierTransmission.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierTransmissionAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
        supprimerTransmissionAJAX(evt.target.dataset.jsId);        
        yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>