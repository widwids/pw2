class Panier {
    constructor(el) {
        this._el = el;

        this._articles = this._el.querySelector('[data-js-articles]');

        this._elBtn = this._el.querySelector('[data-js-caisse]');

        this._sousTotal = this._el.querySelector('[data-js-sousTotal]');

        this._panier = JSON.parse(sessionStorage.getItem('panier'));
        
        this.init();
    }

    init = () => {
        this._elBtn.addEventListener('click', this.afficheCaisse);

        if(this._panier == undefined || this._panier.length == 0) {
            this._el.innerHTML = `<h1>Panier</h1>
                                    <p>Votre panier est vide.</p>`;
        } else {
            this.affichePanier();

            this.calculeSousTotal();
        }
    }

    affichePanier = () => {
        let article = '';

        for (let item of this._panier) {
            article += `<article class="contenant">
                            <header>
                                <img src="assets/images/${item.photo}.jpg">
                            </header>
                            <main data-js-voitureInfo>
                                <p>${item.voiture.nomMarque} ${item.voiture.nomModele} ${item.voiture.anneeId}</p>
                                <p>No de série : <span data-js-noSerie>${item.voiture.noSerie}</span></p>
                                <p>Prix : <span data-js-prixVente>${(item.voiture.prixAchat * 1.25).toFixed(2)}</span>$</p>
                                <label for="depot">
                                    Réservez pour ${item.voiture.prixAchat * 0.10}$ (dépôt de 10%)    
                                </label>
                                <select name="depot" data-js-depot>
                                    <option value="" selected disabled>Choisir votre option</option>
                                    <option value=""></option>
                                    <option value="${item.voiture.prixAchat * 0.10}">Réserver</option>
                                </select>
                            </main>
                            <button data-js-retirer>Retirer du panier</button>
                        </article>
                        `;
        }
       
        this._articles.innerHTML = article;

        let btnRetirer = this._articles.querySelectorAll('[data-js-retirer]');
        for (let bouton of btnRetirer) {
            bouton.addEventListener('click', this.retirePanier);
        }
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

        this._panier = JSON.parse(sessionStorage.getItem('panier'));

        this.calculeSousTotal();
    }

    afficheCaisse = () => {
        if(! this._el.querySelector('[data-js-commande]')) {
            let choixConnecte = this._el.querySelector('[data-js-connecter]'),
                choixCree = this._el.querySelector('[data-js-creer]');

                this._el.querySelector('[data-js-choix]').style.display = 'block';
                this._el.querySelector('[data-js-caisse]').style.display = 'none';

                choixConnecte.addEventListener('click', this.afficheConnecte);
                choixCree.addEventListener('click', this.afficheCree);
        } else {
            this.calculeTotal();
            this._el.querySelector('[data-js-commande]').style.display = 'block';
            this._el.querySelector('[data-js-caisse]').style.display = 'none';

            this._el.querySelector('[data-js-button]').addEventListener('click', this.commande);
        }
    }

    calculeSousTotal = () => {
        let sousTotal = 0, tauxRevente = 1.25;
        for (let item of this._panier) {
            sousTotal += item.voiture.prixAchat * tauxRevente;
        }

        this._sousTotal.innerHTML = sousTotal.toFixed(2);
    }

    calculeTotal = () => {
        let tauxTaxe = this._el.querySelectorAll('[data-js-taux]'),
            total = this._el.querySelector('[data-js-total]'),
            montant = 0;

        for (let taux of tauxTaxe) {
            montant += parseFloat(taux.textContent/100);
        }

        montant = parseFloat(this._sousTotal.innerHTML) + this._sousTotal.innerHTML * montant;

        total.innerHTML = montant.toFixed(2);
    }

    commande = () => {
        let noSerieListe = this._articles.querySelectorAll('[data-js-noSerie]'),
            prixVentes = this._el.querySelectorAll('[data-js-prixVente]'),
            depots = this._articles.querySelectorAll('[data-js-depot]'),
            tabNoSerie = [], tabPrixVente = [], tabDepots = [];

        for (let noSerie of noSerieListe) {
            tabNoSerie.push(noSerie.innerHTML);
        }

        for (let prixVente of prixVentes) {
            tabPrixVente.push(prixVente.innerHTML);
        }

        for (let depot of depots) {
            tabDepots.push(depot.value);
        }

        let paramNoSerie = encodeURIComponent(tabNoSerie),
            paramPrixVente = encodeURIComponent(tabPrixVente),
            paramDepot;

        if(tabDepots.length == 0)
            paramDepot = null;
        else
            paramDepot = encodeURIComponent(tabDepots);

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
            xhr.send('&voitureId=' + paramNoSerie + '&prixVente=' + paramPrixVente + '&depot=' + paramDepot);
        }
    }

    afficheConnecte = (e) => {
        e.preventDefault();

        this._el.querySelector('[data-js-choix]').style.display = 'none';
        this._el.querySelector('[data-js-connexion]').style.display = 'block';
        this._el.querySelector('[data-js-creation]').style.display = 'none';

        this._el.querySelector('[data-js-btnConnexion]').addEventListener('click', this.connecte);
        this._el.querySelector('[data-js-retour]').addEventListener('click', this.afficheCree);
    }

    connecte = (e) => {
        e.preventDefault();

        let pseudonyme = this._el.querySelector('[data-js-pseudonyme]').value,
            motDePasse = this._el.querySelector('[data-js-motDePasse]').value,
            paramPseudonyme = encodeURIComponent(pseudonyme),
            paramMotDePasse = encodeURIComponent(motDePasse);

        //Déclaration de l'objet XMLHttpRequest
        var xhr;
        xhr = new XMLHttpRequest();
        
        //Initialisation de la requête
        if (xhr) {	

            // Ouverture de la requête : fichier recherché
            xhr.open('POST', 'index.php?Utilisateur&action=authentification');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.addEventListener('readystatechange', () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {

                        //Les données ont été reçues
                        //Traitement du DOM
                        this._el.querySelector('[data-js-connexion]').style.display = 'none';
                        this._el.querySelector('[data-js-creation]').style.display = 'none';
                        location.replace("index.php?Commande&action=affichePanier");
                         
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send('&pseudonyme=' + paramPseudonyme + '&motDePasse=' + paramMotDePasse + '&ajax=true');
        }
    }

    afficheCree = (e) => {
        e.preventDefault();

        this._el.querySelector('[data-js-choix]').style.display = 'none';
        this._el.querySelector('[data-js-connexion]').style.display = 'none';
        this._el.querySelector('[data-js-creation]').style.display = 'block';

        this._el.querySelector('[data-js-btnCreation]').addEventListener('click', this.creeCompte);
        this._el.querySelector('[data-js-retourConnecte]').addEventListener('click', this.afficheConnecte);
    }

    creeCompte = (e) => {
        e.preventDefault();

        let prenom = this._el.querySelector('[data-js-prenom]').value,
            nom = this._el.querySelector('[data-js-nom]').value,
            dateNaissance = this._el.querySelector('[data-js-date]').value,
            adresse = this._el.querySelector('[data-js-adresse]').value,
            codePostal = this._el.querySelector('[data-js-postal]').value,
            telephone = this._el.querySelector('[data-js-telephone]').value,
            cellulaire = this._el.querySelector('[data-js-cellulaire]').value,
            courriel = this._el.querySelector('[data-js-courriel]').value,
            pseudonyme = this._el.querySelector('[data-js-pseudo]').value,
            motDePasse = this._el.querySelector('[data-js-mdp]').value,
            villeId = this._el.querySelector('[data-js-ville]').value,
            paramPrenom = encodeURIComponent(prenom),
            paramNom = encodeURIComponent(nom),
            paramDateNaissance = encodeURIComponent(dateNaissance),
            paramAdresse = encodeURIComponent(adresse),
            paramCodePostal = encodeURIComponent(codePostal),
            paramTelephone = encodeURIComponent(telephone),
            paramCellulaire = encodeURIComponent(cellulaire),
            paramCourriel = encodeURIComponent(courriel),
            paramPseudonyme = encodeURIComponent(pseudonyme),
            paramMotDePasse = encodeURIComponent(motDePasse),
            paramVilleId = encodeURIComponent(villeId);

        //Déclaration de l'objet XMLHttpRequest
        var xhr;
        xhr = new XMLHttpRequest();
        
        //Initialisation de la requête
        if (xhr) {	

            // Ouverture de la requête : fichier recherché
            xhr.open('POST', 'index.php?Utilisateur&action=insereUtilisateur');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.addEventListener('readystatechange', () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {

                        //Les données ont été reçues
                        //Traitement du DOM
                        this._el.querySelector('[data-js-connexion]').style.display = 'none';
                        this._el.querySelector('[data-js-creation]').style.display = 'none';
                        location.replace("index.php?Commande&action=affichePanier");
                         
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send(
                '&prenom=' + paramPrenom +
                '&nom=' + paramNom +
                '&dateNaissance=' + paramDateNaissance +
                '&adresse=' + paramAdresse +
                '&codePostal=' + paramCodePostal +
                '&telephone=' + paramTelephone +
                '&cellulaire=' + paramCellulaire +
                '&courriel=' + paramCourriel +
                '&pseudonyme=' + paramPseudonyme + 
                '&motDePasse=' + paramMotDePasse + 
                '&villeId=' + paramVilleId +
                '&ajax=1'
            );
        }
    }
}