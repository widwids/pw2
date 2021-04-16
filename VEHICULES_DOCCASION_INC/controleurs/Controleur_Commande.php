<?php
	class Controleur_Commande extends BaseControleur {		
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
            }else {

				
			}

            $this->afficheVue("Footer");
        }
    }
?>