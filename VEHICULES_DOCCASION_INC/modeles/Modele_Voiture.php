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
		public function ajoutVoiture($noSerie, $descriptionFR, $descriptionEN, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId, $visibilite) {		
			try {
				$stmt = $this->connexion->prepare("INSERT INTO voiture (noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat, groupeMPid, corpsId, carburantId, modeleId, transmissionId, anneeId, visibilite) 
				VALUES (:noSerie, :descriptionFR, :descriptionEN, :kilometrage, :dateArrivee, :prixAchat, :groupeMPid, :corpsId, :carburantId, :modeleId, :transmissionId, :anneeId, :visibilite)");
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
				$stmt->bindParam(":visibilite", $visibilite);
				$stmt->execute();
				
				return 1;
			}	
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenirTous() {
			try {
				$stmt = $this->connexion->query("SELECT noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat,
				nomMotopro, nomCorpsFR, anneeId, nomModele, nomMarque, nomPhoto, ordre
				                                FROM voiture JOIN corps ON idCorps = corpsId
												LEFT OUTER JOIN motopropulseur ON idMotopro = groupeMPId
												LEFT OUTER JOIN modele ON idModele = modeleId
												LEFT OUTER JOIN marque ON idMarque = marqueId
												LEFT OUTER JOIN photo ON autoId = noSerie AND ordre = 1");

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
				nomMotopro, nomCorpsFR, anneeId, nomModele, nomMarque
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

		function modifVoiture($noSerie, $newNoSerie, $descriptionFR, $descriptionEN, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId, $visibilite) {		
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
												anneeId = '".$anneeId."' ,
												visibilite = '".$visibilite."'
												WHERE noSerie = '" . $noSerie . "'");
				$stmt->execute();
				return $stmt->fetchAll();
			}	
			catch(Exception $exc) {
				return 0;
			}

		}

		public function obtenir_Nom_ID($nomTable) { //Autres tables
			$requete = "SHOW KEYS FROM $nomTable WHERE Key_name = 'PRIMARY'";
			$resultats = $this -> connexion -> query($requete);
			$resultats -> execute();
			return $resultats -> fetchAll();
		}

		public function supprimeMed($nomTable, $nomId, $id) {
			$requete = "UPDATE $nomTable SET visibilite = 0 WHERE $nomId = :id";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":id", $id);
			$requetePreparee -> execute();

			//Retour du nombre de rangées affectées 
			return $requetePreparee -> rowCount();
		}

		//Partie Corps
		public function ajoutCorps() {
			//Ajouter le corps
		}

		public function modifCorps($id) {
			//Modificr le corps
		}

		//Partie Groupe motopropulseur
		public function ajoutGrpMoto() {
			//Ajouter motopropulseur
		}

		public function modifGrpMoto($id) {
			//Modifier motopropulseur
		}

		//Partie Carburant
		public function ajoutCarburant() {
			//Ajouter carburant
		}

		public function modifCarburant($id) {
			//Modifier carburant
		}

		//Partie Transmission
		public function ajoutTransmission() {
			//Ajouter transmission
		}

		public function modifTransmission($id) {
			//Modifer transmission
		}

		//Partie Annee
		public function ajoutAnnee() {
			//Ajouter une année
		}

		public function modifAnnee($id) {
			//Modifier une année
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