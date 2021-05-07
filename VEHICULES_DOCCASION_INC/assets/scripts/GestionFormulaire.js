class GestionFormulaire{
    constructor(el)
    {
        this._el = el.querySelector('form');
        this.inputs = this._el.querySelectorAll('input');
        this.textareas = this._el.querySelectorAll('textarea'); 
        this.selects = this._el.querySelectorAll('select');

        this.nSerie = this._el.querySelector("[data-js-nserie]");
        this.imgPrincipale = this._el.querySelector("#imgPrincipale");
        this.imgSecondaire = this._el.querySelector("#imgSecondaire"); console.log(this.nSerie, this.imgPrincipale, this.imgSecondaire);
        
    }


    obtenirQueryString = () => 
    {
        let query = this.inputs[0].name+"="+this.inputs[0].value;
        for(let i=1; i < this.inputs.length; i++)
        {
            let input = this.inputs[i]; 
            if(input.name != "visibilite")
            {
                query += "&" + input.name + "=" + input.value;
            }else{                
                query += "&" + input.name + "=" + (input.checked == true ? "1" : "0");
            }            
            
        }

        for(let i=0; i < this.textareas.length; i++)
        {
            let textarea = this.textareas[i];
            query += "&" + textarea.name + "=" + textarea.value;
        }

        for(let i=0; i < this.selects.length; i++)
        {
            let select = this.selects[i];
            query += "&" + select.name + "=" + select.value;
        }

        return query;

    }

    remplirFormulaire = (data) => 
    {
        for (const [key, value] of Object.entries(data)) {
            try
            {
                this._el.querySelector(`input[name='${key}']`).value = value;
            }
            catch(err) {
                //console.log(err.message);
            }

            try
            {
                this._el.querySelector(`textarea[name='${key}']`).value = value;
            }
            catch(err) {
               //console.log(err.message);
            }

            try
            {
                this._el.querySelector(`select[name='${key}'] option[value='${value}']`).selected = true;
            }
            catch(err) {
                //console.log(err.message);
            }     
            
            try
            {
                if(key == "visibilite" && value == "1")
                this._el.querySelector(`input[name='${key}']`).checked = true;
            }
            catch(err) {
                //console.log(err.message);
            }  

        }
    }

    viderFormulaire = () =>
    {

        for(let i=0; i < this.inputs.length; i++)
        {
            this.inputs[i].value = "";
        }

        for(let i=0; i < this.textareas.length; i++)
        {
            this.textareas[i].value = "";            
        }

        for(let i=0; i < this.selects.length; i++)
        {
            this.selects[i].value = "";
        }     

    }

    envoyerPhotos = () =>
    {
        var formData = new FormData();
        formData.append('imgPrincipale', this.imgPrincipale.files[0]);

        for(var i=0; i<this.imgSecondaire.files.length; i++){
            formData.append("imgSecondaire[]", this.imgSecondaire.files[i]);
        }

        formData.append("nSerie", this.nSerie.value);

        var xhr;
        xhr = new XMLHttpRequest();

        if (xhr) {
            xhr.open("POST",'index.php?Voiture_AJAX&action=ajoutPhotosVoiture');
            // xhr.setRequestHeader('Content-Type', 'multipart/form-data');
            
            xhr.addEventListener("readystatechange", () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });
        }

            // Envoi de la requète
        xhr.send(formData);
    }
}