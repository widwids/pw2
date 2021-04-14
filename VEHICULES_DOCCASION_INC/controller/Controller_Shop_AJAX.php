<?php
	class Controller_Shop_AJAX extends BaseController {
	
		// La fonction qui sera appelée par le routeur
		public function traite(array $params) {
			
			if (isset($params["action"])) {

				// Modèle et vue vides par défaut
				$data = array();
                $vue = "";
				
				// Switch en fonction de l'action qui nous est envoyée
				// Ce switch détermine la vue $vue et obtient le modèle $data
				switch ($params["action"]) {

					default:
                        $vue = "VoitureListe";		
                        $this->showView($vue);
						break;
				}			
            } else {
				echo "ERROR ACTION";					
			}
		}
	}
?>