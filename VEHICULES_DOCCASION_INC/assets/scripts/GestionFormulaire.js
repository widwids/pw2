class GestionFormulaire{
    constructor(el)
    {
        this._el = el.querySelector('form');
        this.inputs = this._el.querySelectorAll('input');
        this.textareas = this._el.querySelectorAll('textarea'); 
        this.selects = this._el.querySelectorAll('select');
        
    }


    obtenirQueryString = () => 
    {
        let query = this.inputs[0].name+"="+this.inputs[0].value;
        for(let i=1; i < this.inputs.length; i++)
        {
            let input = this.inputs[i];
            query += "&" + input.name + "=" + input.value;
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
        for (const [key, value] of Object.entries(data[0])) {
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
}