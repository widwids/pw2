(() => {

    let components = document.querySelectorAll('[data-component]'),
		panier = document.querySelector('[data-js-cart]');

	for (let i = 0, l = components.length; i < l; i++) {
		
		let componentDataSet = components[i].dataset.component;
		let componentElement = components[i];

		for (let key in classMapping) {
			if (componentDataSet == key) new classMapping[componentDataSet](componentElement);
		}
	}

	panier.addEventListener('click', () => {
		new Panier();
	})
	
})();