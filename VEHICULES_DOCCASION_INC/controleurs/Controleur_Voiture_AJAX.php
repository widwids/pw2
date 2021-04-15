<?php
	class Controleur_Voiture_AJAX extends BaseControleur {
	
		// La fonction qui sera appelée par le routeur
		public function traite(array $params) {
			
			if (isset($params["action"])) {

				// Modèle et vue vides par défaut
				$data = array();
                $vue = "";
				
				// Switch en fonction de l'action qui nous est envoyée
				// Ce switch détermine la vue $vue et obtient le modèle $data
				switch ($params["action"]) {
					case "detailVoiture":
						if (isset($params["noSerie"])) {
                            $modeleVoiture = new Modele_Voiture();
                            $data = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);							
                            //$vue = "";		
                           // $this->afficheVue($vue,$data);
                        } else {													
                            echo "ERROR PARAMS";
                        }

					default:
                        $vue = "VoitureListe";		
                        $this->afficheVue($vue);
						break;
				}			
            } else {
				echo "ERROR ACTION";					
			}
		}
	}
?>