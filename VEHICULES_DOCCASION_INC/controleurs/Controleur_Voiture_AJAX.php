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
					
					case "detailVoiture":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
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
						} else {
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}

					break;
				
					case "modifVoiture":
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
								isset($params["anneeId"]))  {
								$modeleVoiture->modifVoiture($params["noSerie"], $params["descriptionFR"], $params["descriptionEN"], $params["visibilite"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
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

								
								$valide = $modeleVoiture->ajoutVoiture($params["noSerie"], $params["descriptionFR"], $params["descriptionEN"], $params["kilometrage"], $params["dateArrivee"], $params["prixAchat"],$params["groupeMPid"], $params["corpsId"], $params["carburanstsId"], $params["modeleId"], $params["transmissionId"], $params["anneeId"]);
								
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

					case "FormulaireAjouterGroupeMP":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterGroupeMP";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

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

					case "modifCorps":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							if (isset($params["id"]) &&
								isset($params["nomCorpsFR"]) &&
								isset($params["nomCorpsEN"]) &&
								isset($params["visibilite"])) {
								
								$modeleVoiture ->modifCorps($params["id"], $params["nomCorpsFR"], $params["nomCorpsEN"] ,$params["visibilite"]);
								
							} else {													
								echo "ERROR PARAMS";
							}
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;
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
					
					case "FormulaireAjouterModele":
						if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
							$vue = "FormulaireAjouterModele";
							$this->afficheVue($vue,$data);
						}else{
							//Redirection vers le formulaire d'authentification
							header("Location: index.php?Utilisateur&action=connexion");
						}
					break;

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

					case "ListeVehicule":
						// affiche liste voiture//
						$vue = "VoitureListeAdmin";		
						$data = $modeleVoiture->obtenirListeVoiture();
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						///////////////////////////////

					break;

					case "listeVoitures":
						// affiche liste voiture//
						$vue = "VoitureListeAdmin";		
						$data = $modeleVoiture->obtenirListeVoiture();
						//var_dump($data);
						$this->afficheVue($vue,$data); 
						///////////////////////////////

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