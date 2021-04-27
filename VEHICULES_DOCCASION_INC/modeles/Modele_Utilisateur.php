<?php
	class Modele_Utilisateur extends TemplateDAO {
		
        /*--------------- Table utilisateur ---------------*/

        /* Lecture(READ) */

        //Obtenir tous les utilisateurs
        public function obtenir_utilisateurs() {
            //Fetch un tableau d'utilisateurs
            $requete = "SELECT * FROM utilisateur";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            $utilisateurs = $resultats -> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Utilisateur");
            return $utilisateurs;
        }

        //Obtenir un utilisateur par idUtilisateur
        public function obtenir_utilisateur($id) {
            $requete = "SELECT idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
                cellulaire, courriel, pseudonyme, motDePasse, idVille, nomVilleFR, nomVilleEN, codeProvince, nomProvinceFR, nomProvinceEN, 
                idPays, nomPaysFR, nomPaysEN, privilegeId, nomPrivilegeFR, nomPrivilegeEN FROM utilisateur JOIN ville ON villeId = idVille 
                JOIN province ON provinceCode = codeProvince JOIN pays ON paysId = idPays 
                JOIN privilege ON privilegeId = idPrivilege WHERE idUtilisateur = :id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();
            $requetePreparee -> setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Utilisateur');
            return $requetePreparee -> fetch();
        }

        //Utilisateur par pseudonyme
        public function obtenir_par_pseudonyme($pseudonyme) {         
            $requete = "SELECT * FROM utilisateur WHERE pseudonyme = :ps";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> execute();
			$utilisateur = $requetePreparee -> fetch();

            //Retour de l'identifiant de la dernière insertion
            return $utilisateur;
        }
        
        /* Insertion (CREATE) et modification (UPDATE) */

        //Insérer ou modifier un utilisateur
        public function sauvegarde(Utilisateur $utilisateur) {
             //L'utilisateur que j'essaie de sauvegarder existe-t-il déjà (id différent de zéro)?
             if($utilisateur -> getId() != 0) {
                //Mise à jour -- UPDATE
				$requete = "UPDATE utilisateur SET prenom = :pr, nom = :nm, dateNaissance = :dN, 
                    adresse = :ad, codePostal = :cP, telephone = :te, cellulaire = :ce, courriel = :co, 
                    pseudonyme = :ps, motDePasse = :mP, villeId = :vId WHERE idUtilisateur = :id";
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
                $requetePreparee -> bindParam(":vId", $villeId);
				$requetePreparee -> bindParam(":id", $id);
                $requetePreparee -> execute();
            } else {
                //Ajout d'un nouvel utilisateur -- CREATE
                $requete = "INSERT INTO utilisateur(prenom, nom, dateNaissance, adresse, codePostal, telephone, 
                    cellulaire, courriel, pseudonyme, motDePasse, villeId, privilegeId, visiblite) VALUES 
                    (:pr,:nm,:dN,:ad,:cP,:te,:ce,:co,:ps,:mP,:vId, :pId, 1)";
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
                $privilegeId = $utilisateur -> getPrivilegeId();
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
                $requetePreparee -> bindParam(":vId", $villeId);
                $requetePreparee -> bindParam(":pId", $privilegeId);
                $requetePreparee -> execute();

				if($requetePreparee -> rowCount() > 0)
					return $this -> connexion -> lastInsertId();
				else
					return false;
            }
        }

        //Authentification de l'utilisateur
        public function authentification($pseudonyme, $motDePasse) {
            //Déterminer si la combinaison identifiant et mot de passe est valide
			$requete = "SELECT motDePasse FROM utilisateur WHERE pseudonyme = :ps";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> execute();
			$resultat = $requetePreparee -> fetch();
			
			//Y'a-t-il une rangée retournée? Déterminer si un utilisateur avec ce pseudonyme existe
			if($requetePreparee -> rowCount() > 0) {
				//Utiliser password_verify pour comparer le mot de passe tapé par l'usager avec le mot de passe encrypté contenu dans la base de données
				if(password_verify($motDePasse, $resultat[0]))
					return true;
			}
			return false;
        }

        //Déterminer le type d'utilisateur
        public function obtenir_privilege($pseudonyme) {
			$requete = "SELECT privilegeId FROM utilisateur WHERE pseudonyme = :ps";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> execute();
			$resultat = $requetePreparee -> fetch();
			
			return $resultat[0];
		}

        /*--------------- Table ville ---------------*/

        //Ajouter une ville
        public function ajouterVille($nomVilleFR, $nomVilleEN, $provinceCode) {
            $requete = "INSERT INTO ville(nomVilleFR, nomVilleEN, provinceCode, visibilite) VALUES 
                (:nFR,:nEN,:pC, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomVilleFR);
            $requetePreparee -> bindParam(":nEN", $nomVilleEN);
            $requetePreparee -> bindParam(":pC", $provinceCode);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier ville
        public function modifierVille($nomVilleFR, $nomVilleEN, $provinceCode, $visibilite, $idVille) {
            $requete = "UPDATE ville SET nomVilleFR = :nFR, nomVilleEN = :nEN, provinceCode = :pC, 
                visibilite = :v WHERE idVille = :idV";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomVilleFR);
            $requetePreparee -> bindParam(":nEN", $nomVilleEN);
            $requetePreparee -> bindParam(":pC", $provinceCode);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idV", $idVille);
            $requetePreparee -> execute();
        }

        /*--------------- Table province ---------------*/

        //Ajouter une province
        public function ajouterProvince($nomProvinceFR, $nomProvinceEN, $paysId) {
            $requete = "INSERT INTO province(nomProvinceFR, nomProvinceEN, paysId, visibilite) VALUES 
                (:nFR,:nEN,:pId, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomProvinceFR);
            $requetePreparee -> bindParam(":nEN", $nomProvinceEN);
            $requetePreparee -> bindParam(":pId", $paysId);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier province
        public function modifierProvince($nomProvinceFR, $nomProvinceEN, $paysId, $visibilite, $codeProvince) {
            $requete = "UPDATE province SET nomProvinceFR = :nFR, nomProvinceEN = :nEN, paysId = :pId, 
                visibilite = :v WHERE codeProvince = :cP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomProvinceFR);
            $requetePreparee -> bindParam(":nEN", $nomProvinceEN);
            $requetePreparee -> bindParam(":pId", $paysId);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":cP", $codeProvince);
            $requetePreparee -> execute();
        }

        /*--------------- Table pays ---------------*/

        //Ajouter un pays
        public function ajouterPays($nomPaysFR, $nomPaysEN) {
            $requete = "INSERT INTO pays(nomPaysFR, nomPaysEN, visibilite) VALUES (:nFR,:nEN, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPaysFR);
            $requetePreparee -> bindParam(":nEN", $nomPaysEN);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier un pays
        public function modifierPays($nomPaysFR, $nomPaysEN, $visibilite, $idPays) {
            $requete = "UPDATE pays SET nomPaysFR = :nFR, nomPaysEN = :nEN, visibilite = :v WHERE idPays = :idP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPaysFR);
            $requetePreparee -> bindParam(":nEN", $nomPaysEN);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idP", $idPays);
            $requetePreparee -> execute();
        }

        /*--------------- Table taxe ---------------*/

        //Ajouter une taxe
        public function ajouterTaxe($nomTaxeFR, $nomTaxeEN) {
            $requete = "INSERT INTO taxe(nomTaxeFR, nomTaxeEN, visibilite) VALUES (:nFR,:nEN, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomTaxeFR);
            $requetePreparee -> bindParam(":nEN", $nomTaxeEN);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier la taxe
        public function mofifierTaxe($nomTaxeFR, $nomTaxeEN, $visibilite, $idTaxe) {
            $requete = "UPDATE taxe SET nomTaxeFR = :nFR, nomTaxeEN = :nEN, visibilite = :v WHERE idTaxe = :idT";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomTaxeFR);
            $requetePreparee -> bindParam(":nEN", $nomTaxeEN);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idT", $idTaxe);
            $requetePreparee -> execute();
        }

        /*--------------- Table privilege ---------------*/

        //Ajout privilège
        public function ajouterPrivilege($nomPrivilegeFR, $nomProvinceEN) {
            $requete = "INSERT INTO privilege(nomPrivilegeFR, nomPrivilegeEN, visibilite) VALUES (:nFR,:nEN, 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPrivilegeFR);
            $requetePreparee -> bindParam(":nEN", $nomPrivilegeEN);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier le privilège
        public function modifierPrivilege($idPrivilege) {
            $requete = "UPDATE privilege SET nomPrivilegeFR = :nFR, nomPrivilegeEN = :nEN, visibilite = :v 
                WHERE idPrivilege = :idP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPrivilegeFR);
            $requetePreparee -> bindParam(":nEN", $nomPrivilegeEN);
            $requetePreparee -> bindParam(":v", $visibilite);
            $requetePreparee -> bindParam(":idP", $idPrivilege);
            $requetePreparee -> execute();
        }
        
        /*--------------- Table connexion ---------------*/

        //Toutes les connexions
        public function getConnexions() {
            
        }

        //Connexion d'un utilisateur
        public function getConnexion($idUtilisateur) {
            
        }
	}
?>