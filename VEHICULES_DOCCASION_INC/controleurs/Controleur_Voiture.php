<?php
	class Controleur_Voiture extends BaseControleur {
	
		//la fonction qui sera appelée par le routeur
		public function traite(array $params) {
			$data = array();
			
			//Modèle pour les Voitures
			$modeleVoiture = new Modele_Voiture();

			$this->afficheVue("Head");
			$this -> afficheVue("Header");

			if(isset($params["action"])) {
				$commande = $params["action"]; 
			} else {
				//Commande par défaut
				$commande = "accueil";
			}
			
			// Switch en fonction de l'action qui nous est envoyée
			// Ce switch détermine la vue $vue et obtient le modèle $data
			switch($commande) {
				case "accueil":
					$this -> afficheVue("Accueil");
					break;
				case "aPropos":
					$this -> afficheVue("APropos");
					break;
				case "politiques":
					$this -> afficheVue("Politiques");
					break;
				case "contact":
					$this -> afficheVue("Contact");
					break;
				case "detailVoiture":
					//if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
						if (isset($params["noSerie"])) {
							//affiche photo d'une seul voiture ////
							//$data1 = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							// a commenter lorsque vous aurrez votre ($params["noSerie"])
							$data['voiture'] = $modeleVoiture->obtenirUneVoiture($params["noSerie"]);
							$data['photos'] = $modeleVoiture->obtenirPhotoVoiture($params["noSerie"]);
							$data["statut"] = $modeleVoiture -> obtenir_statut($params["noSerie"]);								
							$vue = "detailVoiture";
							$this->afficheVue($vue,$data); 
						} else {													
							echo "ERROR PARAMS";
						}
					/*} else {
						// Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion");
					}*/

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
					} else{
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

				case "suppression": // visibilite = 0
					if (isset($_SESSION["admin"])) {
						if (isset($params["nomTable"]) && isset($params["id"])) {
							$nomId = $modeleVoiture -> obtenir_nom_id($params["nomTable"]);
							var_dump($nomId);
							//$nomId = $data[0]['Column_name'];
							$modeleVoiture -> supprime($params["nomTable"], $nomId, $params["id"]);
						} else {													
							echo "ERROR PARAMS";
						}
					} else{
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
						$data['marque_modele'] = $modeleVoiture -> obtenir_marque_modele('modele');
						$data['marques'] = $modeleVoiture -> obtenir_tous('marque');
						$vue = "ListeModeleAdmin";
						//var_dump($data);
						$this->afficheVue($vue,$data);
					}else{
						//Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion");
					}
				break;
				
				case "ListeMarque":
					if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
						$data = $modeleVoiture -> obtenir_tous('marque');
						$vue = "ListeMarqueAdmin";
						//var_dump($data);
						$this->afficheVue($vue,$data);
					}else{
						//Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion");
					}
				break;

				case "ListeAnnee":
					if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
						$data = $modeleVoiture -> obtenir_tous('annee');
						$vue = "ListeAnneeAdmin";
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

				case "listeVoituresNonAdmin":
					// affiche liste voiture//
					$vue = "VoitureListe";		
					$data["voitures"] = $modeleVoiture->obtenirListeVoiture();
					$data["marques"] = $modeleVoiture -> obtenir_marques();
					$data["annees"] = $modeleVoiture -> obtenir_tous('annee');
					$data["modeles"] = $modeleVoiture -> obtenir_modeles();
					$data["commandes"] = $modeleVoiture -> obtenir_tous('commandeVoiture');
					//var_dump($data);
					$this->afficheVue($vue,$data); 
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

				case "listeVoitures":
					// affiche liste voiture//
					$vue = "VoitureListeAdmin";		
					$data = $modeleVoiture->obtenirListeVoiture();
					//var_dump($data);
					$this->afficheVue($vue,$data); 
					///////////////////////////////

				break;


				/// pas encore devloppé 

				case "FormulaireAjoutPhotoVoiture":
					if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
						if (isset($params["nSerie"])) {
							// affiche liste voiture//
							$vue = "FormulaireAjoutPhotos";	
							$data = $params["nSerie"];	
							//$data = $modeleVoiture->obtenirListeVoiture();
							$this->afficheVue($vue,$data); 
							///////////////////////////////
						} else {													
							echo "ERROR PARAMS";
						}
					}else{
						//Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion");
					}
				break;
			}			

			$this->afficheVue("Footer");
		}
	}
?>