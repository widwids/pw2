class Photos{
    constructor(el) {
        this._el = el
        this._elBtnenvoi = this._el.querySelector('[data-js-btn-soumettre]');
        this._elDivNSerie = this._el.querySelector('[data-js-nserie]');
        console.log(this._elBtnenvoi);
        
        this.init();
    }

    init = () => {
        
        this._elBtnenvoi.addEventListener('click', (e) => {
           /*  //e.preventDefault();
            var fileInputPrin = document.getElementById("imgPrincipale");
            var filesPrin = fileInputPrin.files;
            var imgPrincipale;
            imgPrincipale = filesPrin[0];
            var fileInput = document.getElementById("imgSecondaire");
            var files = fileInput.files;
            var imgSecondaire;
            var tabImgSecondaire = new Array();

            for (var i = 0; i < files.length; i++) {
                // on récupère le i-ème fichier
                imgSecondaire = files[i];
                tabImgSecondaire[i] = imgSecondaire.name;
            }
            if ((imgSecondaire) && (imgPrincipale)) {
                this.EnvoiPhotos(imgPrincipale,tabImgSecondaire);
            }else{
                if ((! imgSecondaire) && (! imgPrincipale)) {
                    console.log('vous devez choisir une image principale, et au moins une image secondaire')
                }else{
                    if (! imgPrincipale){
                        console.log('vous devez choisir une image principale')
                    }
                    if (! imgSecondaire){
                        console.log('vous devez choisir au moins, une image secondaire')
                    }
                }
            }  */

        }); 
    }

    /* EnvoiPhotos = (imgPrincipale,files) => { 
        let imgPrin = imgPrincipale.name;
        var tabImgSec = new Array();
        tabImgSec = files;

        let nSerie = this._elDivNSerie.dataset.jsNserie;

        console.log(nSerie);
        //let imgPrin = imgPrincipale.name;
        let params = `&imgPrin=${imgPrin}&imgSeco=${tabImgSec}&nSerie=${nSerie}`;

        var xhr;
        xhr = new XMLHttpRequest();

        if (xhr) {
            xhr.open("POST",'index.php?Voiture_AJAX&action=ajoutPhotosVoiture');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.addEventListener("readystatechange", () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });

            // Envoi de la requète
            xhr.send(params);
        }  
    }  */ 
}