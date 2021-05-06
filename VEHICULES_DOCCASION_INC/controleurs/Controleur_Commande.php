<?php
	class Controleur_Commande extends BaseControleur {		
        public function traite(array $params) {
            $data = array();

            //Modèle pour les commandes
            $modeleCommande = new Modele_Commande();
            
			$this -> afficheVue("Head");
			isset($_SESSION["employe"]) || isset($_SESSION["admin"]) ?
                $this -> afficheVue("HeaderAdmin") : $this -> afficheVue("Header");

            if(isset($params["action"])) {
				$action = $params["action"]; 
            } else {
                //Commande par défaut
                $action = "affichePanier";
            }

            // Switch en fonction de l'action qui nous est envoyée
            // Ce switch détermine la vue $vue et obtient le modèle $data
            switch($action) {

                /*--------------- Insertion(CREATE) ---------------*/

                case "formulaireAjoutCommande":
                    $this -> afficheVue("FormulaireAjoutCommande");
                    break;

                case "ajouterCommande":
                    if(isset($_SESSION["utilisateur"])) {
                        $modeleUtilisateur =  new Modele_Utilisateur();
                        $usagerId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];

                        if(isset($params["voitureId"], $params["prixVente"])) {
                            if(!isset($params["depot"])) $params["depot"] = null;

                            $noCommande = $modeleCommande -> ajouterCommande($usagerId);

                            $listeVoitureId = explode(',', $params["voitureId"]);
                            $listePrixVente = explode(',', $params["prixVente"]);

                            for($i = 0; $i < count($listeVoitureId); $i++) {
                                $modeleCommande -> ajouterCommandeVoiture($noCommande, $listeVoitureId[$i], 
                                $params["depot"], $listePrixVente[$i]);
                            }
                            
                            //$data["commandes"] = $modeleCommande -> obtenirCommandes();

                            //$this -> afficheVue("ListeCommandes", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;

                case "formulaireAjoutFature":
                    $this -> afficheVue("FormulaireAjoutFacture");
                    break;

                case "ajouterFacture":
                    if(isset($params["expeditionFR"], $params["expeditionEN"], $params["prixFinal"], $params["commandeId"],
                        $params["modePaiementId"])) {
                        
                        $modeleCommande -> ajouterFacture($params["expeditionFR"], $params["expeditionEN"], 
                            $params["prixFinal"], $params["commandeId"], $params["modePaiementId"]);
                        
                        $data["factures"] = $modeleCommande -> obtenirFactures();

                        $this -> afficheVue("ListeFactures", $data);
                    } else {
                        trigger_error("Paramètre manquant.");
                    }
                    break;

                case "formulaireAjoutModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $this -> afficheVue("FormulaireAjoutModePaiement");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "ajouterModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"])) {
                            $modeleCommande -> ajouterModePaiement($params["nomModeFR"], $params["nomModeEN"]);
                            $data["modePaiement"] = $modeleCommande -> obtenirModePaiement();

                            $this -> afficheVue("ListeModePaiement", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                /*--------------- Lecture(READ) ---------------*/
                
                case "affichePanier":
                    if(isset($_SESSION["utilisateur"])) {
                        $modeleUtilisateur =  new Modele_Utilisateur();
                        $usagerId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];
                        $data["taxes"] = $modeleUtilisateur -> obtenir_taxe_utilisateur($usagerId);
                        $this -> afficheVue("Panier", $data);
                    } else {
                        $data["villes"] = $modeleCommande -> obtenir_tous('ville');
                        $this -> afficheVue("Panier", $data);
                    }
                    break;

                case "afficheCommandes":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $vue = "ListeCommandes";
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                        
                        echo json_encode($data);
                        //$this -> afficheVue($vue, $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheCommande":
                    //Affiche une commande spécifique
                    if (isset($params["idCommande"])) {
                        //Affiche une commande donnée

                        //$vue = "Commande";
                        $data["commande"] = $modeleCommande -> obtenirCommande($params["idCommande"]);
                        $modeleVoiture = new Modele_Voiture();
                        $data["voiture"] = $modeleVoiture -> obtenirUneVoiture($data["commande"]["voitureId"])[0];
                        
                        echo json_encode($data);
                        //$this -> afficheVue($vue, $data); 
                    } else {													
                        $this -> afficheVue("Page404");
                    } 
                    break;

                case "afficheFactures":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        //$vue = "ListeFactures";
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                    
                        echo json_encode($data);
                        //$this -> afficheVue($vue, $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheFacture":
                    //Affiche une facture donnée
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["idCommande"])) {
                            //Affiche une Facture d'une commande donnée
                            //$vue = "Facture";
                            $data["facture"] = $modeleCommande -> obtenirFacture($params["idCommande"]);

                            echo json_encode($data);
                            //$this -> afficheVue($vue, $data);
                        } else {													
                            $this -> afficheVue("Page404");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheModePaiement":
                    //$vue = "ListeModePaiement";
                    $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                    echo json_encode($data);
                    //$this -> afficheVue($vue, $data);
                    break;

                /*--------------- Modification(UPDATE) ---------------*/

                case "modifierCommande":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["usagerId"], $params["noCommande"], $params["voitureId"], $params["statutFR"],
                            $params["statutEN"], $params["depot"], $params["prixVente"])) {
                            
                            $modeleCommande -> modifierCommande($params["usagerId"], $params["noCommande"]);
                            $modeleCommande -> modifierCommandeVoiture($params["noCommande"], $params["voitureId"], 
                                $params["statutFR"], $params["statutEN"], $params["depot"], $params["prixVente"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                case "modifierFacture":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["expeditionFR"], $params["expeditionEN"], $params["prixFinal"], 
                            $params["modePaiementId"], $params["noFacture"])) {
                            
                            $modeleCommande -> modifierFacture($params["expeditionFR"], $params["expeditionEN"],
                                $params["prixFinal"], $params["modePaiementId"], $params["noFacture"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;
                    
                case "modifierModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"], $params["idModePaiement"])) {
                            $modeleCommande -> modifierModePaiement($params["nomModeFR"], $params["nomModeEN"]);
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
                            $nomId = $modeleCommande -> obtenir_nom_id($params["nomTable"]);
                            $modeleCommande -> supprime($params["nomTable"], $nomId, $params["id"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
					break;
                default:
                    $this -> afficheVue("Page404");
            }

            $this -> afficheVue("Footer");
        }
    }
?>