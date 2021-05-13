class Filtre {
    constructor(el) {
        this._el = el;

        this._elOptions = this._el.querySelectorAll('option');

        this.init();
    }

    init = () => {
        for(let option of this._elOptions) {
            if(!option.disabled)
                option.parentNode.addEventListener('change', this.afficheVoitures);
        }
    }

    afficheVoitures = (e) => {
        let filtre = e.target.value,
            nomFiltre = e.target.dataset.jsFiltre,
            ordre = nomFiltre;

        if(nomFiltre == 'prixAchat') {
            ordre = filtre;
            filtre = '%';
        }
        
        let paramFiltre = encodeURIComponent(filtre),
            paramNomFiltre = encodeURIComponent(nomFiltre),
            paramOrdre = encodeURIComponent(ordre);

        //Déclaration de l'objet XMLHttpRequest
        var xhr;
        xhr = new XMLHttpRequest();
        
        //Initialisation de la requête
        if (xhr) {	

            // Ouverture de la requête : fichier recherché
            xhr.open('POST', 'index.php?Voiture_AJAX&action=listeOrdonnee');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.addEventListener('readystatechange', () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {

                        //Les données ont été reçues
                        //Traitement du DOM
                        let voitures = JSON.parse(xhr.responseText),
                            listeVoitures = document.querySelector('[data-js-voitures]');
                        
                        listeVoitures.innerHTML = '';

                        for (let voiture of voitures) {
                            listeVoitures.innerHTML += `
                            <a href="index.php?Voiture&action=detailVoiture&noSerie=${voiture.noSerie}">
                                <div class="product-card" data-js-inventaire="" data-js-produits="">
                                    <div class="product-image">
                                        <img src="assets/images/${voiture.nomPhoto}.jpg" class="product-list__image">
                                    </div>                
                                    <div class=product-info>
                                        <!-- <p>${voiture.noSerie}</p>  -->
                                        <h3>${voiture.nomMarque} ${voiture.nomModele} ${voiture.anneeId}</h3>
                                        <small>
                                            <li>${voiture.nomCorpsFR}</li>
                                            <li>${voiture.kilometrage} Km</li>
                                            <li>Carburant: ${voiture.typeCarburantFR}</li>
                                            <li>Traction: ${voiture.nomMotopro}</li>
                                            <li>Transmission: ${voiture.nomTransmissionFR}</li>
                                            <li>No de série: <span data-js-noSerie>${voiture.noSerie}</span></li>
                                            <li>Date d'arrivée: ${voiture.dateArrivee}</li>
                                        </small>
                                        <h2>${(voiture.prixAchat * 1.25).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")} $</h2>
                                    </div> 
                                </div>
                            </a>`;
                        }

                        if(listeVoitures.innerHTML == '') listeVoitures.innerHTML = '<p>Pas de résultats.</p>';

                        for(let select of this._el.children) {
                            select[0].selected = true;
                        }
                       
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send('&nomFiltre=' + paramNomFiltre + '&filtre=' + paramFiltre + '&ordre=' + paramOrdre);
        }
        
    }
}