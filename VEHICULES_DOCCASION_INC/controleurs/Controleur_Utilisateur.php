<?php
	class Controleur_Utilisateur extends BaseControleur {		
        public function traite(array $params) {
			$data = array();

            //Modèle pour les utilisateurs
            $modeleUtilisateur =  new Modele_Utilisateur();

            $this -> afficheVue("Head");
			$this -> afficheVue("Header");

            if(isset($params["action"])) {
				$commande = $params["action"]; 
            } else {
                //Commande par défaut
                $commande = "connexion";
            }
        
            //Détermine la vue, remplir le modèle approprié
            switch($commande) {
                case "listeComptes":
                    if ($_SESSION["administrateur"]) {
                        $data["utilisateurs"] = $modeleUtilisateur -> obtenir_utilisateurs();
                        $this -> afficheVue("AccesEmploye", $data);
                    }
                    break;
                case "compte":
                    session_start();
                    //Afficher un utilisateur spécifique à partir de l'ID
                    if(isset($_SESSION["utilisateur"])) {
                        if(isset($params["id"])) {
                            $data["utilisateur"] = $modeleUtilisateur -> obtenir_utilisateur($params["id"]);
                            $this -> afficheVue("Compte", $data);
                        } else {
                            //Code 404
                            trigger_error("404. Pas d'id spécifié pour l'utilisateur.");
                         }
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
                            $params["telephone"], $params["courriel"],
                            $params["pseudonyme"], $params["motDePasse"]);
                        if($messageErreur == "") {
                            //Insertion du nouvel Utilisateur
                            $nouvelUtilisateur = new Utilisateur(0, $params["prenom"], $params["nom"], 
                                $params["dateNaissance"], $params["adresse"],$params["codePostal"], 
                                $params["telephone"], $params["cellulaire"], $params["courriel"],
                                $params["pseudonyme"], password_hash($params["motDePasse"], PASSWORD_DEFAULT),
                                $params["villeId"], 3, 1);
                            $modeleUtilisateur -> sauvegarde($nouvelUtilisateur);

                            //Redirection vers la page de connexion
                            header("Location: index.php?utilisateur&action=authentification");
                        } else {
                            //Afficher le formulaire d'ajout d'un utilisateur
                            $this -> afficheFormAjoutUtilisateur($messageErreur);   
                        }
                    } else {
                        trigger_error("Un ou plusieurs paramètres manquants.");
                    }
                    break;
				case "supprimeUtilisateur":
					if(isset($params["id"])) {
						$data["utilisateur"] = $modeleUtilisateur -> supprime('utilisateur', 'idUtilisateur', 
                        $params["id"]);
			            $data["utilisateurs"] = $modeleUtilisateur -> obtenir_tous();
                        $this -> afficheVue("AccesEmploye", $data);
					}
					break;
				case "authentification":
                    session_start();
					if(isset($params["pseudonyme"], $params["motDePasse"])) {
						
						$authentifier = $modeleUtilisateur -> authentification($params["pseudonyme"], 
                            $params["motDePasse"]);
						if($authentifier) {
							$_SESSION["utilisateur"] = $params["pseudonyme"];
							header("Location: index.php?action=compte&id=1");
						} else {
							$messageErreur = "La combinaison de l'identifiant et du mot de passe est invalide.";
							$this -> afficheFormOuvertureSesssion($messageErreur); //Redirection vers le formulaire d'authentification
						}
					} else
						header("Location: index.php?Utilisateur&action=connexion"); //Redirection vers le formulaire d'authentification
					break;
				case "connexion":
					//Afficher le formulaire d'authentification
					//Aller chercher le modèle approprié
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

            if(strlen($pseudonyme) > 20)
                $erreurs .= "<p>Le pseudonyme ne peut pas dépasser 20 caractères.</p>";
				
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