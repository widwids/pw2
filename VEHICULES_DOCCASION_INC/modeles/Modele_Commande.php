<?php
	class Modele_Commande extends TemplateDAO {
		
		/*--------------- Table commande ---------------*/

		//Ajouter une commande
		public function ajouterCommande($usagerId) {
			$requete = "INSERT INTO commande(dateCommande, usagerId, visibilite) 
				VALUES ('" . date('Y-m-d H:i:s') . "', :uI, 1)";
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
			$requete = "SELECT commandeNo, voitureId, prixVente, depot, statutId, expeditionId, modePaiementNo, 
				dateCommande, idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
				cellulaire, courriel, pseudonyme, villeId, nomExpeditionFR, nomExpeditionEN, nomStatutFR, 
				nomStatutEN, nomModeFR, nomModeEN FROM commandeVoiture JOIN statut ON statutId = idStatut 
				JOIN expedition ON expeditionId = idExpedition JOIN modePaiement ON 
				modePaiementNo = idModePaiement JOIN commande ON commandeNo = noCommande JOIN utilisateur 
				ON usagerId = idUtilisateur WHERE commandeVoiture.visibilite = 1";
			$resultats = $this -> connexion -> query($requete);
            $resultats -> execute();

            return $resultats -> fetchAll(PDO::FETCH_ASSOC);
		}

		//Obtenir une seule commande donnée
		public function obtenirCommande($commandeNo) {
			$requete = "SELECT commandeNo, voitureId, prixVente, depot, statutId, expeditionId, modePaiementNo,
				dateCommande, idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
				cellulaire, courriel, pseudonyme, villeId, nomExpeditionFR, nomExpeditionEN, nomStatutFR, 
				nomStatutEN, nomModeFR, nomModeEN FROM commandeVoiture JOIN statut ON statutId = idStatut 
				JOIN expedition ON expeditionId = idExpedition JOIN modePaiement ON modePaiementNo = 
				idModePaiement JOIN commande ON commandeNo = noCommande JOIN utilisateur 
				ON usagerId = idUtilisateur WHERE commandeVoiture.visibilite = 1 AND commandeNo = :cNo";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":cNo", $commandeNo);
            $requetePreparee -> execute();

            return $requetePreparee -> fetch(PDO::FETCH_ASSOC);			
		}

		//Modifier une commande
		public function modifierCommande($usagerId, $noCommande) {
			$requete = "UPDATE commande SET usagerId = :usId WHERE noCommande = :noC";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":noC", $usagerId);
			$requetePreparee -> bindParam(":usId", $noCommande);
            $requetePreparee -> execute();
		}

		/*--------------- Table commandeVoiture ---------------*/

		//Ajouter une commandeVoiture
		public function ajouterCommandeVoiture($commandeNo, $voitureId, $prixVente, $depot, $statuId, 
				$expeditionId, $modePaiementNo) {
			$requete = "INSERT INTO commandeVoiture(commandeNo, voitureId, prixVente, depot, statutId,
				expeditionId, modePaiementNo, visibilite) VALUES (:cNo, :vId, :pV, :de, :stId, :exId, :mP, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":cNo", $commandeNo);
			$requetePreparee -> bindParam(":vId", $voitureId);
			$requetePreparee -> bindParam(":pV", $prixVente);
			$requetePreparee -> bindParam(":de", $depot);
			$requetePreparee -> bindParam(":stId", $statuId);
			$requetePreparee -> bindParam(":exId", $expeditionId);
			$requetePreparee -> bindParam(":mP", $modePaiementNo);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifierCommandeVoiture($commandeNo, $voitureId, $prixVente, $depot, $statuId, 
				$expeditionId, $modePaiementNo) {
			$requete = "UPDATE commandeVoiture SET prixVente = :pV, depot = :de, statutId = :stId,
				expeditionId = :exId, modePaiementNo = :mP WHERE commandeNo = :cNo AND voitureId = :vId";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":cNo", $commandeNo);
			$requetePreparee -> bindParam(":vId", $voitureId);
			$requetePreparee -> bindParam(":pV", $prixVente);
			$requetePreparee -> bindParam(":de", $depot);
			$requetePreparee -> bindParam(":stId", $statuId);
			$requetePreparee -> bindParam(":exId", $expeditionId);
			$requetePreparee -> bindParam(":mP", $modePaiementNo);
            $requetePreparee -> execute();
		}

		public function supprimerCommandeVoiture($commandeNo, $voitureId) {
			$requete = "UPDATE commandeVoiture SET visibilite = 0 WHERE commandeNo = :cNo AND voitureId = :vId";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":cNo", $commandeNo);
			$requetePreparee -> bindParam(":vId", $voitureId);
            $requetePreparee -> execute();

            //Retour du nombre de rangées affectées 
            return $requetePreparee -> rowCount();
		}

		/*--------------- Table facture ---------------*/

		//Ajouter une facture
		public function ajouterFacture($noFacture, $prixFinal) {
			$requete = "INSERT INTO facture(noFacture, dateFacture, prixFinal, visibilite) 
				VALUES (:noF, '" . date('Y-m-d H:i:s') . "', :pF, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":noF", $noFacture);
			$requetePreparee -> bindParam(":pF", $prixFinal);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		//Toutes les factures
		public function obtenirFactures() {
			$requete = "SELECT noFacture, dateFacture, prixFinal, modePaiementNo, nomModeFR, nomModeEN, 
				expeditionId, nomExpeditionFR, nomExpeditionEN, usagerId, prenom, nom, GROUP_CONCAT(' ', voitureId) 
				AS voitureId FROM facture JOIN commande ON noFacture = noCommande JOIN commandeVoiture ON noCommande =
				commandeNo JOIN modePaiement ON modePaiementNo = idModePaiement JOIN expedition 
				ON expeditionId = idExpedition JOIN utilisateur ON usagerId = idUtilisateur 
				WHERE facture.visibilite = 1 AND statutId = 3 GROUP BY commandeNo";
			$resultats = $this -> connexion -> query($requete);
			$resultats -> execute();

			return $resultats -> fetchAll(PDO::FETCH_ASSOC);
		}

		//Facture d'une seule commande donnée
		public function obtenirFacture($noFacture) {
			$requete = "SELECT noFacture, dateFacture, prixFinal, modePaiementNo, nomModeFR, nomModeEN, 
			expeditionId, nomExpeditionFR, nomExpeditionEN, usagerId, prenom, nom, GROUP_CONCAT(' ', voitureId) 
			AS voitureId FROM facture JOIN commande ON noFacture = noCommande JOIN commandeVoiture ON noCommande =
			commandeNo JOIN modePaiement ON modePaiementNo = idModePaiement JOIN expedition 
			ON expeditionId = idExpedition JOIN utilisateur ON usagerId = idUtilisateur 
			WHERE facture.visibilite = 1 AND statutId = 3 AND noFacture = :nF GROUP BY commandeNo";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nF", $noFacture);
            $requetePreparee -> execute();

            return $requetePreparee -> fetch(PDO::FETCH_ASSOC);	
		}

		//Modifier une facture
		public function modifierFacture($noFacture, $prixFinal) {
			$requete = "UPDATE facture SET prixFinal = :pF, visibilite = 1 WHERE noFacture = :noF";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":pF", $prixFinal);
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