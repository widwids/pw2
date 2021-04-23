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
						

					case "supressionTable": // visibilite = 0
						if (isset($params["nomTable"]) && isset($params["id"])) {
							$modeleVoiture = new Modele_Voiture();
							$data = $modeleVoiture -> obtenir_Nom_ID($params["nomTable"]);
							$nomId = $data[0]['Column_name'];
							$data = $modeleVoiture -> supprimeMed($params["nomTable"], $nomId, $params["id"]);
							/* if(isset($params["nomTable"]) && isset($params["id"])) {
								$modeleUtilisateur -> supprime($params["nomTable"], $params["id"]);
							} */
						} else {													
							echo "ERROR PARAMS";
						}
						break;

						/* public function obtenir_Nom_ID($nomTable) { //Autres tables
							$requete = "SHOW KEYS FROM $nomTable WHERE Key_name = 'PRIMARY'";
							$resultats = $this -> connexion -> query($requete);
							$resultats -> execute();
							return $resultats -> fetchAll();
						} */

						/* //"Suppression" (DELETE)
						public function supprimeMed($nomTable, $nomId, $id) {
							$requete = "UPDATE $nomTable SET visibilite = 0 WHERE $nomId = :id";
							$requetePreparee = $this -> connexion -> prepare($requete);
							$requetePreparee -> bindParam(":id", $id);
							$requetePreparee -> execute();
				
							//Retour du nombre de rangées affectées 
							return $requetePreparee -> rowCount();
						} */
						

					case "tousEnregisTable":
						//Modof voiture////
						if (isset($params["nomTable"])) {
							$modeleVoiture = new Modele_Voiture();
							$data["test"] = $modeleVoiture -> obtenir_liste($params["nomTable"]);
							var_dump($data);
						} else {													
							echo "ERROR PARAMS";
						}

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
							$valide = $modeleVoiture->ajoutVoiture	('XXXX2578400954379', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 12000, '2021-02-18', '12000.00', 1, 2, 2, 2, 1, 2017);
							
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