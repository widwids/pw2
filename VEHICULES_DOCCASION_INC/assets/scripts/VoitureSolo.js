class VoitureSolo {
    constructor(el) {
        this._el = el;

        this._noSerie = this._el.querySelector('[data-js-noSerie]').textContent;

        this._btnReserver = this._el.querySelector('[data-js-reserver]');
        
        this.init();
    }

    init = () => {
        this._btnReserver.addEventListener("click", this.obtenirVoiture);
    }

    obtenirVoiture = () => {
        let noSerie = encodeURIComponent(this._noSerie),
            param = `&noSerie=${noSerie}`;

        //Déclaration de l'objet XMLHttpRequest
        var xhr;
        xhr = new XMLHttpRequest();
        
        //Initialisation de la requête
        if (xhr) {	

            // Ouverture de la requête : fichier recherché
            xhr.open('POST', 'index.php?Voiture_AJAX&action=detailVoitureJson');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.addEventListener('readystatechange', () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {

                        //Les données ont été reçues
                        this.ajoutePanier(JSON.parse(xhr.response));
                       
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send(param);
        }
    }

    ajoutePanier = (response) => {
        let voiture = response.voiture[0],
            photos = response.photos;

        for (let photo of photos) {
            if(photo.ordre == 1) {
                let photoPrincipale = photo.nomPhoto;
                sessionStorage.setItem('panier', JSON.stringify([{voiture: voiture, photo: photoPrincipale}]));
            }
        }
    }
}