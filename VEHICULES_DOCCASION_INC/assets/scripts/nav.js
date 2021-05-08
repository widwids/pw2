(() => {
    let hamburger = document.querySelector('[data-js-hamburger]');
    let liens_ham = document.querySelector(".liens_ham");
    let gestion = document.querySelector('[data-js-gestion]');
    let menu_user = document.querySelector('[data-js-menu-user]');
    let dropdown = document.querySelector('[data-js-dropdown]');
    let dropdown_user = document.querySelector('[data-js-dropdown-user]');

	hamburger.addEventListener('click', () => {
        if (hamburger.classList.contains("slideMenu")) {
          hamburger.classList.remove("slideMenu");
          liens_ham.style.transform = "translateX(210px)";
        } else {
          hamburger.classList.add("slideMenu");
          liens_ham.style.transform = "translateX(-210px)";
        }
    });
  
  if(gestion) {
    gestion.addEventListener('click', () => {
        if (dropdown.classList.contains("hide")) {
          dropdown.classList.remove("hide");
        } else {
          dropdown.classList.add("hide");
        }
    });
  }

  if(menu_user) {
    menu_user.addEventListener('click', () => {
        if (dropdown_user.classList.contains("hide")) {
          dropdown_user.classList.remove("hide");
        } else {
          dropdown_user.classList.add("hide");
        }

        if (dropdown.classList.contains("hide")){

        } else {
          dropdown_user.classList.add("hide");
        }
    });
  }
	
})();