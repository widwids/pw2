
<section class="yu-section">

    <div class="yu-table-taxes yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter une taxe</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-taxes" data-component="Pagination">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom de la taxe (fr)</th>
                <th>Nom de la taxe (eng)</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data['taxes'] as $taxe) { ?>

        <tr>
            <td data-js-idTaxe><?= $taxe["idTaxe"]?></td>
            <td><?= $taxe["nomTaxeFR"]?></td>
            <td><?= $taxe["nomTaxeEN"]?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>
    
    <?php }?>

    </tbody>

    </table>
    </div>

</section>

<section class="yu-modal yu-modal-ajouter">
    
    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <input type="hidden" name="idTaxe">
        </div>
        <div>
            <label for="nomTaxeFR">Nom de la taxe en français</label>
            <input type="text" name="nomTaxeFR" required>
        </div>
        <div>
            <label for="nomTaxeEN">Nom de la taxe en anglais</label>
            <input type="text" name="nomTaxeEN" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-taxe>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idTaxe">
        </div>
        <div>
            <label for="nomTaxeFR">Nom de la taxe en français</label>
            <input type="text" name="nomTaxeFR" required>
        </div>
        <div>
            <label for="nomTaxeEN">Nom de la taxe en anglais</label>
            <input type="text" name="nomTaxeEN" required>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-taxe>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idTaxe]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idTaxe]').innerHTML; 
            obtenirTaxeAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirTaxeAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let taxeDonnees = jsonResponse['taxe'];
            console.log("taxeDonnees",taxeDonnees);
            
            formulaire.remplirFormulaire(taxeDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=afficheTaxeAJAX&idTaxe=${id}`, true);
    xhttp.send();    

}

function obtenirTaxesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['taxes'];
            console.log("response all taxes",jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let taxe = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idTaxe>${ taxe["idTaxe"]}</td>
                    <td>${ taxe["nomTaxeFR"]}</td>
                    <td>${ taxe["nomTaxeEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
            let pagination = new Pagination(document.querySelector('table'));
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listeTaxesAJAX", true);
    xhttp.send();

}

function ajouterTaxeAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response ajouter", this.response);
            obtenirTaxesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterTaxe", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer les donnees sur serveur",formulaire.obtenirQueryString() );
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierTaxeAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirTaxesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierTaxe", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerTaxeAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirTaxesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=taxe&id=${id}`);
}

let btnAjouterTaxe = document.querySelector("[data-js-btn-ajouter-taxe]");
btnAjouterTaxe.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterTaxeAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierTaxe = document.querySelector("[data-js-btn-modifier-taxe]");
btnModifierTaxe.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierTaxeAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerTaxesAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

