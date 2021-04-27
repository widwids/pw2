(() => {
    let hamburger = document.querySelector('[data-js-hamburger]');
    let liens_ham = document.querySelector(".liens_ham");

	hamburger.addEventListener('click', () => {
        if (hamburger.classList.contains("slideMenu")) {
          hamburger.classList.remove("slideMenu");
          liens_ham.style.transform = "translateX(210px)";
        } else {
          hamburger.classList.add("slideMenu");
          liens_ham.style.transform = "translateX(-210px)";
        }
    })
	
})();