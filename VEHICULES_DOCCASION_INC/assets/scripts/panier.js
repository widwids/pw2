class Panier {
    constructor(el) {
        this._el = el;

        this._articles = this._el.querySelector('[data-js-articles]');

        this._elBtn = this._el.querySelector('[data-js-button]');

        this._sousTotal = this._el.querySelector('[data-js-sousTotal]');

        this._panier = JSON.parse(sessionStorage.getItem('panier'));
        
        this.init();
    }

    init = () => {
        this._elBtn.addEventListener('click', this.commande);

        this.affichePanier();

        this.calculeTotal();
    }

    affichePanier = () => {
        let article = '';

        if(this._panier != '') {

            for (let item of this._panier) {
                article += `<article class="product">
                                <header>
                                    <img src="assets/images/${item.photo}.jpg" class="product-list__image">
                                </header>
                                <div class="details_container" data-js-voitureInfo>
                                    <p>${item.voiture.nomMarque} ${item.voiture.nomModele} ${item.voiture.anneeId}</p>
                                    <p>No de série : <span data-js-noSerie>${item.voiture.noSerie}</span></p>
                                    <p>Date arrivée : ${item.voiture.dateArrivee}</p>
                                    <p>Prix : ${(item.voiture.prixAchat * 1.25).toFixed(2)} $</p>
                                    <label for="depot">Dépôt</label>
                                    <input type="text" name="depot" data-js-depot><br><br>
                                    <button data-js-retirer>Retirer du panier</button>
                                </div>
                            </article><br>`;
            }
        }

        this._articles.innerHTML = article;

        let btnRetirer = this._articles.querySelectorAll('[data-js-retirer]');
        for (let bouton of btnRetirer) {
            bouton.addEventListener('click', this.retirePanier);
        }
    }

    commande = () => {
        let noSerieListe = this._articles.querySelectorAll('[data-js-noSerie]'),
            prixVente = this._el.querySelector('[data-js-total]').textContent,
            tabNoSerie = [];

        for (let noSerie of noSerieListe) {
            tabNoSerie.push(noSerie.innerHTML);
        }

        let paramNoSerie = encodeURIComponent(tabNoSerie),
            paramPrixVente = encodeURIComponent(prixVente);

        //Déclaration de l'objet XMLHttpRequest
        var xhr;
        xhr = new XMLHttpRequest();
        
        //Initialisation de la requête
        if (xhr) {	

            // Ouverture de la requête : fichier recherché
            xhr.open('POST', 'index.php?Commande&action=ajouterCommande');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.addEventListener('readystatechange', () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {

                        //Les données ont été reçues
                        //Traitement du DOM
                        sessionStorage.removeItem('panier');

                       
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send('&voitureId=' + paramNoSerie + '&prixVente=' + paramPrixVente);
        }
    }

    calculeTotal = () => {
        let sousTotal = 0;
        for (let item of this._panier) {
            sousTotal += item.voiture.prixAchat * 1.25;
        }

        this._sousTotal.innerHTML = sousTotal.toFixed(2);

        let tauxTaxe = this._el.querySelectorAll('[data-js-taux]'),
            total = this._el.querySelector('[data-js-total]'),
            montant = 0;

        for (let taux of tauxTaxe) {
            montant += parseFloat(taux.textContent/100);
        }

        montant = parseFloat(this._sousTotal.innerHTML) + this._sousTotal.innerHTML * montant;

        total.innerHTML = montant.toFixed(2);
    }

    retirePanier = (e) => {
        //Retirer du DOM
        e.target.parentNode.parentNode.remove();

        //Retirer du sessionStorage
        let noSerie = e.target.parentNode.querySelector('[data-js-noSerie]').textContent,
            nouveauPanier = [];
        
        for(let item of this._panier) {
            if(item.voiture.noSerie != noSerie)
                nouveauPanier.push(item);
        }

        sessionStorage.setItem('panier', JSON.stringify(nouveauPanier));

        this._panier = JSON.parse(sessionStorage.getItem('panier'))

        this.calculeTotal();
    }
}