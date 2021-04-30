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
                $action = "afficheCommande";
            }

            // Switch en fonction de l'action qui nous est envoyée
            // Ce switch détermine la vue $vue et obtient le modèle $data
            switch($action) {
                case "afficheCommandes":
                    //Affiche toutes les commandes
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $vue = "ListeCommandes";
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                    
                        $this -> afficheVue($vue, $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "afficheCommande":
                    //Affiche une commande spécifique
                    if (isset($params["idCommande"])) {
                        //Affiche une commande donnée
                        $vue = "Commande";
                        $data["commande"] = $modeleCommande -> obtenirCommande($params["idCommande"]);

                        $this -> afficheVue($vue, $data); 
                    } else {													
                        $this -> afficheVue("Page404");
                    } 
                    break;
                case "afficheFactures":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $vue = "ListeFactures";
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                    
                        $this -> afficheVue($vue, $data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                case "afficheFacture":
                    //Affiche une facture donnée
                    if (isset($params["idCommande"])) {
                        //Affiche une Facture d'une commande donnée
                        $vue = "Facture";
                        $data["facture"] = $modeleCommande -> obtenirFacture($params["idCommande"]);

                        $this -> afficheVue($vue, $data);
                    } else {													
                        $this -> afficheVue("Page404");
                    }
                    break;
                case "afficheModePaiement":
                    $vue = "ListeModePaiement";
                    $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                    $this -> afficheVue($vue, $data);
                    break;
                default:
                    $this -> afficheVue("Page404");
            }

            $this->afficheVue("Footer");
        }
    }
?>