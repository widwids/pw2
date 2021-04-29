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
					
					case "ajoutVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["noSerie"]) &&
								isset($params["descriptionFR"]) &&
								isset($params["descriptionEN"]) &&
								isset($params["visibilite"]) &&
								isset($params["kilometrage"]) &&
								isset($params["dateArrivee"]) &&
								isset($params["prixAchat"]) &&
								isset($params["groupeMPid"]) &&
								isset($params["corpsId"]) &&
								isset($params["carburanstsId"]) &&
								isset($params["modeleId"]) &&
								isset($params["transmissionId"]) &&
								isset($params["anneeId"])) {

								$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["descriptionFR"], $params["descriptionEN"], $params["visibilite"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
								
								if ($valide) {									
									//echo "merci";		
								} else {
									echo "ERROR";
								}
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

											

					/* case "obtenirTous":
						//Modof voiture////
						if (isset($params["nomTable"])) {
							$modeleVoiture -> modifCorps($params["nomTable"]);
							var_dump($data);
						} else {													
							echo "ERROR PARAMS";
						}		

					break; */

					


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