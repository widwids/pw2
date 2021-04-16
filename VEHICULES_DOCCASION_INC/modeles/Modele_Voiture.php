<?php
	class Modele_Voiture extends TemplateDAO {
		
		public function getNomTable() {
            return "voiture";
        }

        public function getClePrimaire() {
            return "noSerie";
        }
		
		//partie Voiture
		
		public function obtenirTous() {
			try {
				$stmt = $this->connexion->query("SELECT noSerie, kilometrage, prixAchat, dateArrivee, photoAccueil, nomMotoPro, nomCorps, 
												anneeId, nomModele, nomMarque
				                                FROM voiture JOIN Corps ON IdCorps = corpsId
                        						LEFT OUTER JOIN motopropulseur ON idMotoPro = groupeMPId
												LEFT OUTER JOIN modele ON idModele = modeleId
												LEFT OUTER JOIN marque ON idMarque = marqueId");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenirUneVoiture($noSerie) {
			try {
				$stmt = $this->connexion->query("SELECT noSerie, kilometrage, prixAchat, dateArrivee, photoAccueil, nomMotoPro, nomCorps, 
												anneeId, nomModele, nomMarque
				                                FROM voiture JOIN Corps ON IdCorps = corpsId
                        						LEFT OUTER JOIN motopropulseur ON idMotoPro = groupeMPId
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
		

		public function ajoutVoiture($noSerie, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId, $photoAccueil) {		
			try {
				$stmt = $this->connexion->prepare("INSERT INTO voiture (noSerie, kilometrage, dateArrivee, prixAchat, groupeMPid, corpsId, carburantId, modeleId, transmissionId, anneeId, photoAccueil) 
				VALUES (:noSerie, :kilometrage, :dateArrivee, :prixAchat, :groupeMPid, :corpsId, :carburantId, :modeleId, :transmissionId, :anneeId, :photoAccueil)");
				$stmt->bindParam(":noSerie", $noSerie);
				$stmt->bindParam(":kilometrage", $kilometrage);
				$stmt->bindParam(":dateArrivee", $dateArrivee);
				$stmt->bindParam(":prixAchat", $prixAchat);
				$stmt->bindParam(":groupeMPid", $groupeMPid);
				$stmt->bindParam(":corpsId", $corpsId);
				$stmt->bindParam(":carburantId", $carburantId);
				$stmt->bindParam(":modeleId", $modeleId);
				$stmt->bindParam(":transmissionId", $transmissionId);
				$stmt->bindParam(":anneeId", $anneeId);
				$stmt->bindParam(":photoAccueil", $photoAccueil);
				$stmt->execute();
				
				return 1;
			}	
			catch(Exception $exc) {
				return 0;
			}
		}

		function modifVoiture($noSerie, $newNoSerie, $kilometrage, $dateArrivee, $prixAchat, $groupeMPid, $corpsId, $carburantId, $modeleId, $transmissionId, $anneeId, $photoAccueil) {		
			try {
				$stmt = $this->connexion->query("UPDATE voiture 
												SET noSerie = '".$newNoSerie."', 
												kilometrage = '".$kilometrage."',
												dateArrivee = '".$dateArrivee."' , 
												prixAchat = '".$prixAchat."' ,
												groupeMPid = '".$groupeMPid."' ,
												corpsId = '".$corpsId."' ,
												carburantId = '".$carburantId."' ,
												modeleId = '".$modeleId."' ,
												transmissionId = '".$transmissionId."' ,
												anneeId = '".$anneeId."' ,
												photoAccueil = '".$photoAccueil."' 
												WHERE noSerie = '" . $noSerie . "'");
				$stmt->execute();
				return $stmt->fetchAll();
			}	
			catch(Exception $exc) {
				return 0;
			}

		}

		//Partie Corps
		public function obtenirCorps() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM corps ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifCorps($id) {

		}

		public function suppCorps($id) {

		}

		public function ajoutCorps() {

		}

		//Partie Groupe motopropulseur

		public function obtenirGrpMoto() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM motoptopulseur ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifGrpMoto($id) {

		}

		public function suppGrpMoto($id) {

		}

		public function ajoutGrpMoto() {

		}

		//Partie  Carburant

		public function obtenirCarburant() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM carburant ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifCarburant($id) {

		}

		public function suppCarburant($id) {

		}

		public function ajoutCarburant() {

		}

		//Partie  Transmission

		public function obtenirTransmission() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM carburant ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifTransmission($id) {

		}

		public function suppTransmission($id) {

		}

		public function ajoutTransmission() {

		}

		//Partie  Annee

		public function obtenirAnnee() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM annee ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifAnnee($id) {

		}

		public function suppAnnee($id) {

		}

		public function ajoutAnnee() {

		}

		//Partie  Photos

		public function obtenirPhotoVoiture($noSerie) {
			//var_dump($NoSerie);
			 try {
				$stmt = $this->connexion->query("SELECT nomPhoto FROM photo WHERE autoId = '" . $noSerie . "'");

				
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}  
		}

		public function obtenirPhotos() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM photo ");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}
		public function modifPhoto($id) {

		}

		public function suppPhoto($id) {

		}

		public function ajoutPhoto() {

		}

		//Partie  Modele

		public function obtenirModeles() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM modele");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifModle($id) {

		}

		public function suppModele($id) {

		}

		public function ajoutModele() {

		}
	
		//Partie  Marque

		public function obtenirMarque() {
			try {
				$stmt = $this->connexion->query("SELECT * FROM marque");
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function modifMarque($id) {

		}

		public function suppMarque($id) {

		}

		public function ajoutMarque() {

		}
	}
?>