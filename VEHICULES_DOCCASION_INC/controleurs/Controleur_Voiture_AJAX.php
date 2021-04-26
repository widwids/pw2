<?php
	class Controleur_Voiture_AJAX extends BaseControleur {
	
		// La fonction qui sera appelée par le routeur
		public function traite(array $params) {
			
			$modeleVoiture = new Modele_Voiture();

			if (isset($params["action"])) {

				// Modèle et vue vides par défaut
				$data = array();
                $vue = "";
				
				// Switch en fonction de l'action qui nous est envoyée
				// Ce switch détermine la vue $vue et obtient le modèle $data
				switch ($params["action"]) {
					
					case "obtenirNomID":
						if (isset($params["nomTable"])) {
							$data = $modeleVoiture -> obtenir_Nom_ID($params["nomTable"]);
							$nomId = $data[0]['Column_name'];
							var_dump($nomId);
						} else {													
							echo "ERROR PARAMS";
						}

					break;

					case "suppressionEnreg": // visibilite = 0
						if (isset($params["nomTable"]) && isset($params["id"])) {
							$modeleVoiture = new Modele_Voiture();
							$data = $modeleVoiture -> obtenir_Nom_ID($params["nomTable"]);
							$nomId = $data[0]['Column_name'];
							$data = $modeleVoiture -> supprimeMed($params["nomTable"], $nomId, $params["id"]);
						} else {													
							echo "ERROR PARAMS";
						}
						break;						

					case "obtenirTous":
						//Modof voiture////
						if (isset($params["nomTable"])) {
							$modeleVoiture = new Modele_Voiture();
							$data["test"] = $modeleVoiture -> obtenir_liste($params["nomTable"]);
							var_dump($data);
						} else {													
							echo "ERROR PARAMS";
						}

					break;


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