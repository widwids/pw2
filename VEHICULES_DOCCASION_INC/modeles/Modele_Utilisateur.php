<?php
	class Modele_Utilisateur extends TemplateDAO {
		
        public function getNomTable() {
            return "utilisateur";
        }

        public function getClePrimaire() {
            return "idUtilisateur";
        }

        public function obtenir_tous() {
            //Appel d'obtenir_tous du parent et on fetch un tableau d'utilisateurs
            $resultats = parent::obtenir_tous();
            $utilisateurs = $resultats -> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Utilisateur");
            return $utilisateurs;
        }

        public function obtenir_par_id($id) {
            $requete = "SELECT idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
                cellulaire, courriel, pseudonyme, motDePasse, idVille, nomVille, codeProvince, nomProvince, 
                idPays, nomPays, privilegeId, nomPrivilege FROM utilisateur JOIN ville ON villeId = idVille 
                JOIN province ON provinceCode = codeProvince JOIN pays ON paysId = idPays 
                JOIN privilege ON privilegeId = idPrivilege WHERE idUtilisateur = :id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();
            $resultat = $requetePreparee -> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Utilisateur")[0];
            return $resultat;
        }

        public function obtenir_par_pseudonyme($pseudonyme) {

        }
    
        public function sauvegarde(Utilisateur $utilisateur) {
             //L'utilisateur que j'essaie de sauvegarder existe-t-il déjà (id différent de zéro)?
             if($utilisateur -> getId() != 0) {
                //Mise à jour -- UPDATE
				$requete = "UPDATE utilisateur SET prenom = :pr, nom = :nm, dateNaissance = :dN, 
                    adresse = :ad, codePostal = :cP, telephone = :te, cellulaire = :ce, courriel = :co, 
                    pseudonyme = :ps, motDePasse = :mP, villeId = :vI WHERE id = :id";
				$requetePreparee = $this -> connexion -> prepare($requete);
                $prenom = $utilisateur -> getPrenom();
                $nom = $utilisateur -> getNom();
                $dateNaissance = $utilisateur -> getDateNaissance();
                $adresse = $utilisateur -> getAdresse();
                $codePostal = $utilisateur -> getCodePostal();
                $telephone = $utilisateur -> getTelephone();
                $cellulaire = $utilisateur -> getCellulaire();
                $courriel = $utilisateur -> getCourriel();
                $pseudonyme = $utilisateur -> getPseudonyme();
                $motDePasse = $utilisateur -> getMotDePasse();
                $villeId = $utilisateur -> getVilleId();
				$id = $utilisateur -> getId();
                $requetePreparee -> bindParam(":pr", $prenom);
                $requetePreparee -> bindParam(":nm", $nom);
                $requetePreparee -> bindParam(":dN", $dateNaissance);
                $requetePreparee -> bindParam(":ad", $adresse);
                $requetePreparee -> bindParam(":cP", $codePostal);
                $requetePreparee -> bindParam(":te", $telephone);
                $requetePreparee -> bindParam(":ce", $cellulaire);
                $requetePreparee -> bindParam(":co", $courriel);
                $requetePreparee -> bindParam(":ps", $pseudonyme);
                $requetePreparee -> bindParam(":mP", $motDePasse);
                $requetePreparee -> bindParam(":vI", $villeId);
				$requetePreparee -> bindParam(":id", $id);
                $requetePreparee -> execute();
            } else {
                //Ajout d'un nouvel utilisateur
                $requete = "INSERT INTO utilisateur(prenom, nom, dateNaissance, adresse, codePostal, telephone, 
                    cellulaire, courriel, pseudonyme, motDePasse, villeId) VALUES 
                    (:pr,:nm,:dN,:ad,:cP,:te,:ce,:co,:ps,:mP,:vI)";
                $prenom = $utilisateur -> getPrenom();
                $nom = $utilisateur -> getNom();
                $dateNaissance = $utilisateur -> getDateNaissance();
                $adresse = $utilisateur -> getAdresse();
                $codePostal = $utilisateur -> getCodePostal();
                $telephone = $utilisateur -> getTelephone();
                $cellulaire = $utilisateur -> getCellulaire();
                $courriel = $utilisateur -> getCourriel();
                $pseudonyme = $utilisateur -> getPseudonyme();
                $motDePasse = $utilisateur -> getMotDePasse();
                $villeId = $utilisateur -> getVilleId();
                $requetePreparee -> bindParam(":pr", $prenom);
                $requetePreparee -> bindParam(":nm", $nom);
                $requetePreparee -> bindParam(":dN", $dateNaissance);
                $requetePreparee -> bindParam(":ad", $adresse);
                $requetePreparee -> bindParam(":cP", $codePostal);
                $requetePreparee -> bindParam(":te", $telephone);
                $requetePreparee -> bindParam(":ce", $cellulaire);
                $requetePreparee -> bindParam(":co", $courriel);
                $requetePreparee -> bindParam(":ps", $pseudonyme);
                $requetePreparee -> bindParam(":mP", $motDePasse);
                $requetePreparee -> bindParam(":vI", $villeId);
                $requetePreparee -> execute();

				if($requetePreparee -> rowCount() > 0)
					return $this -> connexion -> lastInsertId();
				else
					return false;
            }
        }

        public function authentification($pseudonyme, $motDePasse) {

        }
	}
?>