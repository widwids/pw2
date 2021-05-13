<?php
	class Controleur_Commande extends BaseControleur {		
        public function traite(array $params) {
            $data = array();

            //Modèle pour les commandes
            $modeleCommande = new Modele_Commande();

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

                case "ajouterCommande":
                    if(isset($_SESSION["utilisateur"])) {
                        $modeleUtilisateur =  new Modele_Utilisateur();
                        $usagerId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];

                        if(isset($params["voitureId"], $params["prixVente"], $params["depot"], $params["expeditionId"],
                            $params["modePaiementNo"])) {

                            $noCommande = $modeleCommande -> ajouterCommande($usagerId);

                            $listeVoitureId = explode(',', $params["voitureId"]);
                            $listePrixVente = explode(',', $params["prixVente"]);
                            $listeDepots = explode(',', $params["depot"]);
                            $listeStatutId = array();

                            foreach ($listeDepots as $depot) {
                                $depot > 0 ? $listeStatutId[] = 2 : $listeStatutId[] = 1;
                            }

                            for($i = 0; $i < count($listeVoitureId); $i++) {
                                $modeleCommande -> ajouterCommandeVoiture($noCommande, $listeVoitureId[$i], 
                                    $listePrixVente[$i], $listeDepots[$i], $listeStatutId[$i], $params["expeditionId"],
                                    $params["modePaiementNo"]);
                            }
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;

                case "ajouterCommandeEmploye":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["commandeNo"], $params["usagerId"], $params["voitureId"], 
                            $params["prixVente"], $params["statutId"], $params["expeditionId"], 
                            $params["modePaiementNo"])) {

                            if(!isset($params["depot"])) $params["depot"] = 0;
                            
                            if($modeleCommande -> obtenir_par_id('commande', 'noCommande', $params["commandeNo"])) {
                                $modeleCommande -> ajouterCommandeVoiture($params["commandeNo"], $params["voitureId"], 
                                    $params["prixVente"], $params["depot"], $params["statutId"], 
                                    $params["expeditionId"], $params["modePaiementNo"]);
                            } else {
                                $commandeNo = $modeleCommande -> ajouterCommande($params["usagerId"]);
                                $modeleCommande -> ajouterCommandeVoiture($commandeNo, $params["voitureId"], 
                                    $params["prixVente"], $params["depot"], $params["statutId"], 
                                    $params["expeditionId"], $params["modePaiementNo"]);
                            }
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;

                case "ajouterFacture":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["noFacture"], $params["prixFinal"])) {
                            
                            if($modeleCommande -> obtenir_par_id('facture', 'noFacture', $params["noFacture"])) {
                                $modeleCommande -> modifierFacture($params["noFacture"], $params["prixFinal"]);
                                
                            } else {
                                $modeleCommande -> ajouterFacture($params["noFacture"], $params["prixFinal"]);
                            }
                            $data["factures"] = $modeleCommande -> obtenirFactures();

                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;
                case "ajouterModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"])) {
                            $modeleCommande -> ajouterModePaiement($params["nomModeFR"], $params["nomModeEN"]);
                            $data["modePaiement"] = $modeleCommande -> obtenir_tous('modePaiement');

                            //$this -> afficheVue("ListeModePaiement", $data);
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
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("Panier", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        $data["villes"] = $modeleCommande -> obtenir_tous('ville');
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("Panier", $data);
                        $this -> afficheVue("Footer");
                    }
                    break;

                case "listeCommandes":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                        $data["commande"] = $modeleCommande -> obtenir_tous("commande");
                        $data["statuts"] = $modeleCommande -> obtenir_tous("statut");
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                        $data["utilisateurs"] = $modeleCommande -> obtenir_tous("utilisateur");
                        $data["voitures"] = $modeleCommande -> obtenir_tous("voiture");

                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeCommandesAdmin", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;    

                case "listeCommandesAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                        $data["commande"] = $modeleCommande -> obtenir_tous("commande");
                        $data["statuts"] = $modeleCommande -> obtenir_tous("statut");
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                        $data["utilisateurs"] = $modeleCommande -> obtenir_tous("utilisateur");
                        $data["voitures"] = $modeleCommande -> obtenir_tous("voiture");
                        
                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheCommande":
                    //Affiche une commande spécifique
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["commandeNo"])) {
                            $data["commande"] = $modeleCommande -> obtenirCommande($params["commandeNo"]);
                            
                            echo json_encode($data);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeFactures":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                        $data["commandes"] = $modeleCommande -> obtenir_tous("commande");
                        
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeFacturesAdmin", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;    

                case "listeFacturesAJAX":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        //$vue = "ListeFactures";
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                    
                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheFactureAJAX":
                    //Affiche une facture donnée
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["noFacture"])) {
                            //Affiche une Facture d'une commande donnée
                            //$vue = "Facture";
                            $data["facture"] = $modeleCommande -> obtenirFacture($params["noFacture"]);

                            echo json_encode($data);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["idModePaiement"])) {
                            $data["modePaiement"] = $modeleCommande -> obtenir_par_id('modePaiement', 'idModePaiement', $params["idModePaiement"]);

                            $this -> afficheVue("Head");
                            $this -> afficheVue("Header");
                            $this -> afficheVue("ListeModePaiement", $data);
                            $this -> afficheVue("Footer");
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheModePaiementAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["idModePaiement"])) {
                            $data["modePaiement"] = $modeleCommande -> obtenir_par_id('modePaiement', 'idModePaiement', $params["idModePaiement"]);

                            echo json_encode($data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeModePaiement", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeModePaiementAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                /*--------------- Modification(UPDATE) ---------------*/

                case "modifierCommande":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["commandeNo"], $params["usagerId"], $params["voitureId"], 
                            $params["prixVente"], $params["statutId"], $params["expeditionId"], 
                            $params["modePaiementNo"])) {

                            if(!isset($params["depot"])) $params["depot"] = 0;
                            
                            $modeleCommande -> modifierCommande($params["usagerId"], $params["commandeNo"]);
                            $modeleCommande -> modifierCommandeVoiture($params["commandeNo"], $params["voitureId"], 
                                $params["prixVente"], $params["depot"], $params["statutId"], $params["expeditionId"], 
                                $params["modePaiementNo"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "modifierFacture":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["noFacture"], $params["prixFinal"])) {
                            
                            $modeleCommande -> modifierFacture($params["noFacture"], $params["prixFinal"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                    
                case "modifierModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"], $params["idModePaiement"])) {
                            $modeleCommande -> modifierModePaiement($params["nomModeFR"], $params["nomModeEN"], $params["idModePaiement"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                
                /*--------------- "Suppression" (DELETE) ---------------*/
                case "suppressionCommande":
                    if(isset($_SESSION["admin"])) {
                        if (isset($params["commandeNo"], $params["voitureId"])) {
                            $modeleUtilisateur -> supprimerCommandeVoiture($params["commandeNo"], $params["voitureId"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }    
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

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
                    $this -> afficheVue("Head");
                    $this -> afficheVue("Header");
                    $this -> afficheVue("Page404");
                    $this -> afficheVue("Footer");
            }
        }
    }
?>