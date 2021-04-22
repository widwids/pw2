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
					
					case "afficheDetailVoiture":
					
					    //affiche photo d'une seul voiture ////
						$modeleVoiture = new Modele_Voiture();
						// à décommenter lorsque vous aurrez votre ($params["noSerie"])
						// $data1 = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
						// a commenter lorsque vous aurrez votre ($params["noSerie"])
						$var = 'ABC12300067154336';
						$photo = $modeleVoiture->obtenirPhotoVoiture($var);
						$voiture = $modeleVoiture->obtenirUneVoiture($var);
						var_dump($photo);
						var_dump($voiture);
						/////////////////////
						//$this->afficheVue($vue,$data); 

					break;
				
					case "modifVoiture":
						//Modof voiture////

							$modeleVoiture = new Modele_Voiture();
							//$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["newNoSerie"],$params["kilometrage"], $params["dateArrivee"], $params["prixAchat"], $params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"], $params["photoAccueil"]);
							$modeleVoiture->modifVoiture('AAABBB0001400CCCC', 'A0000000000000000', 999999, '2022-02-20', '1111.00', 2, 2, 2, 2, 2, 2020, '434629');

						break;

					case "ajoutVoiture":
						// ajout voiture //
							$modeleVoiture = new Modele_Voiture();
							//$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"], $params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"], $params["photoAccueil"]);
							$valide = $modeleVoiture->ajoutVoiture('ppp16900014022033', 11200, '2019-04-13', '9600.00', 1, 3, 2, 4, 2, 2019, '434629');
							
							if ($valide) {									
								//echo "merci";		
							} else {
								echo "ERROR";
							}
							////////	
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
		
				}			
			} else {

				// affiche liste voiture//
				$vue = "VoitureListe";		
                $modeleVoiture = new Modele_Voiture();
				$data = $modeleVoiture->obtenirTous();
				$this->afficheVue($vue,$data); 
				///////////////////////////////
			}
			$this->afficheVue("Footer");
		}
	}
?>