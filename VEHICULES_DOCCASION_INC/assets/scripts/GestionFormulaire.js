class GestionFormulaire{
    constructor(el)
    {
        this._modal = el;
        this._el = el.querySelector('form');
        this.inputs = this._el.querySelectorAll('input');
        this.textareas = this._el.querySelectorAll('textarea'); 
        this.selects = this._el.querySelectorAll('select');

        this.nSerie = this._el.querySelector("[data-js-nserie]");
        this.imgs = this._el.querySelectorAll(".yu-file input");        
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

    showImage = (src, target) => {
        var fr=new FileReader();
        fr.onload = function(e) { target.src = e.target.result; };
        fr.readAsDataURL(src.files[0]); 
    }

    remplirPhotosFormulaire = (data) =>
    {
        this._el.querySelector("[data-js-photos]").innerHTML = "";

        for(let i=0; i<data.length; i++)
        {       
            let photo = document.createElement("div");
            photo.classList.add("yu-file");
            photo.innerHTML = 
            `
                <label>Photo principale</label>
                <label for="imgPrincipale${data[i]['idPhoto']}">Sélectionnez une image</label>
                <input type="file" id="imgPrincipale${data[i]['idPhoto']}" name="imgPrincipale" accept=".jpg, .jpeg" data-js-ordre="${i+1}">
                <div class="yu-image-container"> <img src="./assets/images/${data[i]['nomPhoto']}.jpg"> </div>
            `;
            this._el.querySelector("[data-js-photos]").append(photo);
            this._el.addEventListener("change", (evt) => 
            {console.log(evt.target.type);
                if(evt.target.type == "file"){
                    let filename = evt.target.value.split(/(\\|\/)/g).pop();
                    evt.target.previousElementSibling.innerHTML = filename;
          
                    this.showImage(evt.target, evt.target.parentNode.querySelector("img"));
            
                }
            });  
        }

        let btn = document.createElement("button");
        btn.setAttribute("data-js-btn-ajouter-photos","");
        btn.innerHTML = "+";
        this._el.querySelector("[data-js-photos]").append(btn);

        this._el.querySelector("[data-js-btn-ajouter-photos]").addEventListener("click", (evt) => 
        {
            evt.preventDefault();
            let rnd = Math.round(Math.random()*1000);
            let previousOrdre = evt.target.previousElementSibling.querySelector('input').dataset.jsOrdre;
            previousOrdre = parseInt(previousOrdre) + 1;

            let nFile = document.createElement("div");
            nFile.classList.add("yu-file");
            nFile.innerHTML =
            `
                <div class="yu-file">
                    <label>Photo secondaire</label>
                    <label for="imgSecondaire${rnd}">Sélectionnez une image</label>
                    <input type="file" id="imgSecondaire${rnd}" name="imgSecondaire[]" accept=".jpg, .jpeg" data-js-ordre="${previousOrdre}">
                    <div class="yu-image-container">
                            <img src="" alt="">
                    </div>
                </div>
            `;

            evt.target.parentNode.insertBefore(nFile, evt.target);


        });
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

    valide = () =>
    {
        let valide = true; 
        let erreurTopInputs = 0;
        let erreurTopTextares = 0;

        for(let i=0; i < this.inputs.length; i++)
        {
            let input = this.inputs[i]; 
            if(input.required)
            {
                if(input.value == ""){ 

                    let spanErreur = document.createElement("span");
                    spanErreur.classList.add("yu-erreur-validation");
                    spanErreur.innerHTML = "Ce champ est required";
                    valide = false;
                    if (erreurTopInputs == 0) 
                    {
                        console.log("input",input);
                        erreurTopInputs = $(input).position().top;
                    }

                    if(!input.nextElementSibling)
                    {
                        input.parentNode.append(spanErreur);
                        input.classList.add("yu-erreur-validation");                        
                    }
                }
                else
                {
                    if(input.nextElementSibling)
                    {
                        input.parentNode.removeChild(input.nextElementSibling);
                        input.classList.remove("yu-erreur-validation");
                    }
                    
                }
            }
            
        }

        for(let i=0; i < this.textareas.length; i++)
        {
            let textarea = this.textareas[i]; 
            if(textarea.required)
            {
                if(textarea.value == ""){ 

                    let spanErreur = document.createElement("span");
                    spanErreur.classList.add("yu-erreur-validation");
                    spanErreur.innerHTML = "Ce champ est required";
                    valide = false;
                    if (erreurTopTextares == 0) 
                    {
                        console.log("textarea",textarea);
                        erreurTopTextares = $(textarea).position().top;
                    }

                    if(!textarea.nextElementSibling)
                    {
                        textarea.parentNode.append(spanErreur);
                        textarea.classList.add("yu-erreur-validation");
                    }
                }
                else
                {
                    if(textarea.nextElementSibling)
                    {
                        textarea.parentNode.removeChild(textarea.nextElementSibling);
                        textarea.classList.remove("yu-erreur-validation");
                    }
                    
                }
            }           
        }

        let erreurTop; console.log(erreurTopInputs, erreurTopTextares);
        if (erreurTopInputs < erreurTopTextares) 
        {
            erreurTop = erreurTopInputs;
        }
        else
        {            
            erreurTop = erreurTopTextares;
            if(erreurTopTextares == 0) erreurTop = erreurTopInputs;
        } 
        $(this._modal).animate({scrollTop:erreurTop}, '500');console.log(valide);

        return valide;

    }

    envoyerPhotos = () =>
    {
        var formData = new FormData();

        let tabOrdre = [];
        for(var i=0; i<this.imgs.length; i++){ 
            if(this.imgs[i].value != "")
            {
                formData.append("imgs[]", this.imgs[i].files[0]);
                tabOrdre.push(this.imgs[i].dataset.jsOrdre);
            }
            
        }

        formData.append("tabOrdre", JSON.stringify(tabOrdre));

        formData.append("nSerie", this.nSerie.value);

        var xhr;
        xhr = new XMLHttpRequest();

        if (xhr) {
            xhr.open("POST",'index.php?Voiture_AJAX&action=ajoutPhotosVoiture');
            // xhr.setRequestHeader('Content-Type', 'multipart/form-data');
            
            xhr.addEventListener("readystatechange", () => {

                if (xhr.readyState === 4) {							
                    if (xhr.status === 200) {
                        console.log("envoyer photos response",xhr.response);
                    } else if (xhr.status === 404) {
                        console.log('Le fichier appelé dans la méthode open() n’existe pas.');
                    }
                }
            });
        }
        
            // Envoi de la requète
        if(tabOrdre.length>0) xhr.send(formData);
    }
}