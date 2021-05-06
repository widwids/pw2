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


					///////  VOITURE  ///////
					
					case "detailVoiture":
						if (isset($params["noSerie"])) {
							//affiche photo d'une seul voiture ////
							//$data1 = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							// a commenter lorsque vous aurrez votre ($params["noSerie"])
							$data['voiture'] = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							$data['photos'] = $modeleVoiture->obtenirPhotoVoiture($params["noSerie"]);								
							$vue = "detailVoiture";
							$this->afficheVue($vue,$data); 
						} else {													
							echo "ERROR PARAMS";
						}
					break;

					case "suppression": // visibilite = 0
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomTable"]) && isset($params["id"])) {
								$nomId = $modeleVoiture -> obtenir_nom_id($params["nomTable"]);
								//var_dump($nomId);
								//$nomId = $data[0]['Column_name'];
								$modeleVoiture -> supprime($params["nomTable"], $nomId, $params["id"]);
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "FormulaireAjouterVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data["corps"] = $modeleVoiture -> obtenir_tous('corps');
							$data["motopropulseur"] = $modeleVoiture -> obtenir_tous('motopropulseur');
							$data["carburant"] = $modeleVoiture -> obtenir_tous('carburant');
							$data["transmission"] = $modeleVoiture ->obtenir_tous('transmission');
							$data["annee"] = $modeleVoiture -> obtenir_tous('annee');
							//$data["modele"] = $modeleVoiture -> obtenir_tous('modele');
							$data["modele"] = $modeleVoiture -> obtenir_marque_modele('modele');
							
							$data["photo"] = $modeleVoiture -> obtenir_tous('photo');
							$vue = "FormulaireAjouterVoiture";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;


					case "detailVoitureJson":
						//if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["noSerie"])) {
								//affiche photo d'une seul voiture ////
								//$data1 = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
								// a commenter lorsque vous aurrez votre ($params["noSerie"])
								$data['voiture'] = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
								$data['photos'] = $modeleVoiture->obtenirPhotoVoiture($params["noSerie"]);								
								$vue = "detailVoiture";
								echo json_encode($data);
								//$this->afficheVue($vue,$data); 
							} else {													
								echo "ERROR PARAMS";
							}
						/*} else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}*/

					break;

					case "ajoutVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["noSerie"]) &&
								isset($params["descriptionFR"]) &&
								isset($params["descriptionEN"]) &&
								isset($params["visibilite"]) &&
								isset($params["kilometrage"]) &&
								isset($params["dateArrivee"]) &&
								isset($params["prixAchat"]) &&
								isset($params["groupeMPId"]) &&
								isset($params["corpsId"]) &&
								isset($params["carburantId"]) &&
								isset($params["modeleId"]) &&
								isset($params["transmissionId"]) &&
								isset($params["anneeId"])) {

								if($modeleVoiture -> obtenir_par_id('voiture', 'noSerie', $params["noSerie"]) == 0) {
									$valide = $modeleVoiture -> ajoutVoiture($params["noSerie"], $params["descriptionFR"],
									$params["descriptionEN"], $params["kilometrage"], $params["dateArrivee"], 
									$params["prixAchat"],$params["groupeMPId"], $params["corpsId"],
									$params["carburantId"], $params["modeleId"], $params["transmissionId"],
									$params["anneeId"]);
								} else {
									$modeleVoiture -> modifVoiture($params["noSerie"],$params["noSerie"],$params["descriptionFR"], 
									$params["descriptionEN"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],
									$params["groupeMPId"], $params["corpsId"], $params["carburantId"], $params["modeleId"], 
									$params["transmissionId"], $params["anneeId"]);
								}
								
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

					case "modifVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["noSerie"]) &&
								isset($params["descriptionFR"]) &&
								isset($params["descriptionEN"]) &&
								isset($params["kilometrage"]) &&
								isset($params["dateArrivee"]) &&
								isset($params["prixAchat"]) &&
								isset($params["groupeMPId"]) &&
								isset($params["corpsId"]) &&
								isset($params["carburantId"]) &&
								isset($params["modeleId"]) &&
								isset($params["transmissionId"]) &&
								isset($params["anneeId"])) {
								$modeleVoiture->modifVoiture($params["noSerie"],$params["noSerie"],$params["descriptionFR"], $params["descriptionEN"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPId"], $params["corpsId"], $params["carburantId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
								//$vue = "";	
							// $this->afficheVue($vue,$data);
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						} 
					break;

					case "VoitureListeJson":
						// affiche liste voiture//
						$vue = "VoitureListeAdmin";	

                        $data['voitures'] = $modeleVoiture->obtenirListeVoiture();	
						//var_dump($data);
						//$this->afficheVue($vue,$data); 
						echo json_encode($data);
						///////////////////////////////

					break;

					////////  CORPS ///////////

					
					case "ListeCorps":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('corps');
							$vue = "ListeCorpAdmin";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;
					
					case "FormulaireAjouterCorp":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterCorp";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					//en plus//

					case "detailCorpsJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idCorps"])) {
								$data = $modeleVoiture->obtenirCorp($params["idCorps"]);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutCorps":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomCorpsFR"]) &&
								isset($params["nomCorpsEN"])) {
								$valide = $modeleVoiture->ajoutCorps($params["nomCorpsFR"], $params["nomCorpsEN"]);
								
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
					
					case "modifCorps":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idCorps"]) &&
								isset($params["nomCorpsFR"]) &&
								isset($params["nomCorpsEN"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifCorps($params["idCorps"], $params["nomCorpsFR"], $params["nomCorpsEN"] ,$params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "CorpsListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('corps');
							//$vue = "ListeCorpAdmin";
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;
					
					///////  GroupeMP  //////
					
					case "ListeGroupeMP":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('motopropulseur');
							$vue = "ListeGroupeMPadmin";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "detailGroupeMPJson":
                        if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                            if (isset($params["idMotopro"])) {
                                $data['motopro'] = $modeleVoiture->obtenir_par_id('motopropulseur','idMotopro',$params['idMotopro']);
                                echo json_encode($data);
                            } else {
                                echo "ERROR PARAMS";
                            }
                        }else{
                            //Redirection vers le formulaire d'authentification
                            header("Location: index.php?Utilisateur&action=connexion");
                        }
                    break;

                    case "ListeGroupeMPJson":
                        if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                            $data = $modeleVoiture -> obtenir_tous('motopropulseur');
                            //var_dump($data);
                            echo json_encode($data);
                        }else{
                            //Redirection vers le formulaire d'authentification
                            header("Location: index.php?Utilisateur&action=connexion");
                        }
                    break;

					case "FormulaireAjouterGroupeMP":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterGroupeMP";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					//en plus//

					case "detailMotoPropJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idMotopro"])) {
								$data = $modeleVoiture->obtenirMotoProp($params["idMotopro"]);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutMotoProp":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomMotopro"])) {
								$valide = $modeleVoiture->ajoutMotoProp($params["nomMotopro"]);
								
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

					case "modifMotoProp":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idMotopro"]) &&
								isset($params["nomMotopro"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifMotoProp($params["idMotopro"], $params["nomMotopro"], $params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "MotoProListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('motopropulseur');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					////////  CARBURANT /////////

					case "ListeCarburant":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('carburant');
							$vue = "ListeCarburantAdmin";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "FormulaireAjouterCarburant":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterCarburant";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					//en plus//
					

					case "detailCarburantJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idCarburant"])) {
								$data = $modeleVoiture->obtenirCarburant($params["idCarburant"]);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutCarburant":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["typeCarburantFR"])&&
							isset($params["typeCarburantEN"]) ) {
								$valide = $modeleVoiture->ajoutCarburant($params["typeCarburantFR"], $params["typeCarburantEN"]);
								
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

					case "modifCarburant":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idCarburant"]) &&
								isset($params["typeCarburantFR"]) &&
								isset($params["typeCarburantEN"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifCarburant($params["idCarburant"], $params["typeCarburantFR"], $params["typeCarburantEN"],$params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "CarburantListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('carburant');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					////////// TRANSMISSION  //////////

					case "ListeTransmission":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('transmission');
							$vue = "ListeTransmissionAdmin";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "FormulaireAjouterTransmission":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterTransmission";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					// en plus //

					case "detailTransmissionJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idTransmission"])) {
								$data = $modeleVoiture->obtenirTransmission($params["idTransmission"]);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutTransmission":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomTransmissionFR"]) &&
							isset($params["nomTransmissionEN"]) ) {
								$modeleVoiture->ajoutTransmission($params["nomTransmissionFR"], $params["nomTransmissionEN"]);
								
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "modifTransmission":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idTransmission"]) &&
								isset($params["nomTransmissionFR"]) &&
								isset($params["nomTransmissionEN"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifTransmission($params["idTransmission"], $params["nomTransmissionFR"], $params["nomTransmissionEN"],$params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "TransmissionListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('transmission');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					/////// ANNEE ///////

					case "detailAnneeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["annee"])) {
								$data = $modeleVoiture->obtenirAnnee($params["annee"]);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutannee":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["annee"])) {
								$modeleVoiture->ajoutAnnee($params["annee"]);
								
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "modifAnnee":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["annee"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifAnnee($params["annee"], $params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "AnneeListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('annee');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					////////  MODELE  ////////

					case "ListeModele":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_marque_modele('modele');
							$vue = "ListeModeleAdmin";
							//var_dump($data);
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					// en plus //

					case "detailModeleJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["IdModele"])) {
								//$data['modele'] = $modeleVoiture->obtenir_UNE_marque_modele($params['IdModele']);

								$data['modele'] = $modeleVoiture->obtenir_par_id('modele','idModele',$params['IdModele']);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutModele":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomModele"]) &&
								isset($params["marqueId"])) {
								$modeleVoiture->ajoutModele($params["nomModele"], $params["marqueId"]);
								
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "modifModele":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idModele"]) &&
								isset($params["nomModele"]) &&
								isset($params["visibilite"]) &&
								isset($params["marqueId"])) {
								
								$modeleVoiture ->modifModle($params["idModele"], $params["nomModele"], $params["marqueId"], $params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ModeleListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_marque_modele('modele');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					/////// MARQUE ///////


					//en plus//
					
					case "detailMarqueJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["IdMarque"])) {
								$data['marque'] = $modeleVoiture->obtenir_par_id('marque','idMarque',$params['IdMarque']);

								echo json_encode($data);
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "ajoutMarque":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["nomMarque"])) {
								$modeleVoiture->ajoutMarque($params["nomMarque"]);
								
							} else {													
								echo "ERROR PARAMS";
							}  	
						}else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "modifMarque":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["idMarque"]) &&
								isset($params["nomMarque"]) &&
								isset($params["visibilite"])) {
								$modeleVoiture ->modifMarque($params["idMarque"], $params["nomMarque"], $params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "MarqueListeJson":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$data = $modeleVoiture -> obtenir_tous('marque');
							echo json_encode($data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					///////////////////////

					case "FormulaireAjouterModele":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterModele";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

					case "listeVoitures":
						// affiche liste voiture//
						$vue = "VoitureListeAdmin";		
						$data = $modeleVoiture->obtenirListeVoiture();
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						///////////////////////////////
						///////////////////////////////

					break;

					case "ListeVehicule":
						// affiche liste voiture//
						$vue = "VoitureListeAdmin";	
						$data["corps"] = $modeleVoiture -> obtenir_tous('corps');
                        $data["motopropulseur"] = $modeleVoiture -> obtenir_tous('motopropulseur');
                        $data["carburant"] = $modeleVoiture -> obtenir_tous('carburant');
                        $data["transmission"] = $modeleVoiture ->obtenir_tous('transmission');
                        $data["annee"] = $modeleVoiture -> obtenir_tous('annee');
                        //$data["modele"] = $modeleVoiture -> obtenir_tous('modele');
                        $data["modele"] = $modeleVoiture -> obtenir_marque_modele('modele');

                        $data["photo"] = $modeleVoiture -> obtenir_tous('photo');
                        $data['voitures'] = $modeleVoiture->obtenirListeVoiture();	
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						//echo json_encode($data);
						///////////////////////////////

					break;

					case "listeVoituresNonAdmin":
						// affiche liste voiture//
						$vue = "VoitureListe";		
						$data = $modeleVoiture->obtenirListeVoiture();
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						///////////////////////////////

					break;
					
					case "ajoutPhotosVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["imgPrin"]) || isset($params["imgSeco"]) || isset($params["nSerie"]) ) {
								
								///// photo principale /////
								$imgPrin = $params["imgPrin"];
								$file = $imgPrin;
								$info = pathinfo($file);
								$file_name =  basename($file,'.'.$info['extension']);
								//echo  $file_name; 
								$modeleVoiture->ajoutPhotoVoiture($file_name, 1 , $params["nSerie"]);


								///// photos secondaires /////
								$imgSecond = explode(",",$params["imgSeco"]);
								for ($i=0; $i < count($imgSecond); $i++) { 

									$file = $imgSecond[$i];
									$info = pathinfo($file);
									$file_name =  basename($file,'.'.$info['extension']);

									//echo ' / ',$file_name; 
									$modeleVoiture->ajoutPhotoVoiture($file_name, $i+2 , $params["nSerie"]);
								}

							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}

					break;

					/////////////////////////////////////

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