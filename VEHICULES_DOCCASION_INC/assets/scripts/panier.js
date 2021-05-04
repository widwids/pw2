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
                                    <input type="text" name="depot"><br><br>
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
        this.calculeTotal();

        
    }

    calculeTotal = () => {
        let total = 0;
        for (let item of this._panier) {
            total += item.voiture.prixAchat * 1.25;
        }

        this._sousTotal.innerHTML = `Sous-total : ${total.toFixed(2)}$`;
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