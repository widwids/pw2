<?php
	class Controleur_Voiture extends BaseControleur {
	
		//la fonction qui sera appelée par le routeur
		public function traite(array $params) {
			
			$this->afficheVue("Head");
			$this->afficheVue("Header");
			
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
				
				
                $modeleVoiture = new Modele_Voiture();
				$data = $modeleVoiture->obtenirTous();
				$modeleVoiture = new Modele_Voiture();
                //$data = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
				$data1 = $modeleVoiture->obtenirUneVoiture('ABC12300000954321');
				//var_dump($data1);
				$this->afficheVue($vue,$data);
				 
			}
			$this->afficheVue("Footer");
		}
	}
?>