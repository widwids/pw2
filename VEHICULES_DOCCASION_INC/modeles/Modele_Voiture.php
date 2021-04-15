<?php
	class Modele_Voiture extends TemplateDAO {
		
		public function getNomTable() {
            return "voiture";
        }

        public function getClePrimaire() {
            return "noSerie";
        }
		
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
		
		public function obtenirUneVoiture($NoSerie) {
			//var_dump($NoSerie);
			 try {
				$stmt = $this->connexion->query("SELECT nomPhoto  FROM photo WHERE autoId =" .$NoSerie);
				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}  
		}

		
	}
?>