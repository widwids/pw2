<?php
	class Controller_Shop extends BaseController {
	
		//la fonction qui sera appelée par le routeur
		public function traite(array $params) {
			
			$this->showView("Head");
			$this->showView("Header");
			
			if (isset($params["action"])) {
				// Modèle et vue vides par défaut
				$data = array();
				
				// Switch en fonction de l'action qui nous est envoyée
				// Ce switch détermine la vue $vue et obtient le modèle $data
				switch($params["action"]) {
					
				}			
			} else {
				// Action par défaut
				$vue = "VoitureListe";		
				
				
                $modelVoiture = new Model_Voiture();
				$data = $modelVoiture->obtenirTous();
				//var_dump($data);
				$this->showView($vue,$data);
				 /*$data = array_merge($nbProducts, $allProducts);		
                $vue = "ProductList";		
				$this->showView($vue, $data);
				$vue = "ProductListEnd";		
                $this->showView($vue); */
			}
			$this->showView("Footer");
		}
	}
?>