
<section class="yu-section">

    <div class="yu-table-pays yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter un pays</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-pays" data-component="Pagination">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom du pays en français</th>
                <th>Nom du pays en anglais</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data["pays"] as $pays) { ?>

        <tr>
            <td data-js-idPays><?= $pays["idPays"]?></td>
            <td><?= $pays["nomPaysFR"]?></td>
            <td><?= $pays["nomPaysEN"]?></td>
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
            <label for="nomPaysFR">Nom du pays en français</label>
            <input type="text" name="nomPaysFR" required>
        </div>
        <div>
            <label for="nomPaysEN">Nom du pays en anglais</label>
            <input type="text" name="nomPaysEN" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-pays>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idPays">
        </div>
        <div>
            <label for="nomPaysFR">Nom du pays en français</label>
            <input type="text" name="nomPaysFR" required>
        </div>
        <div>
            <label for="nomPaysEN">Nom du pays en anglais</label>
            <input type="text" name="nomPaysEN" required>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-pays>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idPays]').innerHTML; console.log(id);
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idPays]').innerHTML; 
            obtenirPaysAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirPaysAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let paysDonnees = jsonResponse['pays'];
            console.log("paysDonnees",paysDonnees);
            
            formulaire.remplirFormulaire(paysDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=affichePaysAJAX&idPays=${id}`, true);
    xhttp.send();    

}

function obtenirPayssAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['pays'];
            console.log(jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let pays = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idPays>${ pays["idPays"]}</td>
                    <td>${ pays["nomPaysFR"]}</td>
                    <td>${ pays["nomPaysEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
            let pagination = new Pagination(document.querySelector('table'));
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listePaysAJAX", true);
    xhttp.send();

}

function ajouterPaysAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("ajouter pays response",this.response);
            obtenirPayssAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterPays", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierPaysAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirPayssAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierPays", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer sur serveur",formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerPaysAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirPayssAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=pays&id=${id}`);
}

let btnAjouterPays = document.querySelector("[data-js-btn-ajouter-pays]");
btnAjouterPays.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterPaysAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierPays = document.querySelector("[data-js-btn-modifier-pays]");
btnModifierPays.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierPaysAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerPaysAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

