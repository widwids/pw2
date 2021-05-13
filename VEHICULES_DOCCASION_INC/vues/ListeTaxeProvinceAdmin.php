
<section class="yu-section">

    <div class="yu-table-taxes-province yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter une taxe</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-taxes-province" data-component="Pagination">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom du province (fr)</th>
                <th>Nom du province (eng)</th>                
                <th>Nom du taxe (fr)</th>
                <th>Nom du taxe (eng)</th>
                <th>Taux</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data['taxeProvince'] as $taxeProvince) { ?>

        <tr>
            <td data-js-idProvince data-js-idTaxe="<?=$taxeProvince["idTaxe"]?>"><?= $taxeProvince["codeProvince"]?></td>
            <td><?= $taxeProvince["nomProvinceFR"]?></td>
            <td><?= $taxeProvince["nomProvinceEn"]?></td>            
            <td><?= $taxeProvince["nomTaxeFR"]?></td>
            <td><?= $taxeProvince["nomTaxeEN"]?></td>
            <td><?= $taxeProvince["taux"]?></td>
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
            <label for="provinceId">Province</label>
            <select name="provinceId" id="provinceId">
                <option value="">Sélectionnez un province</option>
                    <?php foreach($data["provinces"] as $province) { ?>

                        <option value="<?= $province["codeProvince"] ?>"><?= $province["nomProvinceFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="taxeId">Taxe</label>
            <select name="taxeId" id="taxeId">
                <option value="">Sélectionnez un taxe</option>
                    <?php foreach($data["taxes"] as $taxe) { ?>

                        <option value="<?= $taxe["idTaxe"] ?>"><?= $taxe["nomTaxeFR"]?></option>

                    <?php }?>
            </select>
        </div>                
        <div>
            <label for="taux">Taux</label>
            <input type="text" name="taux" required>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-taxeProvince>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="provinceId">Province</label>
            <select name="provinceId" id="provinceId">
                <option value="">Sélectionnez un province</option>
                    <?php foreach($data["provinces"] as $province) { ?>

                        <option value="<?= $province["codeProvince"] ?>"><?= $province["nomProvinceFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="taxeId">Taxe</label>
            <select name="taxeId" id="taxeId">
                <option value="">Sélectionnez un taxe</option>
                    <?php foreach($data["taxes"] as $taxe) { ?>

                        <option value="<?= $taxe["idTaxe"] ?>"><?= $taxe["nomTaxeFR"]?></option>

                    <?php }?>
            </select>
        </div>                
        <div>
            <label for="taux">Taux</label>
            <input type="text" name="taux" required>
        </div>
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-taxeProvince>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idProvince]').innerHTML;
            let idTaxe = evt.target.parentNode.parentNode.querySelector('[data-js-idProvince]').dataset.jsIdtaxe; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsIdt = idTaxe; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let idProvince = evt.target.parentNode.parentNode.querySelector('[data-js-idProvince]').innerHTML; 
            let idTaxe = evt.target.parentNode.parentNode.querySelector('[data-js-idProvince]').dataset.jsIdtaxe;
            obtenirTaxeProvinceAJAX(idProvince, idTaxe);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirTaxeProvinceAJAX(idProvince, idTaxe)
{

    let xhttp = new XMLHttpRequest(); console.log(idProvince, idTaxe);
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let taxeProvinceDonnees = jsonResponse['taxeProvince'];
            console.log("taxeProvinceDonnees",taxeProvinceDonnees);
            
            formulaire.remplirFormulaire(taxeProvinceDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=afficheTaxeProvinceAJAX&provinceId=${idProvince}&taxeId=${idTaxe}`, true);
    xhttp.send();    

}

function obtenirTaxeProvincesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['taxeProvince'];
            console.log("response all taxe-provinces",jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let taxeProvince = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idProvince data-js-idTaxe="${taxeProvince["idTaxe"]}">${ taxeProvince["codeProvince"]}</td>
                    <td>${ taxeProvince["nomProvinceFR"]}</td>
                    <td>${ taxeProvince["nomProvinceEn"]}</td>            
                    <td>${ taxeProvince["nomTaxeFR"]}</td>
                    <td>${ taxeProvince["nomTaxeEN"]}</td>
                    <td>${ taxeProvince["taux"]}</td>
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listeTaxeProvinceAJAX", true);
    xhttp.send();

}

function ajouterTaxeProvinceAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response ajouter", this.response);
            obtenirTaxeProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterTaxeProvince", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer les donnees sur serveur",formulaire.obtenirQueryString() );
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierTaxeProvinceAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirTaxeProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierTaxeProvince", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log("envoyer les donnees sur serveur", formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerTaxeProvinceAJAX(idP, idT)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response supprimer",this.response);
            obtenirTaxeProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppressionTaxeProvince", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log(idP,idT);
    xhttp.send(`provinceId=${idP}&taxeId=${idT}`);
}

let btnAjouterTaxeProvince = document.querySelector("[data-js-btn-ajouter-taxeProvince]");
btnAjouterTaxeProvince.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterTaxeProvinceAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierTaxeProvince = document.querySelector("[data-js-btn-modifier-taxeProvince]");
btnModifierTaxeProvince.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierTaxeProvinceAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerTaxeProvinceAJAX(evt.target.dataset.jsId, evt.target.dataset.jsIdt);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

