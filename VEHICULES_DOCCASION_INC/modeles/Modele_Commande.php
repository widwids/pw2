<?php
	class Modele_Commande extends TemplateDAO {
		
		public function getNomTable() {
            return "commande";
        }

        public function getClePrimaire() {
            return "noCommande";
        }
		
		public function ajoutCommande() {
			//Ajouter une commande
		}

		//Toutes les commandes 
		public function obtenirCommandes() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM commande JOIN utilisateur ON idUtilisateur = usagerId");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		//Obtenir une seule commande donnée
		public function obtenirCommande($idCommande) {
			try {
				$stmt = $this->connexion->query("SELECT * FROM commande WHERE noCommande = '" . $idCommande . "'");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifierCommande($idCommande) {
			//Modifier commande
		}

		public function supprimerCommande($idCommande) {
			//Supprimer commande
		}

		//Facture d'une seule commande donnée
		public function obtenirFacture($idCommande) {
			try {
				$stmt = $this->connexion->query("SELECT * FROM facture 
												LEFT JOIN modepaiement ON modePaiementId = idModePaiement
												WHERE commandeID = '" . $idCommande . "'");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}
		
		public function obtenirFactures() {
			//Toutes les factures
		}
	}
?>