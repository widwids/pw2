
<section class="yu-section">

    <div class="yu-table-modele yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Ajouter modèle</button>
    </div>

    <table class="yu-table yu-table-modele" data-component="Pagination">

        <thead>
        <tr>
            <th>id</th>
            <th>Nom du modèle</th>
            <th>Marque</th>
            <th>Actions</th>
        </tr>
        </thead>   


    <tbody>

    <?php foreach ($data['marque_modele'] as $modele) { ?>

        <tr>
            <td data-js-idModele><?= $modele["idModele"]?></td>
            <td><?= $modele["nomModele"]?></td>
            <td><?= $modele["nomMarque"]?></td>
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
            <label for="nomModele">Nom du modèle</label>
            <input type="text" name="nomModele" value="" required>
        </div>
        <div>
            <label for="marqueId">Marque</label>
            <select name="marqueId" id="marqueId">
                <option value="">Sélectionnez une marque</option>
                <?php foreach ($data['marques'] as $marque) { ?>
                <option value="<?=$marque['idMarque']?>"><?=$marque['nomMarque']?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-modele>
        </div>
    </form>

</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idModele">
        </div>
        <div>
            <label for="nomModele">Nom du modèle</label>
            <input type="text" name="nomModele" value="" required>
        </div>
        <div>
            <label for="marqueId">Marque</label>
            <select name="marqueId" id="marqueId">
                <option value="">Sélectionnez une marque</option>
                <?php foreach ($data['marques'] as $marque) { ?>
                <option value="<?=$marque['idMarque']?>"><?=$marque['nomMarque']?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <input type="hidden" name="visibilite" checked>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-modele>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idModele]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id;
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idModele]').innerHTML; 
            obtenirModeleAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirModeleAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let modeleDonnees = jsonResponse['modele'];
            console.log(modeleDonnees);
            
            formulaire.remplirFormulaire(modeleDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Voiture_AJAX&action=detailModeleJson&IdModele=${id}`, true);
    xhttp.send();    

}

function obtenirModelesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);
            console.log("modeles",jsonResponse);

            let table = document.querySelector("table tbody");
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let modele = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idModele>${ modele["idModele"]}</td>
                    <td>${ modele["nomModele"]}</td>
                    <td>${ modele["nomMarque"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=ModeleListeJson", true);
    xhttp.send();

}

function ajouterModeleAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test");
            obtenirModelesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutModele", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierModeleAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirModelesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=modifModele", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerModeleAJAX(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirModelesAJAX();
        }
    };
    console.log("id pour supprimer",id);
    xhttp.open("POST", "index.php?Voiture_AJAX&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=modele&id=${id}`);
}

let btnAjouterModele = document.querySelector("[data-js-btn-ajouter-modele]");
btnAjouterModele.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterModeleAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierModele = document.querySelector("[data-js-btn-modifier-modele]");
btnModifierModele.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierModeleAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerModeleAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>