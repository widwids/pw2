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
						/* if (isset($params["noSerie"])) {
                            $modeleVoiture = new Modele_Voiture();
                            $data = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);							
                            //$vue = "";		
                           // $this->afficheVue($vue,$data);
                        } else {													
                            echo "ERROR PARAMS";
                        } */
						break; 


					 case "ajoutVoiture":
						 
						/* if (isset($params["noSerie"]) &&
                            isset($params["kilometrage"]) &&
                            isset($params["dateArrivee"]) &&
                            isset($params["prixAchat"]) &&
                            isset($params[""]) &&
                            isset($params[""]) &&
                            isset($params[""]) &&
                            isset($params[""]) &&
                            isset($params[""]) &&
                            isset($params[""])) {

							$modeleVoiture = new Modele_Voiture();
							//$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"], $params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"], $params["photoAccueil"]);
							$valide = $modeleVoiture->ajoutVoiture('BBB16900014000033', 11200, '2019-04-13', '9600.00', 1, 3, 2, 4, 2, 2019, '434629');
					
							if ($valide) {									
								//echo "merci";		
							} else {
								echo "ERROR";
							}
						} else {													
                            echo "ERROR PARAMS";
                        }  */
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