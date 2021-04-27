<?php
	class Controleur_Utilisateur extends BaseControleur {		
        public function traite(array $params) {
			$data = array();

            //Modèle pour les utilisateurs
            $modeleUtilisateur =  new Modele_Utilisateur();

            $this -> afficheVue("Head");

            if(isset($params["action"])) {
				$commande = $params["action"]; 
            } else {
                //Commande par défaut
                $commande = "authentification";
            }
        
            //Détermine la vue, remplir le modèle approprié
            switch($commande) {
                case "compte":
                    //Afficher le compte d'un utilisateur spécifique
                    if(isset($_SESSION["utilisateur"])) {
                        $utilisateurId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];
                        $data["utilisateur"] = $modeleUtilisateur -> obtenir_utilisateur($utilisateurId);
                        isset($_SESSION["employe"]) || isset($_SESSION["admin"]) ?
                            $this -> afficheVue("HeaderAdmin") : $this -> afficheVue("Header");
                        $this -> afficheVue("Compte", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
					break;
                case "creationCompte":
                    //Afficher le formulaire d'ajout d'un utilisateur
                    $this -> afficheFormAjoutUtilisateur();
                    break;
                case "insereUtilisateur":
                    if(isset($params["prenom"], $params["nom"], $params["dateNaissance"], $params["adresse"],
                        $params["codePostal"], $params["telephone"], $params["courriel"], $params["pseudonyme"], 
                        $params["motDePasse"], $params["villeId"])) {
                        
                        if(!isset($params["cellulaire"])) $params["cellulaire"] = "";

                        //Validation
                        $messageErreur = $this -> valideFormAjoutUtilisateur($params["prenom"], $params["nom"], 
                            $params["dateNaissance"], $params["adresse"],$params["codePostal"], 
                            $params["telephone"], $params["courriel"], $params["pseudonyme"], 
                            $params["motDePasse"], $params["villeId"]);
                        if($messageErreur == "") {
                            //Insertion du nouvel Utilisateur
                            $nouvelUtilisateur = new Utilisateur(0, $params["prenom"], $params["nom"], 
                                $params["dateNaissance"], $params["adresse"],$params["codePostal"], 
                                $params["telephone"], $params["cellulaire"], $params["courriel"],
                                $params["pseudonyme"], password_hash($params["motDePasse"], PASSWORD_DEFAULT),
                                $params["villeId"], 3);
                            $ajoute = $modeleUtilisateur -> sauvegarde($nouvelUtilisateur);

                            if($ajoute)
                                //Redirection vers la page de connexion
                                var_dump($nouvelUtilisateur);
                                //header("Location: index.php?utilisateur&action=connexion");
                            else
                                $this -> afficheFormAjoutUtilisateur();   
                        } else {
                            //Afficher le formulaire d'ajout d'un utilisateur
                            $this -> afficheFormAjoutUtilisateur($messageErreur);   
                        }
                    } else {
                        trigger_error("Un ou plusieurs paramètres manquants.");
                    }
                    break;
				case "authentification":
					if(isset($params["pseudonyme"], $params["motDePasse"])) {
						$authentifier = $modeleUtilisateur -> authentification($params["pseudonyme"], 
                            $params["motDePasse"]);
						if($authentifier) {
                            if($modeleUtilisateur -> obtenir_privilege($params["pseudonyme"]) == 1) {
								$_SESSION["admin"] = $params["pseudonyme"];
							}
                            if($modeleUtilisateur -> obtenir_privilege($params["pseudonyme"]) == 2) {
								$_SESSION["employe"] = $params["pseudonyme"];
							}
							$_SESSION["utilisateur"] = $params["pseudonyme"];
							header("Location: index.php?Utilisateur&action=compte");
						} else {
							$messageErreur = "La combinaison de l'identifiant et du mot de passe est invalide.";
                            $this -> afficheVue("Header");
                            //Redirection vers le formulaire d'authentification
							$this -> afficheFormOuvertureSesssion($messageErreur); 
						}
					} else
                        //Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion"); 
					break;
				case "connexion":
					//Afficher le formulaire d'authentification
                    $this -> afficheFormOuvertureSesssion();
					break;
				case "deconnexion":
					//Détruire toutes les variables de session
					$_SESSION = array();
					//Pour détruire complètement la session, effacer également le cookie de session
					if (ini_get("session.use_cookies")) {
						$params = session_get_cookie_params();
						setcookie(session_name(), '', time() - 42000,
							$params["path"], $params["domain"],
							$params["secure"], $params["httponly"]
						);
					}
					//Finalement, détruire la session
					session_destroy();
					//Redirection vers la page d'accueil
					header("Location: index.php");
					break;
                case "formulaireAjoutVille":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("FormulaireAjoutVille");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;    
                case "ajouterVille":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomVilleFR"], $params["nomVilleEN"], $params["provinceCode"])) {
                            $modeleUtilisateur -> ajouterVille($params["nomVilleFR"], $params["nomVilleEN"], $params["provinceCode"]);
                            $data["villes"] = $modeleUtilisateur -> obtenir_tous('ville');
                            $this -> afficheVue("HeaderAdmin");
                            $this -> afficheVue("listeVilles", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;
                case "liste":
                    //Obtenir liste avec paramètre envoyé avec AJAX
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["nomTable"])) {
                            $data["liste"] = $modeleUtilisateur -> obtenir_tous($params["nomTable"]);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                case "listeVilles":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["villes"] = $modeleUtilisateur -> obtenir_tous('ville');
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("listeVilles", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "listeProvinces":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["provinces"] = $modeleUtilisateur -> obtenir_tous('province');
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("listeProvinces", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "listePays":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["pays"] = $modeleUtilisateur -> obtenir_tous('pays');
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("listePays", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "listeTaxes":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["taxes"] = $modeleUtilisateur -> obtenir_tous('taxe');
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("listeTaxes", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "listePrivileges":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["provinces"] = $modeleUtilisateur -> obtenir_tous('province');
                        $this -> afficheVue("HeaderAdmin");
                        $this -> afficheVue("listePrivileges", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "suppression":
                    //Suppression d'un élément dans n'importe quelle table avec AJAX
                    if(isset($_SESSION["admin"])) {
                        if (isset($params["nomTable"]) && isset($params["id"])) {
                            $nomId = $modeleUtilisateur -> obtenir_nom_id($params["nomTable"]);
                            $modeleUtilisateur -> supprime($params["nomTable"], $nomId, $params["id"]);
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
					break;
				default:
                    $this -> afficheVue("Page404");
            }

            $this->afficheVue("Footer");
        }

        public function valideFormAjoutUtilisateur($prenom, $nom, $dateNaissance, $adresse, $codePostal, 
            $telephone, $cellulaire, $courriel, $pseudonyme, $motDePasse) {
            
            $erreurs = "";

            $pseudonyme = trim($pseudonyme);
			$motDePasse = trim($motDePasse);

            if($pseudonyme == "")
                $erreurs .= "<p>Le pseudonyme ne peut pas être vide.</p>";
				
			if($motDePasse == "")
                $erreurs .= "<p>Le mot de passe ne peut pas être vide.</p>";

            return $erreurs;
        }

        public function afficheFormAjoutUtilisateur($messageErreur = "") {
            //Afficher le formulaire d'ajout d'un Utilisateur
            //Aller porter les erreurs dans la vue
            $data["erreurs"] = $messageErreur;
            $this -> afficheVue("CreationCompte", $data);
        }

		public function afficheFormOuvertureSesssion($messageErreur = "") {
            //Afficher le formulaire d'ouvertureSession
            //Aller porter les erreurs dans la vue
            $data["erreurs"] = $messageErreur;
            $this -> afficheVue("Connexion", $data);
        }
    }
?>