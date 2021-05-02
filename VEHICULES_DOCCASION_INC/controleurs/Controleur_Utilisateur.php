<?php
	class Controleur_Utilisateur extends BaseControleur {		
        public function traite(array $params) {
			$data = array();

            //Modèle pour les utilisateurs
            $modeleUtilisateur =  new Modele_Utilisateur();

            $this -> afficheVue("Head");
            isset($_SESSION["employe"]) || isset($_SESSION["admin"]) ?
                $this -> afficheVue("HeaderAdmin") : $this -> afficheVue("Header");

            if(isset($params["action"])) {
				$commande = $params["action"]; 
            } else {
                //Commande par défaut
                $commande = "authentification";
            }
        
            //Détermine la vue, remplir le modèle approprié
            switch($commande) {
                case "connexion":
					//Afficher le formulaire d'authentification
                    $this -> afficheFormOuvertureSesssion();
					break;

				case "authentification":
					if(isset($params["pseudonyme"], $params["motDePasse"])) {
						$authentifier = $modeleUtilisateur -> authentification($params["pseudonyme"], 
                            $params["motDePasse"]);
						if($authentifier) {

                            //Variables de session
                            if($modeleUtilisateur -> obtenir_privilege($params["pseudonyme"]) == 1) 
								$_SESSION["admin"] = $params["pseudonyme"];
							
                            if($modeleUtilisateur -> obtenir_privilege($params["pseudonyme"]) == 2)
								$_SESSION["employe"] = $params["pseudonyme"];
							
							$_SESSION["utilisateur"] = $params["pseudonyme"];

                            $utilisateurId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];

                            if($modeleUtilisateur -> obtenir_par_id('connexion', 'idConnexion', $utilisateurId) == 0) {
                                $modeleUtilisateur -> ajouterConnexion($utilisateurId);
                            } else {
                                $modeleUtilisateur -> modifierConnexion($utilisateurId);
                            }
                            
							header("Location: index.php?Utilisateur&action=compte");
						} else {
							$messageErreur = "La combinaison de l'identifiant et du mot de passe est invalide.";
                            //Redirection vers le formulaire d'authentification
							$this -> afficheFormOuvertureSesssion($messageErreur); 
						}
					} else
                        //Redirection vers le formulaire d'authentification
						header("Location: index.php?Utilisateur&action=connexion"); 
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
                
                case "motDePassePerdu":
                    if(isset($params["pseudonyme"])) {
                        
                    }
                    break;
                /*--------------- Insertion(CREATE) ---------------*/
                
                case "creationCompte":
                    //Afficher le formulaire d'ajout d'un utilisateur
                    $this -> afficheFormAjoutUtilisateur();
                    break;

                case "insereUtilisateur":
                    //Création d'un utilisateur
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
                                $params["dateNaissance"], $params["adresse"], $params["codePostal"], 
                                $params["telephone"], $params["cellulaire"], $params["courriel"],
                                $params["pseudonyme"], password_hash($params["motDePasse"], PASSWORD_DEFAULT),
                                $params["villeId"]);
                            $ajoute = $modeleUtilisateur -> ajouterUtilisateur($nouvelUtilisateur);

                            if($ajoute)
                                //Redirection vers la page de connexion
                                header("Location: index.php?Utilisateur&action=connexion");
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

                case "formulaireAjoutVille":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
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
                            $this -> afficheVue("ListeVilles", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "formulaireAjoutProvince":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("FormulaireAjoutProvince");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "ajouterProvince":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomProvinceFR"], $params["nomProvinceEN"], $params["paysId"])) {
                            $modeleUtilisateur -> ajouterProvince($params["nomProvinceFR"], $params["nomProvinceEN"], $params["paysId"]);
                            $data["provinces"] = $modeleUtilisateur -> obtenir_tous('province');
                            $this -> afficheVue("ListeProvinces", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "formulaireAjoutPays":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("FormulaireAjoutPays");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "ajouterPays":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomPaysFR"], $params["nomPaysEN"])) {
                            $modeleUtilisateur -> ajouterPays($params["nomPaysFR"], $params["nomPaysEN"]);
                            $data["pays"] = $modeleUtilisateur -> obtenir_tous('pays');
                            $this -> afficheVue("ListePays", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "formulaireAjoutTaxe":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("FormulaireAjoutTaxe");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "ajouterTaxe":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomTaxeFR"], $params["nomTaxeEN"], $params["taux"], $params["provinceId"])) {
                            $taxeId = $modeleUtilisateur -> ajouterTaxe($params["nomTaxeFR"], $params["nomTaxeEN"]);
                            $modeleUtilisateur -> ajouterTaxeProvince($params["provinceId"], $taxeId, $params["taux"]);
                            $data["taxes"] = $modeleUtilisateur -> obtenir_tous('taxe');
                            $this -> afficheVue("ListeTaxes", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "formulaireAjoutPrivilege":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("FormulaireAjoutPrivilege");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "ajouterPrivilege":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomPrivilegeFR"], $params["nomPrivilegeEN"])) {
                            $modeleUtilisateur -> ajouterPrivilege($params["nomPrivilegeFR"], $params["nomPrivilegeEN"]);
                            $data["privileges"] = $modeleUtilisateur -> obtenir_tous('privilege');
                            $this -> afficheVue("ListePrivileges", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;
                
                /*--------------- Lecture(READ) ---------------*/

                case "compte":
                    //Afficher le compte d'un utilisateur spécifique
                    if(isset($_SESSION["utilisateur"])) {
                        $utilisateurId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];
                        $data["utilisateur"] = $modeleUtilisateur -> obtenir_utilisateur($utilisateurId);
                        
                        $this -> afficheVue("Compte", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
					break;

                case "liste":
                    //Obtenir Liste avec paramètre envoyé avec AJAX
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["nomTable"])) {
                            $data["Liste"] = $modeleUtilisateur -> obtenir_tous($params["nomTable"]);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeUtilisateurs":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["utilisateurs"] = $modeleUtilisateur -> obtenir_utilisateurs();
                        $this -> afficheVue("ListeUtilisateurs", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeVilles":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["villes"] = $modeleUtilisateur -> obtenir_tous('ville');
                        $this -> afficheVue("ListeVilles", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeProvinces":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["provinces"] = $modeleUtilisateur -> obtenir_tous('province');
                        $this -> afficheVue("ListeProvinces", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listePays":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["pays"] = $modeleUtilisateur -> obtenir_tous('pays');
                        $this -> afficheVue("ListePays", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeTaxes":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["taxes"] = $modeleUtilisateur -> obtenir_tous('taxe');
                        $data["taxeProvince"] = $modeleUtilisateur -> obtenir_tous('taxeProvince');
                        $this -> afficheVue("ListeTaxes", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listePrivileges":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["privileges"] = $modeleUtilisateur -> obtenir_tous('privilege');
                        $this -> afficheVue("ListePrivileges", $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeConnexions":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["connexions"] = $modeleUtilisateur -> obtenir_tous('connexion');
                        $this -> afficheVue("ListeConnexions", $data);
                    }  else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                
                /*--------------- Modification(UPDATE) ---------------*/
                
                case "modifierUtilisateur":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["prenom"], $params["nom"], $params["dateNaissance"], 
                            $params["adresse"], $params["codePostal"], $params["telephone"], 
                            $params["courriel"], $params["pseudonyme"], $params["motDePasse"], 
                            $params["villeId"])) {
                        
                            if(!isset($params["cellulaire"])) $params["cellulaire"] = "";

                            $utilisateur = new Utilisateur(0, $params["prenom"], $params["nom"], 
                                $params["dateNaissance"], $params["adresse"], $params["codePostal"], 
                                $params["telephone"], $params["cellulaire"], $params["courriel"],
                                $params["pseudonyme"], password_hash($params["motDePasse"], PASSWORD_DEFAULT),
                                $params["villeId"]);
                            $modifie = $modeleUtilisateur -> modifierUtilisateur($utilisateur);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;
                
                case "modifierMotDePasse":
                    //Changement de mot de passe
                    if(isset($params["motDePasse"], $params["pseudonyme"])) {
                        $modeleUtilisateur -> modifierMotDePasse(password_hash($params["motDePasse"], PASSWORD_DEFAULT), 
                            $params["pseudonyme"]);
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    } else {
                        trigger_error("Paramètre manquant.");
                    }
                    break;

                case "modifierVille":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomVilleFR"], $params["nomVilleEN"], $params["provinceCode"], $params["idVille"])) {
                            $modeleUtilisateur -> modifierVille($params["nomVilleFR"], $params["nomVilleEN"], 
                                $params["provinceCode"], $params["idVille"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "modifierProvince":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomProvinceFR"], $params["nomProvinceEN"], $params["paysId"], $params["codeProvince"])) {
                            $modeleUtilisateur -> modifierProvince($params["nomProvinceFR"], $params["nomProvinceEN"], 
                                $params["paysId"], $params["codeProvince"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "modifierPays":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomPaysFR"], $params["nomPaysEN"], $params["idPays"])) {
                            $modeleUtilisateur -> modifierPays($params["nomPaysFR"], $params["nomPaysEN"], $params["idPays"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "modifierTaxe":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomTaxeFR"], $params["nomTaxeEN"], $params["idTaxe"], 
                                $params["taux"], $params["provinceId"])) {
                            $modeleUtilisateur -> modifierTaxe($params["nomTaxeFR"], $params["nomTaxeEN"], $params["idTaxe"]);
                            $modeleUtilisateur -> modifierTaxeProvince($params["provinceId"], $params["idTaxe"], $params["taux"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "modifierPrivilege":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomPrivilegeFR"], $params["nomPrivilegeEN"], $params["idPrivilege"])) {
                            $modeleUtilisateur -> modifierPrivilege($params["nomPrivilegeFR"], $params["nomPrivilegeEN"],
                                $params["idPrivilege"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                /*--------------- "Suppression" (DELETE) ---------------*/

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