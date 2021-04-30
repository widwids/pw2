
<section class="yu-section">

    <div class="yu-table-btn-ajouter">
        <button class="yu-btn-ajouter">Ajouter un véhicule</button>
    </div>

    <table class="yu-table yu-table-voiture">
        
        <tr>
            <th>Photo</th>
            <th>№ Série</th>
            <th>Kilométrage</th>
            <th>Date Arrivée</th>
            <th>Prix Achat</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Année</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($data["voitures"] as $voiture) { ?>

        <tr>
            <td class="yu-image"><img src="./assets/images/<?= $voiture["nomPhoto"] ?>.jpg" alt="car"></td>
            <td><?= $voiture["noSerie"]?></td>
            <td><?= $voiture["kilometrage"] ?></td>
            <td><?= $voiture["dateArrivee"]?></td>
            <td><?= $voiture["prixAchat"]?></td>
            <td><?= $voiture["nomMarque"]?></td>
            <td><?= $voiture["nomModele"]?></td>
            <td><?= $voiture["anneeId"]?></td>
            <td><button class="yu-btn-modifier yu-btn">Modifier</button><button class="yu-btn-supprimer yu-btn">Supprimer</button></td>
        </tr>

            
        <?php }?>




    </table>

</section>


<section class="yu-modal yu-modal-ajouter">
    
    <button class="btn-ferme" data-js-btn-ferme-ajouter>&times;</button>

    <form action="index.php?Voiture&action=ajoutVoiture" method="post" class="yu-formulaire yu-modal-container">
        <div>
            <label for="noSerie">№ Série</label>
            <input type="text" name="noSerie" value="">
        </div>
        <div>
            <label for="descriptionFR">Description Français</label>
            <textarea name="descriptionFR" id="descriptionFR" cols="30" rows="10"></textarea>
        </div>
        <div>
            <label for="descriptionEN">Description Anglais</label>
            <textarea name="descriptionEN" id="descriptionEN" cols="30" rows="10"></textarea>
        </div>
        <div class="yu-checkbox">
            <label for="visibilite">Visibilité</label>
            <input type="checkbox" name="visibilite" value="oui">		
        </div>
        <div>
            <label for="kilometrage">Kilométrage</label>
            <input type="number" name="kilometrage" value="">
        </div>
        <div>
            <label for="dateArrivee">Date Arrivée</label>
            <input type="date" name="dateArrivee" id="dateArrivee">
        </div>
        <div>
            <label for="prixAchat">Prix Achat</label>
            <input type="number" name="prixAchat" id="prixAchat">
        </div>
        <div>
            <label for="groupeMPid">Group MP</label>
            <select name="groupeMPid" id="groupeMPid">
                <option value="">Sélectionnez un groupe MP</option>
                    <?php foreach($data["motopropulseur"] as $groupeMP) { ?>

                        <option value="<?= $groupeMP["idMotopro"] ?>"><?= $groupeMP["nomMotopro"]?></option>

                    <?php }?>
            </select>
        </div>
            <label for="corpsId">Corps</label>
            <select name="corpsId" id="corpsId">
                <option value="">Sélectionnez un corps</option>
                    <?php foreach($data["corps"] as $corp) { ?>

                        <option value="<?= $corp["idCorps"] ?>"><?= $corp["nomCorpsFR"]?></option>

                    <?php }?>
            </select>
        <div>
            <label for="carburantId">Carburant</label>
            <select name="carburanstsId" id="carburantId">
                <option value="">Sélectionnez un carburant</option>
                    <?php foreach($data["carburant"] as $carburant) { ?>

                        <option value="<?= $carburant["idCarburant"] ?>"><?= $carburant["typeCarburantFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="modeleId">Modèle</label>
            <select name="modeleId" id="modeleId">
                <option value="">Sélectionnez un modèle</option>
                    <?php foreach($data["modele"] as $modele) { ?>

                        <option value="<?= $modele["idModele"] ?>"><?= $modele["nomModele"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="transmissionId">Transmission</label>
            <select name="transmissionId" id="transmissionId">
                <option value="">Sélectionnez une transmission</option>
                    <?php foreach($data["transmission"] as $transmission) { ?>

                        <option value="<?= $transmission["idTransmission"] ?>"><?= $transmission["nomTransmissionFR"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <label for="anneeId">Année</label>
            <select name="anneeId" id="anneeId">
                <option value="">Sélectionnez une année</option>
                    <?php foreach($data["annee"] as $annee) { ?>

                        <option value="<?= $annee["annee"] ?>"><?= $annee["annee"]?></option>

                    <?php }?>
            </select>
        </div>
        <div>
            <input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter" data-js-btn-ajouter-voiture>
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
            <button type="submit" name="btnOui" value="Oui" class="yu-btn yu-btn-supprimer">Oui</button>
            <button type="submit" name="btnNon" value="Non" class="yu-btn yu-btn-modifier">Non</button>
        </div>
    </form>
</section>


<script>

let yuModalAjouter = document.querySelector(".yu-modal-ajouter"); 
let btnFermeAjouter = document.querySelector("[data-js-btn-ferme-ajouter]"); 
btnFermeAjouter.addEventListener("click", () => { yuModalAjouter.style.width = "0" });


let btnAjouter = document.querySelector(".yu-btn-ajouter"); 
btnAjouter.addEventListener("click", () => {
    yuModalAjouter.style.width = "100%";    
});

let yuModalSupprimer = document.querySelector(".yu-modal-supprimer"); 
let btnFermeSupprimer = document.querySelector("[data-js-btn-ferme-supprimer]"); 
btnFermeSupprimer.addEventListener("click", () => { yuModalSupprimer.style.width = "0" });


let btnsSupprimer = document.querySelectorAll(".yu-btn-supprimer"); 
for(let i = 0; i<btnsSupprimer.length; i++)
{
    btnsSupprimer[i].addEventListener("click", () => {
        yuModalSupprimer.style.width = "100%";
    });
}






let btnAjouterVoiture = document.querySelector("[data-js-btn-ajouter-voiture]");
btnAjouterVoiture.addEventListener("click", (evt) => {

    evt.preventDefault();

    let formulaire = new FormulaireAjouterVoiture(yuModalAjouter);
    console.log(formulaire.obtenirQueryString());

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {                
            console.log(this.response);
          }
        };

    xhttp.open("POST", "index.php?Voiture_AJAX&action=ajoutVoiture", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formulaire.obtenirQueryString());
    

});









</script>
