
<section class="yu-section">

    <div class="yu-table-ville yu-btn-ajouter-container">
    <button class="yu-btn-ajouter">Ajouter une ville</button>
    </div>

    <div class="yu-table-responsive">
    <table class="yu-table yu-table-ville" data-component="Pagination">
        
        <thead>
            <tr>
                <th>id</th>
                <th>Nom de la ville (fr)</th>
                <th>Nom de la ville (eng)</th>
                <th>Nom de la province (fr)</th>
                <th>Nom de la province (eng)</th>
                <th>Actions</th>
            </tr>
        </thead>

    <tbody>

    <?php foreach ($data['villes'] as $ville) { ?>

        <tr>
            <td data-js-idVille><?= $ville["idVille"]?></td>
            <td><?= $ville["nomVilleFR"]?></td>
            <td><?= $ville["nomVilleEN"]?></td>
            <td><?= $ville["nomProvinceFR"]?></td>
            <td><?= $ville["nomProvinceEN"]?></td>
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
            <label for="nomVilleFR">Nom de la ville en français</label>
            <input type="text" name="nomVilleFR" required>
        </div>
        <div>
            <label for="nomVilleEN">Nom de la ville en anglais</label>
            <input type="text" name="nomVilleEN" required>
        </div>
        <div>
            <label for="provinceCode">Province</label>
            <select name="provinceCode" id="provinceCode">
                <option value="">Sélectionnez une province</option>
                    <?php foreach($data["provinces"] as $province) { ?>

                        <option value="<?= $province["codeProvince"] ?>"><?= $province["nomProvinceFR"]?></option>

                    <?php }?>
            </select>            
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-ville>
        </div>
    </form>


</section>

<section class="yu-modal yu-modal-modifier">
    
    <button class="btn-ferme" data-js-btn-ferme-modifier>&times;</button>

    <form action="" method="post" class="yu-formulaire yu-modal-container">
        <div>            
            <input type="hidden" name="idVille">
        </div>
        <div>
            <label for="nomVilleFR">Nom de la ville en français</label>
            <input type="text" name="nomVilleFR" required>
        </div>
        <div>
            <label for="nomVilleEN">Nom de la ville en anglais</label>
            <input type="text" name="nomVilleEN" required>
        </div>
        <div>
            <label for="provinceCode">Province</label>
            <select name="provinceCode" id="provinceCode">
                <option value="">Sélectionnez une province</option>
                    <?php foreach($data["provinces"] as $province) { ?>

                        <option value="<?= $province["codeProvince"] ?>"><?= $province["nomProvinceFR"]?></option>

                    <?php }?>
            </select>            
        </div>        
        <div>
            <input type="submit" name="boutonModifier" value="Modifier" class="bouton-modifier" data-js-btn-modifier-ville>
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
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idVille]').innerHTML; 
            yuModalSupprimer.querySelector("[data-js-id]").dataset.jsId = id; 
            yuModalSupprimer.style.width = "100%";
        });
    }

    let btnsModifier = document.querySelectorAll(".yu-btn-modifier");
    for(let i = 0; i<btnsModifier.length; i++)
    {
        btnsModifier[i].addEventListener("click", (evt) => {
            let id = evt.target.parentNode.parentNode.querySelector('[data-js-idVille]').innerHTML; 
            obtenirVilleAJAX(id);
            yuModalModifier.style.width = "100%";
        });
    }

}

ajouterEvenements();

function obtenirVilleAJAX(id)
{

    let xhttp = new XMLHttpRequest();
    let formulaire = new GestionFormulaire(yuModalModifier);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response);             
            let villeDonnees = jsonResponse['ville'];
            console.log("villeDonnees",villeDonnees);
            
            formulaire.remplirFormulaire(villeDonnees);           
        }
        };

    xhttp.open("GET", `index.php?Utilisateur&action=afficheVilleAJAX&idVille=${id}`, true);
    xhttp.send();    

}

function obtenirVillesAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['villes'];
            console.log(jsonResponse);

            let table = document.querySelector("table tbody"); 
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let ville = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td data-js-idVille>${ ville["idVille"]}</td>
                    <td>${ ville["nomVilleFR"]}</td>
                    <td>${ ville["nomVilleEN"]}</td>
                    <td>${ ville["nomProvinceFR"]}</td>
                    <td>${ ville["nomProvinceEN"]}</td>                    
                    <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
                </tr>
                `;                
            }     
            
            ajouterEvenements();

            let pagination = new Pagination(document.querySelector('table'));
            
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listeVillesAJAX", true);
    xhttp.send();

}

function ajouterVilleAJAX()
{
    let formulaire = new GestionFormulaire(yuModalAjouter);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response ajouter", this.response);
            obtenirVillesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=ajouterVille", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); console.log(formulaire.obtenirQueryString());
    xhttp.send(formulaire.obtenirQueryString());
}

function modifierVilleAJAX()
{
    let formulaire = new GestionFormulaire(yuModalModifier);

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response modifier",this.response);
            obtenirVillesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=modifierVille", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xhttp.send(formulaire.obtenirQueryString());
}

function supprimerVilleAJAX(id)
{
    let xhttp = new XMLHttpRequest(); 

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            obtenirVillesAJAX();
        }
    };

    xhttp.open("POST", "index.php?Utilisateur&action=suppression", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`nomTable=ville&id=${id}`);
}

let btnAjouterVille = document.querySelector("[data-js-btn-ajouter-ville]");
btnAjouterVille.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalAjouter);
    if(gestionFormulaire.valide())
    {
        ajouterVilleAJAX();
        yuModalAjouter.style.width = "0";
    }

});

let btnModifierVille = document.querySelector("[data-js-btn-modifier-ville]");
btnModifierVille.addEventListener("click", (evt) => {

    evt.preventDefault();
    let gestionFormulaire = new GestionFormulaire(yuModalModifier);
    if(gestionFormulaire.valide())
    {
        modifierVilleAJAX();
        yuModalModifier.style.width = "0";
    }

});

let formSupprimer = document.querySelector('.yu-modal-supprimer form'); 
formSupprimer.addEventListener("click", (evt) => {

    evt.preventDefault(); 
    if(evt.target.name == "btnOui"){
    supprimerVilleAJAX(evt.target.dataset.jsId);
    yuModalSupprimer.style.width = "0";
    }else if(evt.target.name == "btnNon") yuModalSupprimer.style.width = "0";

});

</script>

