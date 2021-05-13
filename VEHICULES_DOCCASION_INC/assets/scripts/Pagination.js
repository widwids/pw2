class Pagination
{
    constructor(el)
    {
        this.el = el;
        this.elements = this.el.querySelectorAll("tbody tr");
        this.nElements = this.elements.length;
        this.nPages = Math.floor(this.nElements / 10) + 1;   
        this.elementsParPage = 10;  
        this.pageCourant = 1;

        this.pages = document.createElement("div");
        this.pages.classList.add("yu-pagination");
        if(this.el.parentNode.querySelector(".yu-pagination") == undefined) this.el.parentNode.insertBefore(this.pages, this.el);
        
        this.inputContainer = document.createElement("div");
        this.inputContainer.classList.add("yu-pagination-recherche");
        this.inputContainer.innerHTML = "<input type='text' placeholder='Rechercher...'>";
        if(this.el.parentNode.querySelector(".yu-pagination-recherche") == undefined) this.el.parentNode.insertBefore(this.inputContainer, this.el);
        this.inputRecherche = this.inputContainer.querySelector('input'); 

        this.inputRecherche.addEventListener("keyup", (evt) => 
        {
            this.afficherNumerosPages();
            this.refreshList(evt.target.value); 
            this.afficherNumerosPages();           
        });
        

        this.pages.addEventListener("click", (evt) => 
        { 
            if(evt.target.dataset.jsBtnLeft != undefined)
            {
                this.pageCourant--; 
            }
            if(evt.target.dataset.jsBtnRight != undefined)
            {
                this.pageCourant++;
            }
            if(evt.target.dataset.jsBtnNumero != undefined)
            {
                this.pageCourant = evt.target.innerHTML;
            }         
            
            this.afficherNumerosPages();
            this.refreshList(this.inputRecherche.value);
            
        });


        this.afficherNumerosPages();
        this.refreshList();

    }

    afficherNumerosPages = () =>     
    {
        this.nPages = Math.floor(this.nElements / 10) + 1;

        this.pages.innerHTML = "";

        if(this.nPages > 1)
        {
            if(this.pageCourant != 1) this.pages.innerHTML += "<button data-js-btn-left> &#10094;&#10094; </button>";
            for(let i = 0; i < this.nPages; i++)
            {
                if((i+1) == this.pageCourant) this.pages.innerHTML += "<button class='yu-pagination-courant' data-js-btn-numero>"+ (i+1) +"</button>";
                else this.pages.innerHTML += "<button data-js-btn-numero>"+ (i+1) +"</button>";
            }
            if(this.pageCourant != this.nPages) this.pages.innerHTML += "<button data-js-btn-right> &#10095;&#10095; </button>";     
        }else this.pageCourant = 1;

    }

    recherche = (recherche, data) => 
    {
        let trouve = false;
        for(let i=0; i<data.length; i++)
        {
            let innerHTML = data[i].innerHTML.toLowerCase();
            if(innerHTML.match(recherche.toLowerCase()) != null 
            && !data[i].classList.contains('yu-image') 
            && !data[i].classList.contains('yu-actions')
            && !data[i].classList.contains('yu-date-arr')) trouve = true;
        }

        return trouve;
    }

    refreshList = (recherche = "") =>
    {
        this.elements = this.el.querySelectorAll("tbody tr");

        if(recherche == "")
        {   
            this.nElements = this.elements.length; 

            let debut = (this.pageCourant*this.elementsParPage) - this.elementsParPage;
            let fin = debut + (this.elementsParPage-1);

            for(let i=0; i<this.elements.length; i++)
            {
                if(i<debut || i>fin) this.elements[i].classList.add("yu-pagination-hide"); else this.elements[i].classList.remove("yu-pagination-hide"); 
            }
        }
        else
        {            
            let nElements = 0;
            let elms = [];
            for(let i=0; i<this.elements.length; i++)
            {
                let chaineTd = this.elements[i].querySelectorAll("td");
                if(!this.recherche(recherche, chaineTd)) 
                {
                    this.elements[i].classList.add("yu-pagination-hide");
                }
                else
                {
                    nElements++;
                    this.elements[i].classList.remove("yu-pagination-hide");
                    elms.push(this.elements[i]);
                }
            }
            this.nElements = nElements; 
            this.pageCourant = Math.floor(this.nElements / 10) + 1;

            let debut = (this.pageCourant*this.elementsParPage) - this.elementsParPage;
            let fin = debut + (this.elementsParPage-1);

            for(let i=0; i<elms.length; i++)
            {
                if(i<debut || i>fin) elms[i].classList.add("yu-pagination-hide"); else elms[i].classList.remove("yu-pagination-hide"); 
            }
        }
    }
}