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

					case "tousEnregisTable":
						//Modof voiture////
						if (isset($params["nomTable"])) {
							$modeleVoiture = new Modele_Voiture();
							$data = $modeleVoiture->obtenir_touss($params["nomTable"]);
							var_dump($data);
						} else {													
                            echo "ERROR PARAMS";
                        }

					break;
					case "afficheDetailVoiture":
						if (isset($params["noSerie"])) {
							//affiche photo d'une seul voiture ////
							$modeleVoiture = new Modele_Voiture();
							$data1 = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							// a commenter lorsque vous aurrez votre ($params["noSerie"])
							$voiture = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							$photos = $modeleVoiture->obtenirPhotoVoiture($params["noSerie"]);
							
							var_dump($photos);
							var_dump($voiture);
							
							//$vue = "";
							//$this->afficheVue($vue,$photo,$voiture); 
						} else {													
                            echo "ERROR PARAMS";
                        }

					break;
				
					case "modifVoiture":
						//Modof voiture////
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
							isset($params["anneeId"]))  {
                            $modeleVoiture = new Modele_Voiture();
                            $modeleVoiture->ajoutVoiture($params["noSerie"], $params["descriptionFR"], $params["descriptionEN"], $params["visibilite"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
							//$vue = "";	
                           // $this->afficheVue($vue,$data);
                        } else {													
                            echo "ERROR PARAMS";
                        } 
							break;

					case "ajoutVoiture":
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

							$modeleVoiture = new Modele_Voiture();
							$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["descriptionFR"], $params["descriptionEN"], $params["visibilite"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
							
							if ($valide) {									
								//echo "merci";		
							} else {
								echo "ERROR";
							}
						} else {													
                            echo "ERROR PARAMS";
                        }  	
					break;
					
					case "listeCorps":
						//Modof voiture////

							$modeleVoiture = new Modele_Voiture();
							$data = $modeleVoiture->obtenirCorps();
							var_dump($data);

					break;
					
					case "modifCorps":
						//Modof voiture////

							$modeleVoiture = new Modele_Voiture();
							$data = $modeleVoiture->obtenirCorps();
							var_dump($data);

					break;

					case "listeVoitures":
						// affiche liste voiture//
						$vue = "VoitureListe";		
						$modeleVoiture = new Modele_Voiture();
						$data = $modeleVoiture->obtenirTous();
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						///////////////////////////////

					break;
		
				}			
			} else {

				// affiche liste voiture//
				$vue = "VoitureListe";		
                $modeleVoiture = new Modele_Voiture();
				$data = $modeleVoiture->obtenirTous();
				//var_dump($data);
				$this->afficheVue($vue,$data); 
				///////////////////////////////
			}
			$this->afficheVue("Footer");
		}
	}
?>