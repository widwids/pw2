
<section class="yu-section">

    <div class="yu-table-privilege yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter un privilège</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-privilege" data-component="Pagination">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Privilège (fr)</th>
                <th>Privilège (eng)</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data['privileges'] as $privilege) { ?>

        <tr>
            <td data-js-idPrivilege><?= $privilege["idPrivilege"]?></td>
            <td><?= $privilege["nomPrivilegeFR"]?></td>
            <td><?= $privilege["nomPrivilegeEN"]?></td>
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
            <label for="nomPrivilegeFR">Nom du privilège en français</label>
            <input type="text" name="nomPrivilegeFR" required>
        </div>
        <div>
            <label for="nomPrivilegeEN">Nom du privilège en anglais</label>
            <input type="text" name="nomPrivilegeEN" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-privilege>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idPrivilege">
        </div>
        <div>
            <label for="nomPrivilegeFR">Nom du privilège en français</label>
            <input type="text" name="nomPrivilegeFR" required>
        </div>
        <div>
            <label for="nomPrivilegeEN">Nom du privilège en anglais</label>
            <input type="text" name="nomPrivilegeEN" required>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-privilege>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idPrivilege]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idPrivilege]').innerHTML; 
            obtenirPrivilegeAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirPrivilegeAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let privilegeDonnees = jsonResponse['privilege'];
            console.log("privilegeDonnees",privilegeDonnees);
            
            formulaire.remplirFormulaire(privilegeDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=affichePrivilegeAJAX&idPrivilege=${id}`, true);
    xhttp.send();    

}

function obtenirPrivilegesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['privileges'];
            console.log(jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let privilege = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idPrivilege>${ privilege["idPrivilege"]}</td>
                    <td>${ privilege["nomPrivilegeFR"]}</td>
                    <td>${ privilege["nomPrivilegeEN"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listePrivilegesAJAX", true);
    xhttp.send();

}

function ajouterPrivilegeAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response ajouter", this.response);
            obtenirPrivilegesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterPrivilege", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer les donnees sur serveur",formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierPrivilegeAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirPrivilegesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierPrivilege", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer sur serveur",formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerPrivilegeAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirPrivilegesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=privilege&id=${id}`);
}

let btnAjouterPrivilege = document.querySelector("[data-js-btn-ajouter-privilege]");
btnAjouterPrivilege.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterPrivilegeAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierPrivilege = document.querySelector("[data-js-btn-modifier-privilege]");
btnModifierPrivilege.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierPrivilegeAJAX();
        yuModalModifier.style.width = "0";
    }

});

let btnOui = document.querySelector('.yu-modal-supprimer button[name="btnOui"]'); 
btnOui.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    supprimerPrivilegeAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";

});

</script>

