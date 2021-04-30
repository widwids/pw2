class FormulaireAjouterVoiture{
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
}