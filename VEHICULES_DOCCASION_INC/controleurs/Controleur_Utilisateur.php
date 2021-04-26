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
                case "accesEmploye":
                    //Page accessible seulement par les employés
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["utilisateurs"] = $modeleUtilisateur -> obtenir_utilisateurs();
                        $data["villes"] = $modeleUtilisateur -> obtenir_tous('ville');
                        $data["provinces"] = $modeleUtilisateur -> obtenir_tous('province');
                        $data["pays"] = $modeleUtilisateur -> obtenir_tous('pays');
                        $data["taxes"] = $modeleUtilisateur -> obtenir_tous('taxe');
                        $data["privileges"] = $modeleUtilisateur -> obtenir_tous('privilege');
                        $this -> afficheVue("AccesEmploye", $data);
                    } else {
                        header("Location: index.php?Utilisateur&action=connexion"); //Redirection vers le formulaire d'authentification
                    }
                    break;
                case "compte":
                    //Afficher le compte d'un utilisateur spécifique
                    if(isset($_SESSION["utilisateur"])) {
                        $utilisateurId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];
                        $data["utilisateur"] = $modeleUtilisateur -> obtenir_utilisateur($utilisateurId);
                        isset($_SESSION["employe"]) || isset($_SESSION["admin"]) ?
                        $this -> afficheVue("HeaderAdmin") : $this -> afficheVue("Header");
                        $this -> afficheVue("Compte", $data);
                    } else {
                        header("Location: index.php?Utilisateur&action=connexion"); //Redirection vers le formulaire d'authentification
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
                                $params["villeId"], 3, 1);
                            $ajoute = $modeleUtilisateur -> sauvegarde($nouvelUtilisateur);

                            if($ajoute)
                                //Redirection vers la page de connexion
                                header("Location: index.php?utilisateur&action=connexion");
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
				case "supprime":
                    if(isset($_SESSION["admin"])) {
                        if (isset($params["nomTable"]) && isset($params["id"])) {
                            $data["utilisateur"] = $modeleUtilisateur -> supprime('utilisateur', 'idUtilisateur', 
                            $params["id"]);
                            $data["utilisateurs"] = $modeleUtilisateur -> obtenir_tous();
                            $this -> afficheVue("AccesEmploye", $data);
                        }
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
							$this -> afficheFormOuvertureSesssion($messageErreur); //Redirection vers le formulaire d'authentification
						}
					} else
						header("Location: index.php?Utilisateur&action=connexion"); //Redirection vers le formulaire d'authentification
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
				default:
                    trigger_error("Action invalide.");
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