
<section class="yu-section">

    <div class="yu-table-groupeMP yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter groupe motopropulseur</button>
    </div>

    <table class="yu-table yu-table-groupeMP">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom motopropulseur</th>
                <th>Visibilité</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data as $groupeMP) { ?>

        <tr>
            <td data-js-idMotopro><?= $groupeMP["idMotopro"]?></td>
            <td><?= $groupeMP["nomMotopro"]?></td>
            <td><?= ($groupeMP["visibilite"] ==1) ? "OUI" : "NON" ?></td>
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
            <label for="nomMotopro">Nom de motopropulseur</label>
            <input type="text" name="nomMotopro">
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-mp>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idMotopro">
        </div>
        <div>
            <label for="nomMotopro">Nom de motopropulseur</label>
            <input type="text" name="nomMotopro">
        </div>
        <div class="yu-checkbox">
            <label for="visibilite">Visibilité</label>
            <input type="checkbox" name="visibilite" value="1">		
	    </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-mp>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idMotopro]').innerHTML; console.log(id);
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idMotopro]').innerHTML; 
            obtenirMPAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirMPAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let motoproDonnees = jsonResponse['motopro'];
            console.log("motoproDonnees",motoproDonnees);
            
            formulaire.remplirFormulaire(motoproDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Voiture_AJAX&action=detailGroupeMPJson&idMotopro=${id}`, true);
    xhttp.send();    

}

function obtenirMPsAJAX()
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
                let groupeMP = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idMotopro>${ groupeMP["idMotopro"]}</td>
                    <td>${ groupeMP["nomMotopro"]}</td>
                    <td>${ (groupeMP["visibilite"] ==1) ? "OUI" : "NON" }</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
        }
        };

    xhttp.open("GET", "index.php?Voiture_AJAX&action=ListeGroupeMPJson", true);
    xhttp.send();

}

function ajouterMPAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test");
            obtenirMPsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutMotoProp", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierMPAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirMPsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=modifMotoProp", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerMPAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirMPsAJAX();
        }
    };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=motopropulseur&id=${id}`);
}

let btnAjouterVoiture = document.querySelector("[data-js-btn-ajouter-mp]");
btnAjouterVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    ajouterMPAJAX();
    yuModalAjouter.style.width = "0";

});

let btnModifierVoiture = document.querySelector("[data-js-btn-modifier-mp]");
btnModifierVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();
    modifierMPAJAX();
    yuModalModifier.style.width = "0";

});

let btnOui = document.querySelector('.yu-modal-supprimer button[name="btnOui"]'); 
btnOui.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    supprimerMPAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";

});

</script>

