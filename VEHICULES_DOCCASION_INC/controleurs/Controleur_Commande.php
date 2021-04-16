<?php
	class Controleur_Commande extends BaseControleur {		
        public function traite(array $params) {

			$this->afficheVue("Head");
			$this->afficheVue("Header");
			
			if (isset($params["action"])) {
				// Modèle et vue vides par défaut
				$data = array();
				
				// Switch en fonction de l'action qui nous est envoyée
				// Ce switch détermine la vue $vue et obtient le modèle $data
				switch($params["action"]) {
                
                    case "afficheCommandes":
					
					    //affiche toutes les commandes ////
						$modeleCommandes = new Modele_Commande();
						
						$commandes = $modeleCommandes->obtenirCommandes();
						var_dump($commandes);
						/////////////////////
						//$this->afficheVue($vue,$data); 

					break;
                    case "afficheFactureCommande":
                        if (isset($params["idCommande"])) {
                            
                            $modeleCommandes = new Modele_Commande();
                            //affiche une Facture d'une commande donnée
                            $facture = $modeleCommandes->obtenirFacture($params["idCommande"]);
                            var_dump($facture);
                            //affiche une commande donnée
                            $commande = $modeleCommandes->obtenirCommande($params["idCommande"]);
                            var_dump($commande);
                            /////////////////////
                            //$this->afficheVue($vue,$data); 
                        } else {													
                            echo "ERROR PARAMS";
                        } 
					break;
				}
            }else {

				
			}

            $this->afficheVue("Footer");
        }
    }
?>