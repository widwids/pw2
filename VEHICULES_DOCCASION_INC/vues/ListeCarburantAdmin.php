
<section class="yu-section">

    <div class="yu-table-carburant yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter carburant</button>
    </div>

    <table class="yu-table yu-table-carburant" data-component="Pagination">
            
        <thead>
            <tr>
                <th>id</th>
                <th>Type de carburant en français</th>
                <th>Type de carburant en anglais</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data as $carburant) { ?>

            <tr>
                <td data-js-idCarburant><?= $carburant["idCarburant"]?></td>
                <td><?= $carburant["typeCarburantFR"]?></td>
                <td><?= $carburant["typeCarburantEN"]?></td>
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
            <label for="typeCarburantFR">Type de carburant en français</label>
            <input type="text" name="typeCarburantFR" value="" required>
        </div>
        <div>
            <label for="typeCarburantEN">Type de carburant en anglais</label>
            <input type="text" name="typeCarburantEN" value="" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-carburant>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <input type="hidden" name="idCarburant">
        </div>
        <div>
            <label for="typeCarburantFR">Type de carburant en français</label>
            <input type="text" name="typeCarburantFR" value="" required>
        </div>
        <div>
            <label for="typeCarburantEN">Type de carburant en anglais</label>
            <input type="text" name="typeCarburantEN" value="" required>
        </div>
        <div>
            <input type="hidden" name="visibilite" checked>		
	    </div>          
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-carburant>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idCarburant]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id;
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idCarburant]').innerHTML; 
            obtenirCarburantAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirCarburantAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let carburantDonnees = jsonResponse;
            
            formulaire.remplirFormulaire(carburantDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Voiture_AJAX&action=detailCarburantJson&idCarburant=${id}`, true);
    xhttp.send();    

}

function obtenirCarburantsAJAX()
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
                let сarburant = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idCarburant>${ сarburant["idCarburant"]}</td>
                    <td>${ сarburant["typeCarburantFR"]}</td>
                    <td>${ сarburant["typeCarburantEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=CarburantListeJson", true);
    xhttp.send();

}

function ajouterCarburantAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test");
            obtenirCarburantsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutCarburant", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierCarburantAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirCarburantsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=modifCarburant", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerCarburantAJAX(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirCarburantsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=carburant&id=${id}`);
}

let btnAjouterVoiture = document.querySelector("[data-js-btn-ajouter-carburant]");
btnAjouterVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterCarburantAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierVoiture = document.querySelector("[data-js-btn-modifier-carburant]");
btnModifierVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierCarburantAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerCarburantAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>