class Panier {
    constructor(el) {
        this._el = el;

        this._articles = this._el.querySelector('[data-js-articles]');

        this._elBtn = this._el.querySelector('[data-js-button]');

        this._total = this._el.querySelector('[data-js-total]');

        this._panier = JSON.parse(sessionStorage.getItem('panier'));
        
        this.init();
    }

    init = () => {
        this._elBtn.addEventListener('click', this.commande);

        this.affichePanier();
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
                                    <p>No de série : ${item.voiture.noSerie}</p>
                                    <p>Date arrivée : ${item.voiture.dateArrivee}</p>
                                    <p>Prix : ${(item.voiture.prixAchat * 1.25).toFixed(2)} $</p>
                                    <label for="depot">Dépôt</label>
                                    <input type="text" name="depot" id="depot">
                                </div>
                            </article>`;
            }
        }

        this._articles.innerHTML = article;
    }

    commande = () => {
        this.calculeTotal();
    }

    calculeTotal = () => {
        let total = 0;
        for (let item of this._panier) {
            total += item.voiture.prixAchat * 1.25;
        }

        this._total.innerHTML = `Total : ${total.toFixed(2)}$`;
    }
}