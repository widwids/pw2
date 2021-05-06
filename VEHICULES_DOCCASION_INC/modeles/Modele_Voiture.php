<?php
	class Modele_Voiture extends TemplateDAO {

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
				$stmt = $this->connexion->query("SELECT * FROM modele JOIN marque ON marqueId = IdMarque WHERE modele.visibilite = 1 ");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenir_UNE_marque_modele($idModele) {
			try {
				$stmt = $this->connexion->query("SELECT * FROM modele JOIN marque ON marqueId = IdMarque
												 WHERE  idModele = '" . $idModele . "'");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}

		public function obtenirUneVoiture($noSerie) {
			try {
				$stmt = $this -> connexion -> query("SELECT noSerie, descriptionFR, descriptionEN, kilometrage, 
				dateArrivee, prixAchat, nomMotopro, nomCorpsFR, nomCorpsEN, typeCarburantFR, typeCarburantEN,
				nomModele, nomMarque, nomTransmissionFR, nomTransmissionEN, anneeId, groupeMPId, corpsId, carburantId, modeleId, transmissionId 
						FROM voiture JOIN corps ON idCorps = corpsId
						LEFT OUTER JOIN motopropulseur ON idMotopro = groupeMPId
						LEFT OUTER JOIN modele ON idModele = modeleId
						LEFT OUTER JOIN marque ON idMarque = marqueId
						LEFT OUTER JOIN carburant ON idCarburant = carburantId
						LEFT OUTER JOIN transmission ON idTransmission = transmissionId
						WHERE noSerie = '" . $noSerie . "'");

				$stmt->execute();
				return $stmt->fetchAll(PDO::FETCH_ASSOC);

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
												anneeId = '".$anneeId."',
												visibilite = 1
												WHERE noSerie = '" . $noSerie . "'");
				$stmt->execute();
				return $stmt->fetchAll();
			}	
			catch(Exception $exc) {
				return 0;
			}

		}

		//Partie Corps
		//Ajouter un corps
		public function ajoutCorps($nomCorpsFR, $nomCorpsEN) {
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

		public function obtenirCorp($id) {
            $requete = "SELECT * FROM corps WHERE idCorps =:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }

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
		public function ajoutMotoProp($nomMotopro) {
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

		
		public function obtenirMotoProp($id) {
            $requete = "SELECT * FROM motopropulseur WHERE idMotopro =:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }
		public function modifMotoProp($idMotopro, $nomMotopro, $visibilite) {
            $requete = "UPDATE motopropulseur SET nomMotopro = :nomMotopro,
                visibilite = :visibilite WHERE idMotopro = :idMotopro";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomMotopro", $nomMotopro);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idMotopro", $idMotopro);
            $requetePreparee -> execute();
		}

		//Partie Carburant
		public function ajoutCarburant($typeCarburantFR, $typeCarburantEN) {
			$requete = "INSERT INTO carburant(typeCarburantFR, typeCarburantEN, visibilite) VALUES 
				(:typeCarburantFR,:typeCarburantEN,1)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":typeCarburantFR", $typeCarburantFR);
			$requetePreparee -> bindParam(":typeCarburantEN", $typeCarburantEN);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function obtenirCarburant($id) {
            $requete = "SELECT * FROM carburant WHERE idCarburant =:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }

		public function modifCarburant($idCarburant, $typeCarburantFR, $typeCarburantEN, $visibilite) {
            $requete = "UPDATE carburant SET idCarburant = :idCarburant, typeCarburantFR = :typeCarburantFR, typeCarburantEN = :typeCarburantEN,
                visibilite = :visibilite WHERE idCarburant = :idCarburant";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":typeCarburantFR", $typeCarburantFR);
            $requetePreparee -> bindParam(":typeCarburantEN", $typeCarburantEN);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idCarburant", $idCarburant);
            $requetePreparee -> execute();
		}

		//Partie Transmission
		public function ajoutTransmission($nomTransmissionFR, $nomTransmissionEN) {
			$requete = "INSERT INTO transmission (nomTransmissionFR, nomTransmissionEN, visibilite) VALUES 
				(:nomTransmissionFR,:nomTransmissionEN, 1 )";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomTransmissionFR", $nomTransmissionFR);
			$requetePreparee -> bindParam(":nomTransmissionEN", $nomTransmissionEN);
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

		public function obtenirTransmission($idTransmission) {
            $requete = "SELECT * FROM transmission WHERE idTransmission =:idTransmission";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":idTransmission", $idTransmission);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }
		//Partie Annee
		public function ajoutAnnee($annee) {
			$requete = "INSERT INTO annee(Annee) VALUES 
				(:Annee, 1 )";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":annee", $annee);
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


		public function obtenirAnnee($annee) {
            $requete = "SELECT * FROM annee WHERE annee =:annee";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":annee", $annee);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }


		//Partie Modele
		public function ajoutModele($nomModele, $marqueId) {
			$requete = "INSERT INTO modele (nomModele, marqueId, visibilite) VALUES 
				(:nomModele,:marqueId, 1 )";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomModele", $nomModele);
			$requetePreparee -> bindParam(":marqueId", $marqueId);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifModle($idModele,$nomModele, $marqueId, $visibilite) {
			$requete = "UPDATE modele SET nomModele = :nomModele, marqueId = :marqueId,
                visibilite = :visibilite WHERE idModele = :idModele";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomModele", $nomModele);
            $requetePreparee -> bindParam(":marqueId", $marqueId);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idModele", $idModele);
            $requetePreparee -> execute();
		}

		//Partie Marque
		public function ajoutMarque($nomMarque) {
			$requete = "INSERT INTO marque (nomMarque, visibilite) VALUES 
				(:nomMarque, 1 )";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomMarque", $nomMarque);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}

		public function modifMarque($idMarque,$nomMarque, $visibilite) {
			$requete = "UPDATE marque SET nomMarque = :nomMarque,
            			visibilite = :visibilite WHERE idMarque = :idMarque";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nomMarque", $nomMarque);
            $requetePreparee -> bindParam(":visibilite", $visibilite);
            $requetePreparee -> bindParam(":idMarque", $idMarque);
            $requetePreparee -> execute();
		}
		
		public function ajoutPhotoVoiture($nomPhoto, $ordre, $autoId) {
			echo 'dddddddd',$nomPhoto;
			echo $ordre;
			echo $autoId;
			$requete = "INSERT INTO photo (nomPhoto, ordre, autoId, visibilite) VALUES 
				(:nomPhoto, :ordre,:autoId, 1)";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":nomPhoto", $nomPhoto);
			$requetePreparee -> bindParam(":ordre", $ordre);
			$requetePreparee -> bindParam(":autoId", $autoId);
			$requetePreparee -> execute();
			
			if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
		}


		/* function chargerImage($image_nom){

			$target_dir = "images/livres/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
	
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
			$n_target_file = $target_dir . $image_nom . "." . $imageFileType;
	
			// Check if image file is a actual image or fake image
			if(isset($_POST["bouton_ajouter"])) {
				$check = getimagesize($_FILES["image"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
	
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 1;
			}
	
			// Check file size
			if ($_FILES["image"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
	
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
	
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0){
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			}else{
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $n_target_file)) {
					//echo "The file ". $n_target_file. " has been uploaded.";
				}else{
					echo "Sorry, there was an error uploading your file.";
				}
			}
	
		} */

	}
?>