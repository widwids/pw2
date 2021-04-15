<?php
	class Controleur_Utilisateur extends BaseControleur {		
        public function traite(array $params) {
			$data = array();

            $this->afficheVue("Head");
			$this->afficheVue("Header");

            if(isset($params["action"])) {
				$commande = $params["action"]; 
            } else {
                //Commande par défaut
                $commande = "affiche";
            }
        
            //Détermine la vue, remplir le modèle approprié
            switch($commande) {
                case "affiche":
                    //Afficher un utilisateur spécifique à partir de l'ID
                    if(isset($params["id"])) {
                        //Aller chercher le modèle pour les utilisateurs
                        $modeleUtilisateur = new Modele_Utilisateur();
                        $data["utilisateur"] = $modeleUtilisateur -> obtenir_par_id($params["id"]);
                        $this -> afficheVue("AfficheUtilisateur", $data);
                    } else {
                        //Ce serait ici un code 404
                        trigger_error("Pas d'id spécifié pour l'utilisateur.");
                    }
					break;
                /*case "afficheFormulaireAjout":
                    //Afficher le formulaire d'ajout d'un utilisateur
                    $this -> afficheFormAjoutUtilisateur();
                    break;
                case "insereUtilisateur":
                    if(isset($params["pseudonyme"], $params["motDePasse"])) {
                        //Validation
                        $messageErreur = $this -> valideFormAjoutUtilisateur($params["pseudonyme"], $params["motDePasse"]);
                        if($messageErreur == "") {
                            //Insertion du nouveau Utilisateur
                            $modeleUtilisateurs = $this -> obtenirDAO("Utilisateurs");
                            $nouvelUtilisateur = new Utilisateur(0, $params["pseudonyme"], password_hash($params["motDePasse"], PASSWORD_DEFAULT), 0);
                            $modeleUtilisateurs -> sauvegarde($nouvelUtilisateur);

                            //Redirection vers la page de connexion
                            header("Location: index.php");
                        } else {
                            //Afficher le formulaire d'ajout d'un Utilisateur
                            $this -> afficheVue("Entete");
                            $this -> afficheFormAjoutUtilisateur($messageErreur);
                            $this -> afficheVue("PiedDePage");   
                        }
                    } else {
                        trigger_error("Un ou plusieurs paramètres manquants.");
                    }
                    break;
				case "supprimeUtilisateur":
					if(isset($params["id"])) {
						$this -> afficheVue("Entete");
						//Aller chercher le modèle des Utilisateurs
                        $modeleUtilisateurs = $this -> obtenirDAO("Utilisateurs");
						$donnees["Utilisateur"] = $modeleUtilisateurs -> supprime($params["id"]);
						$this -> afficheListeUtilisateurs();
                        $this -> afficheVue("PiedDePage");
					}
					break;
				case "authentification":
					if(isset($_REQUEST["pseudonyme"], $_REQUEST["motDePasse"])) {
						
						$authentifier = $modeleUtilisateurs -> authentification($_REQUEST["pseudonyme"], $_REQUEST["motDePasse"]);
						if($authentifier) {
							if($modeleUtilisateurs -> acces_admin($_REQUEST["pseudonyme"])) {
								$_SESSION["admin"] = $_REQUEST["pseudonyme"];
							}
							$_SESSION["Utilisateur"] = $_REQUEST["pseudonyme"];
							header("Location: index.php?Sujets&cmd=afficheListe");
						} else {
							$messageErreur = "La combinaison de l'identifiant et du mot de passe est invalide.";
							$this -> afficheVue("Entete");
							$this -> afficheFormOuvertureSesssion($messageErreur); //Redirection vers le formulaire d'authentification
							$this -> afficheVue("PiedDePage");
						}
					} else
						header("Location: index.php?Utilisateurs&cmd=ouvertureSession"); //Redirection vers le formulaire d'authentification
					break;
				case "ouvertureSession":
					//Afficher le formulaire d'authentification
					$this -> afficheVue("Entete");
					//Aller chercher le modèle approprié
                    $this -> afficheFormOuvertureSesssion();
					$this -> afficheVue("PiedDePage");
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
					break;*/
				default:
                    trigger_error("Action invalide.");
            }

            $this->afficheVue("Footer");
        }

        /*public function valideFormAjoutUtilisateur($pseudonyme, $motDePasse) {
            $erreurs = "";

            $pseudonyme = trim($pseudonyme);
			$motDePasse = trim($motDePasse);

            if($pseudonyme == "")
                $erreurs .= "<p class='centre erreur'>Le pseudonyme ne peut pas être vide.</p>";

            if(strlen($pseudonyme) > 30)
                $erreurs .= "<p class='centre erreur'>Le pseudonyme ne peut pas dépasser 30 caractères.</p>";
				
			if($motDePasse == "")
                $erreurs .= "<p class='centre erreur'>Le mot de passe ne peut pas être vide.</p>";

            if(strlen($motDePasse) > 30 || strlen($motDePasse) < 5)
                $erreurs .= "<p class='centre erreur'>Le mot de passe doit avoir entre 5 et 30 caractères.</p>";

            return $erreurs;
        }

        public function afficheFormAjoutUtilisateur($messageErreur = "") {
            //Afficher le formulaire d'ajout d'un Utilisateur
            //Aller porter les erreurs dans la vue
            $donnees["erreurs"] = $messageErreur;
            $this -> afficheVue("FormulaireAjoutUtilisateur", $donnees);
        }

		/*public function afficheFormOuvertureSesssion($messageErreur = "") {
            //Afficher le formulaire d'ouvertureSession
            //Aller porter les erreurs dans la vue
            $donnees["erreurs"] = $messageErreur;
            $this -> afficheVue("FormulaireOuvertureSession", $donnees);
        }*/
    }
?>