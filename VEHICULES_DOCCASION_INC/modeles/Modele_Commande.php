<?php
	class Modele_Commande extends TemplateDAO {
		
		/*--------------- Table commande ---------------*/

		//Ajouter une commande
		public function ajouterCommande($usagerId) {
			$requete = "INSERT INTO commande(dateCommande, quantite, usagerId, visibilite) 
				VALUES ('" . date('Y-m-d H:i:s') . "', 1, :uI, 1)";
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
				ON usagerId = idUtilisateur WHERE commandeVoiture.visibilite = 1 AND commandeNo = " . $commandeNo;
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
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
			$requete = "SELECT noFacture, dateFacture, prixFinal, idModePaiement, nomModeFR, nomModeEN, 
				idExpedition, nomExpeditonFR, nomExpeditionEN, usagerId, prenom, nom, voitureId
				FROM facture LEFT JOIN modepaiement ON 
					modePaiementId = idModePaiement");
				$requete -> execute();

				return $requete -> fetchAll(PDO::FETCH_ASSOC);
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

				return $requete->fetch(PDO::FETCH_ASSOC);
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