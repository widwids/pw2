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
                            <div class="gauche">
                                <img src="assets/images/${item.photo}.jpg">
                            </div>
                            <div class="milieu" data-js-voitureInfo>
                                <p>${item.voiture.nomMarque} ${item.voiture.nomModele} ${item.voiture.anneeId}</p>
                                <p>No de série : <span data-js-noSerie>${item.voiture.noSerie}</span></p>
                                <p>Prix : <span data-js-prixVente>${(item.voiture.prixAchat * 1.25).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ")}</span>$</p>
                                <label for="depot">
                                    Réservez pour ${(item.voiture.prixAchat * 1.25 * 0.10).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ")}$ (dépôt de 10%)    
                                </label>
                                <select name="depot" data-js-depot>
                                    <option value="0" selected disabled>Choisir votre option</option>
                                    <option value="0"></option>
                                    <option value="${(item.voiture.prixAchat * 1.25 * 0.10).toFixed(2)}">Réserver</option>
                                </select>
                            </div>
                            <div class="droite">
                                <button data-js-retirer>Retirer du panier</button>
                            </div>
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
        this._el.querySelector('[data-js-caisse]').style.display='none';

        if(! this._el.querySelector('[data-js-commande]')) {
            let choixConnecte = this._el.querySelector('[data-js-connecter]'),
                choixCree = this._el.querySelector('[data-js-creer]');

                this._el.querySelector('[data-js-choix]').classList.remove('hidden');
                this._el.querySelector('[data-js-choix]').classList.add('choix');

                choixConnecte.addEventListener('click', this.afficheConnecte);
                choixCree.addEventListener('click', this.afficheCree);
        } else {
            this.calculeTotal();
            this._el.querySelector('[data-js-commande]').classList.remove('hidden');
            this._el.querySelector('[data-js-button]').addEventListener('click', this.commande);
        }
    }

    calculeSousTotal = () => {
        let sousTotal = 0, tauxRevente = 1.25;
        for (let item of this._panier) {
            sousTotal += item.voiture.prixAchat * tauxRevente;
        }

        this._sousTotal.innerHTML = sousTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    calculeTotal = () => {
        let tauxTaxe = this._el.querySelectorAll('[data-js-taux]'),
            total = this._el.querySelector('[data-js-total]'),
            montant = 0;

        for (let taux of tauxTaxe) {
            montant += parseFloat(taux.textContent/100);
        }

        let sousTotal = this._sousTotal.innerHTML.replace(/\s/g, '');
        
        montant = parseInt(sousTotal) + (sousTotal * montant);

        total.innerHTML = montant.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    commande = () => {
        let noSerieListe = this._articles.querySelectorAll('[data-js-noSerie]'),
            prixVentes = this._el.querySelectorAll('[data-js-prixVente]'),
            depots = this._articles.querySelectorAll('[data-js-depot]'),
            expeditionId = this._el.querySelector('[data-js-expedition]').value,
            modePaiementNo = this._el.querySelector('[data-js-modePaiement]').value,
            tabNoSerie = [], tabPrixVente = [], tabDepots = [];

        for (let noSerie of noSerieListe) {
            tabNoSerie.push(noSerie.innerHTML);
        }

        for (let prixVente of prixVentes) {
            tabPrixVente.push(prixVente.innerHTML.replace(/\s/g, ''));
        }

        for (let depot of depots) {
            tabDepots.push(depot.value);
        }

        let paramNoSerie = encodeURIComponent(tabNoSerie),
            paramPrixVente = encodeURIComponent(tabPrixVente),
            paramDepot = encodeURIComponent(tabDepots),
            paramExpedition = encodeURIComponent(expeditionId),
            paramModePaiement = encodeURIComponent(modePaiementNo);

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

                        this._el.querySelector('[data-js-confirmer]').classList.remove('hidden');
                        this._el.querySelector('[data-js-panier]').classList.add('hidden');
                        this._el.querySelector('[data-js-commande]').classList.add('hidden');

                        setTimeout(function(){
                            window.location.href = 'index.php?Voiture&action=politiques';
                        }, 2000);
                       
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            //Envoi de la requête
            xhr.send('&voitureId=' + paramNoSerie + 
                    '&prixVente=' + paramPrixVente + 
                    '&depot=' + paramDepot +
                    '&expeditionId=' + paramExpedition +
                    '&modePaiementNo=' + paramModePaiement
                    );
        }
    }

    afficheConnecte = (e) => {
        e.preventDefault();

        this._el.querySelector('[data-js-choix]').classList.add('hidden');
        this._el.querySelector('[data-js-choix]').classList.remove('choix');
        this._el.querySelector('[data-js-connexion]').classList.remove('hidden');
        this._el.querySelector('[data-js-creation]').classList.add('hidden');

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
                        this._el.querySelector('[data-js-connexion]').classList.add('hidden');
                        this._el.querySelector('[data-js-creation]').classList.add('hidden');
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

        this._el.querySelector('[data-js-choix]').classList.add('hidden');
        this._el.querySelector('[data-js-connexion]').classList.add('hidden');
        this._el.querySelector('[data-js-creation]').classList.remove('hidden');

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
                        this._el.querySelector('[data-js-connexion]').classList.add('hidden');
                        this._el.querySelector('[data-js-creation]').classList.add('hidden');
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