<?php
	class Modele_Commande extends TemplateDAO {
		
		/*--------------- Table commande ---------------*/

		//Ajouter une commande
		public function ajouterCommande($usagerId) {
			$requete = "INSERT INTO commande(dateCommande, usagerId, visibilite) VALUES ('" . date('Y-m-d H:i:s') . "', :uI, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":uI", $usagerId);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		//Toutes les commandes 
		public function obtenirCommandes() {
			try {
				$requete = $this -> connexion -> query("SELECT * FROM achat JOIN commande ON commandeNo = noCommande
					JOIN utilisateur ON usagerId = idUtilisateur");
				$requete -> execute();

				return $requete -> fetchAll();
			}
			catch(Exception $exc) {
				return 0;
			}
		}

		//Obtenir une seule commande donnée
		public function obtenirCommande($idCommande) {
			try {
				$requete = $this -> connexion -> query("SELECT * FROM commande WHERE noCommande = " . $idCommande);
				$requete -> execute();

				return $requete -> fetchAll();
			}
			catch(Exception $exc) {
				return 0;
			}
		}

		//Modifier une commande
		public function modifierCommande($usagerId, $noCommande) {
			$requete = "UPDATE commande SET usagerId = :usId WHERE noCommande = :noC";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":noC", $usagerId);
			$requetePreparee -> bindParam(":usId", $noCommande);
            $requetePreparee -> execute();
		}

		/*--------------- Table achat ---------------*/

		//Ajouter une commandeVoiture
		public function ajouterCommandeVoiture($commandeNo, $voitureId, $statutFR, $statutEN, $depot, $prixVente) {
			$requete = "INSERT INTO achat(commandeNo, voitureId, statutFR, statutEN, depot, prixVente, visibilite) 
				VALUES (:cNo, :vId, :sFR, :sEN, :de, :pV, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":cNo", $commandeNo);
			$requetePreparee -> bindParam(":vId", $voitureId);
			$requetePreparee -> bindParam(":sFR", $statutFR);
			$requetePreparee -> bindParam(":sEN", $statutEN);
			$requetePreparee -> bindParam(":de", $depot);
			$requetePreparee -> bindParam(":pV", $prixVente);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifierCommandeVoiture($commandeNo, $voitureId, $statutFR, $statutEN, $depot, $prixVente) {
			$requete = "UPDATE achat SET statutFR = :sFR, statutEN = :sEN, depot = :de, prixVente = :pV, 
                WHERE commandeNo = :cNo AND voitureId = :vId";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":sFR", $statutFR);
            $requetePreparee -> bindParam(":sEN", $statutEN);
            $requetePreparee -> bindParam(":de", $depot);
            $requetePreparee -> bindParam(":pV", $prixVente);
			$requetePreparee -> bindParam(":cNo", $commandeNo);
            $requetePreparee -> bindParam(":vId", $voitureId);
            $requetePreparee -> execute();
		}


		/*--------------- Table facture ---------------*/

		//Ajouter une facture
		public function ajouterFacture($expeditionFR, $expeditionEN, $prixFinal, $commandeId, $modePaiementId) {
			$requete = "INSERT INTO facture(dateFacture, expeditionFR, expeditionEN, prixFinal, commandeId, modePaiementId, 
				visibilite) VALUES ('" . date('Y-m-d H:i:s') . "', :exFR, :exEN, :pF, :cId, mP, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":exFR", $expeditionFR);
			$requetePreparee -> bindParam(":exEN", $expeditionEN);
			$requetePreparee -> bindParam(":pF", $prixFinal);
			$requetePreparee -> bindParam(":cId", $commandeId);
			$requetePreparee -> bindParam(":mP", $modePaiementId);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		//Toutes les factures
		public function obtenirFactures() {
			try {
				$requete = $this -> connexion -> query("SELECT noFacture, dateFacture, expeditionFR, expeditionEN,
					prixFinal, commandeId, nomModeFR, nomModeEN FROM facture LEFT JOIN modepaiement ON 
					modePaiementId = idModePaiement");
				$requete -> execute();

				return $requete -> fetchAll();
			}
			catch(Exception $exc) {
				return 0;
			}
		}

		//Facture d'une seule commande donnée
		public function obtenirFacture($idCommande) {
			try {
				$requete = $this->connexion->query("SELECT * FROM facture 
												LEFT JOIN modepaiement ON modePaiementId = idModePaiement
												WHERE commandeID = '" . $idCommande . "'");

				$requete->execute();

				return $requete->fetchAll();
			}
			catch(Exception $exc) {
				return 0;
			}
		}

		//Modifier une facture
		public function modifierFacture($expeditionFR, $expeditionEN, $prixFinal, $modePaiementId, $noFacture) {
			$requete = "UPDATE facture SET expeditionFR = :exFR, expeditionEN = :exEN, prixFinal = :pF, modePaiementId = :mP, 
                WHERE noFacture = :noF";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":exFR", $expeditionFR);
            $requetePreparee -> bindParam(":exEN", $expeditionEN);
            $requetePreparee -> bindParam(":pF", $prixFinal);
            $requetePreparee -> bindParam(":mP", $modePaiementId);
			$requetePreparee -> bindParam(":noF", $noFacture);
            $requetePreparee -> execute();
		}

		/*--------------- Table modePaiement ---------------*/

		//Ajouter un mode de paiement
		public function ajouterModePaiement($nomModeFR, $nomModeEN) {
			$requete = "INSERT INTO modePaiement(nomModeFR, nomModeEN, visibilite) VALUES (:nFR,:nEN, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomModeFR);
            $requetePreparee -> bindParam(":nEN", $nomModeEN);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		//Modifier un mode de paiement
		public function modifierModePaiement($nomModeFR, $nomModeEN, $idModePaiement) {
            $requete = "UPDATE modePaiement SET nomModeFR = :nFR, nomModeEN = :nEN WHERE idModePaiement = :idM";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomModeFR);
            $requetePreparee -> bindParam(":nEN", $nomModeEN);
            $requetePreparee -> bindParam(":idM", $idModePaiement);
            $requetePreparee -> execute();
        }
	}
?>