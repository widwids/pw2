<?php
	class Modele_Voiture extends TemplateDAO {
		
		public function getNomTable() {
            return "voiture";
        }

        public function getClePrimaire() {
            return "noSerie";
        }
		
		/* public function obtenir_par_id($id)
        {
            //on appelle obtenir_par_id du parent et on créé un objet Utilisateur à partir de la rangée retournée
            $resultats = parent::obtenir_par_id($id);
            $resultats->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , "Film");
            $leUtilisateur = $resultats->fetch();
            return $leUtilisateur;
        } */
		

		//Partie Voiture
		public function ajoutVoiture($noSerie, $descriptionFR, $descriptionEN, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId) {		
			try {
				$stmt = $this->connexion->prepare("INSERT INTO voiture (noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat, groupeMPid, corpsId, carburantId, modeleId, transmissionId, anneeId, visibilite) 
				VALUES (:noSerie, :descriptionFR, :descriptionEN, :kilometrage, :dateArrivee, :prixAchat, :groupeMPid, :corpsId, :carburantId, :modeleId, :transmissionId, :anneeId, 1 )");
				$stmt->bindParam(":noSerie", $noSerie);
				$stmt->bindParam(":descriptionFR", $descriptionFR);
				$stmt->bindParam(":descriptionEN", $descriptionEN);
				$stmt->bindParam(":kilometrage", $kilometrage);
				$stmt->bindParam(":dateArrivee", $dateArrivee);
				$stmt->bindParam(":prixAchat", $prixAchat);
				$stmt->bindParam(":groupeMPid", $groupeMPid);
				$stmt->bindParam(":corpsId", $corpsId);
				$stmt->bindParam(":carburantId", $carburantId);
				$stmt->bindParam(":modeleId", $modeleId);
				$stmt->bindParam(":transmissionId", $transmissionId);
				$stmt->bindParam(":anneeId", $anneeId);
				$stmt->execute();
				
				return 1;
			}	
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenirListeVoiture() {
			try {
				$stmt = $this->connexion->query("SELECT noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat,
				nomMotopro, nomCorpsFR, nomCorpsEN, typeCarburantFR, typeCarburantEN, anneeId, nomModele, nomMarque, nomPhoto, ordre, nomTransmissionFR, nomTransmissionEN 
				                                FROM voiture JOIN corps ON idCorps = corpsId
												LEFT OUTER JOIN motopropulseur ON idMotopro = groupeMPId
												LEFT OUTER JOIN modele ON idModele = modeleId
												LEFT OUTER JOIN marque ON idMarque = marqueId
												LEFT OUTER JOIN carburant ON idCarburant = carburantId
												LEFT OUTER JOIN transmission ON idTransmission = transmissionId
												LEFT OUTER JOIN photo ON autoId = noSerie AND ordre = 1
												WHERE voiture.visibilite = 1 ");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenir_marque_modele() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM modele JOIN marque ON marqueId = IdMarque ");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenirUneVoiture($noSerie) {
			try {
				$stmt = $this->connexion->query("SELECT noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat,
				nomMotopro, nomCorpsFR, anneeId, nomModele, nomMarque, groupeMPId, corpsId, carburantId, modeleId, transmissionId, anneeId, marqueId 
				                                FROM voiture JOIN corps ON idCorps = corpsId
												LEFT OUTER JOIN motopropulseur ON idMotopro = groupeMPId
												LEFT OUTER JOIN modele ON idModele = modeleId
												LEFT OUTER JOIN marque ON idMarque = marqueId
												WHERE noSerie = '" . $noSerie . "'");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}
		
		public function obtenirPhotoVoiture($noSerie) {
			//var_dump($NoSerie);
			 try {
				$stmt = $this->connexion->query("SELECT * FROM photo WHERE autoId = '" . $noSerie . "'");

				
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}  
		}

		function modifVoiture($noSerie, $newNoSerie, $descriptionFR, $descriptionEN, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId) {		
			try {
				$stmt = $this->connexion->query("UPDATE voiture 
												SET noSerie = '".$newNoSerie."', 
												descriptionFR = '".$descriptionFR."',
												descriptionEN = '".$descriptionEN."',
												kilometrage = '".$kilometrage."',
												dateArrivee = '".$dateArrivee."' , 
												prixAchat = '".$prixAchat."' ,
												groupeMPid = '".$groupeMPid."' ,
												corpsId = '".$corpsId."' ,
												carburantId = '".$carburantId."' ,
												modeleId = '".$modeleId."' ,
												transmissionId = '".$transmissionId."' ,
												anneeId = '".$anneeId."'
												WHERE noSerie = '" . $noSerie . "'");
				$stmt->execute();
				return $stmt->fetchAll();
			}	
			catch(Exception $exc) {
				return 0;
			}

		}

		/* public function obtenir_Nom_ID($nomTable) { //Autres tables
			$requete = "SHOW KEYS FROM $nomTable WHERE Key_name = 'PRIMARY'";
			$resultats = $this -> connexion -> query($requete);
			$resultats -> execute();
			return $resultats -> fetchAll();
		} */

		/* public function supprimeMed($nomTable, $nomId, $id) {
			$requete = "UPDATE $nomTable SET visibilite = 0 WHERE $nomId = :id";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":id", $id);
			$requetePreparee -> execute();

			//Retour du nombre de rangées affectées 
			return $requetePreparee -> rowCount();
		} */

		//Partie Corps
		//Ajouter un corps
		public function ajouterCorps($nomCorpsFR, $nomCorpsEN) {
			$requete = "INSERT INTO corps(nomCorpsFR, nomCorpsEN, visibilite) VALUES 
				(:nomCorpsFR,:nomCorpsEN, 1 )";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomCorpsFR", $nomCorpsFR);
			$requetePreparee -> bindParam(":nomCorpsEN", $nomCorpsEN);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}
		/* public function obtenir_nom_idd($nomTable) {
            $requete = "SHOW KEYS FROM $nomTable WHERE Key_name = 'PRIMARY'";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            return $resultats -> fetch()[4];
        } */

		// Modifi Corps
		public function modifCorps($idCorps, $nomCorpsFR, $nomCorpsEN, $visibilite) {
            echo 'dddd';
			$requete = "UPDATE corps SET nomCorpsFR = :nomCorpsFR, nomCorpsEN = :nomCorpsEN,
                visibilite = :visibilite WHERE idCorps = :idCorps";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomCorpsFR", $nomCorpsFR);
            $requetePreparee -> bindParam(":nomCorpsEN", $nomCorpsEN);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idCorps", $idCorps);
            $requetePreparee -> execute();
		}

		//Partie Groupe motopropulseur
		public function ajoutGrpMoto($nomMotopro ) {
			$requete = "INSERT INTO motopropulseur(nomMotopro, visibilite) VALUES 
				(:nomMotopro,1)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomMotopro", $nomMotopro);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifGrpMoto($id, $nomCorpsFR, $nomCorpsEN, $visibilite) {
            $requete = "UPDATE motopropulseur SET nomCorpsFR = :nomCorpsFR, nomCorpsEN = :nomCorpsEN,
                visibilite = :visibilite WHERE idCorps = :idCorps";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomCorpsFR", $nomCorpsFR);
            $requetePreparee -> bindParam(":nomCorpsEN", $nomCorpsEN);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idCorps", $idCorps);
            $requetePreparee -> execute();
		}

		//Partie Carburant
		public function ajoutCarburant($typeCarburantFR, $typeCarburantEN, $visibilite) {
			$requete = "INSERT INTO carburant(typeCarburantFR, typeCarburantEN, visibilite) VALUES 
				(:typeCarburantFR,:typeCarburantEN,:visibilite)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":typeCarburantFR", $typeCarburantFR);
			$requetePreparee -> bindParam(":typeCarburantEN", $typeCarburantEN);
			$requetePreparee -> bindParam(":visibilite", $visibilite);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifCarburant($id, $nomCorpsFR, $nomCorpsEN, $visibilite) {
            $requete = "UPDATE carburant SET nomCorpsFR = :nomCorpsFR, nomCorpsEN = :nomCorpsEN,
                visibilite = :visibilite WHERE idCorps = :idCorps";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomCorpsFR", $nomCorpsFR);
            $requetePreparee -> bindParam(":nomCorpsEN", $nomCorpsEN);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idCorps", $idCorps);
            $requetePreparee -> execute();
		}

		//Partie Transmission
		public function ajoutTransmission($nomTransmissionFR, $nomTransmissionEN, $visibilite) {
			$requete = "INSERT INTO transmission(nomTransmissionFR, nomTransmissionEN, visibilite) VALUES 
				(:nomTransmissionFR,:nomTransmissionEN,:visibilite)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomTransmissionFR", $nomTransmissionFR);
			$requetePreparee -> bindParam(":nomTransmissionEN", $nomTransmissionEN);
			$requetePreparee -> bindParam(":visibilite", $visibilite);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifTransmission($idTransmission, $nomTransmissionFR, $nomTransmissionEN, $visibilite) {
            $requete = "UPDATE transmission SET nomTransmissionFR = :nomTransmissionFR, nomTransmissionEN = :nomTransmissionEN,
                visibilite = :visibilite WHERE idTransmission = :idTransmission";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomTransmissionFR", $nomTransmissionFR);
            $requetePreparee -> bindParam(":nomTransmissionEN", $nomTransmissionEN);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idTransmission", $idTransmission);
            $requetePreparee -> execute();
		}

		//Partie Annee
		public function ajoutAnnee($annee, $visibilite) {
			$requete = "INSERT INTO annee(Annee, visibilite) VALUES 
				(:Annee,:visibilite)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":annee", $Annee);
			$requetePreparee -> bindParam(":visibilite", $visibilite);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifAnnee($annee, $visibilite) {
            $requete = "UPDATE annee SET annee = :annee, visibilite = :visibilite WHERE annee = :annee";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":annee", $annee);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> execute();
		}

		//Partie Photo
		public function ajoutPhoto() {
			//Ajouter une photo
		}

		public function modifPhoto($id) {
			//Modifier photo
		}

		//Partie Modele
		public function ajoutModele() {
			//Ajouter un modèle
		}

		public function modifModle($id) {
			//Modifier modèle
		}

		//Partie Marque
		public function ajoutMarque() {
			//Ajouter une marque
		}

		public function modifMarque($id) {
			//Modifier une marque
		}


	}
?>