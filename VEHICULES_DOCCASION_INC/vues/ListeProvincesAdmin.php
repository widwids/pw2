
<section class="yu-section">

    <div class="yu-table-pays yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter une province</button>
    </div>

    <div class="yu-table-responsivev">
    <table class="yu-table yu-table-pays">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom du province (fr)</th>
                <th>Nom du province (eng)</th>
                <th>Nom du pays (fr)</th>
                <th>Nom du pays (eng)</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data['provinces'] as $province) { ?>

        <tr>
            <td data-js-idProvince><?= $province["codeProvince"]?></td>
            <td><?= $province["nomProvinceFR"]?></td>
            <td><?= $province["nomProvinceEN"]?></td>
            <td><?= $province["nomPaysFR"]?></td>
            <td><?= $province["nomPaysEN"]?></td>
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
            <label for="codeProvince">Nom du province en français</label>
            <input type="text" name="codeProvince" required>
        </div>
        <div>
            <label for="nomProvinceFR">Nom du province en français</label>
            <input type="text" name="nomProvinceFR" required>
        </div>
        <div>
            <label for="nomProvinceEN">Nom du province en anglais</label>
            <input type="text" name="nomProvinceEN" required>
        </div>
        <div>
            <label for="paysId">Province</label>
            <select name="paysId" id="paysId">
                <option value="">Sélectionnez un pays</option>
                    <?php foreach($data["pays"] as $pays) { ?>

                        <option value="<?= $pays["idPays"] ?>"><?= $pays["nomPaysFR"]?></option>

                    <?php }?>
            </select>            
        </div>                
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-province>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="codeProvince">
        </div>
        <div>
            <label for="nomProvinceFR">Nom du province en français</label>
            <input type="text" name="nomProvinceFR">
        </div>
        <div>
            <label for="nomProvinceEN">Nom du province en anglais</label>
            <input type="text" name="nomProvinceEN">
        </div>
        <div>
            <label for="paysId">Province</label>
            <select name="paysId" id="paysId">
                <option value="">Sélectionnez un pays</option>
                    <?php foreach($data["pays"] as $pays) { ?>

                        <option value="<?= $pays["idPays"] ?>"><?= $pays["nomPaysFR"]?></option>

                    <?php }?>
            </select>            
        </div>         
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-province>
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
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idProvince]').innerHTML; 
            obtenirProvinceAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirProvinceAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let provinceDonnees = jsonResponse['province'];
            console.log("provinceDonnees",provinceDonnees);
            
            formulaire.remplirFormulaire(provinceDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=afficheProvinceAJAX&codeProvince=${id}`, true);
    xhttp.send();    

}

function obtenirProvincesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['provinces'];
            console.log("reponse all provinces",jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let province = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idProvince>${ province["codeProvince"]}</td>
                    <td>${ province["nomProvinceFR"]}</td>
                    <td>${ province["nomProvinceEN"]}</td>
                    <td>${ province["nomPaysFR"]}</td>
                    <td>${ province["nomPaysEN"]}</td>                    
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();
            
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listeProvincesAJAX", true);
    xhttp.send();

}

function ajouterProvinceAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("reponse ajouter",this.response);
            obtenirProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterProvince", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log(formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierProvinceAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            obtenirProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierProvince", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerProvinceAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirProvincesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=province&id=${id}`);
}

let btnAjouterProvince = document.querySelector("[data-js-btn-ajouter-province]");
btnAjouterProvince.addEventListener("click", (evt) => {

    evt.preventDefault();
    ajouterProvinceAJAX();
    yuModalAjouter.style.width = "0";

});

let btnModifierProvince = document.querySelector("[data-js-btn-modifier-province]");
btnModifierProvince.addEventListener("click", (evt) => {

    evt.preventDefault();
    modifierProvinceAJAX();
    yuModalModifier.style.width = "0";

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerProvinceAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

