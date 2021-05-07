<?php
	class Modele_Utilisateur extends TemplateDAO {
		
        /*--------------- Table utilisateur ---------------*/

        //Authentification de l'utilisateur
        public function authentification($pseudonyme, $motDePasse) {
            //Déterminer si la combinaison identifiant et mot de passe est valide
			$requete = "SELECT motDePasse FROM utilisateur WHERE pseudonyme = :ps AND utilisateur.visibilite = 1";
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

        /* Insertion (CREATE) */

        //Ajout d'un nouvel utilisateur
        public function ajouterUtilisateur(Utilisateur $utilisateur) {
            $requetePreparee = $this -> connexion -> prepare("INSERT INTO utilisateur (prenom, nom, 
                dateNaissance, adresse, codePostal, telephone, cellulaire, courriel, pseudonyme, 
                motDePasse, villeId, privilegeId, visibilite) 
                VALUES (:pr,:nm,:dn,:ad,:cp,:te,:ce,:co,:ps,:mo,:vi, 3, 1)");
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
            $requetePreparee -> bindParam(":dn", $dateNaissance);
            $requetePreparee -> bindParam(":ad", $adresse);
            $requetePreparee -> bindParam(":cp", $codePostal);
            $requetePreparee -> bindParam(":te", $telephone);
            $requetePreparee -> bindParam(":ce", $cellulaire);
            $requetePreparee -> bindParam(":co", $courriel);
            $requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> bindParam(":mo", $motDePasse);
            $requetePreparee -> bindParam(":vi", $villeId);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
                return $this -> connexion -> lastInsertId();
            else
                return false;
        }

        /* Lecture (READ) */

        //Obtenir tous les utilisateurs
        public function obtenir_utilisateurs() {
            //Fetch un tableau d'utilisateurs
            $requete = "SELECT idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
            cellulaire, courriel, pseudonyme, motDePasse, idVille, nomVilleFR, nomVilleEN, codeProvince, 
            nomProvinceFR, nomProvinceEN, idPays, nomPaysFR, nomPaysEN, privilegeId, nomPrivilegeFR, 
            nomPrivilegeEN FROM utilisateur JOIN ville ON villeId = idVille 
            JOIN province ON provinceCode = codeProvince JOIN pays ON paysId = idPays 
            JOIN privilege ON privilegeId = idPrivilege WHERE utilisateur.visibilite = 1";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            $utilisateurs = $resultats -> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Utilisateur");
            return $utilisateurs;
        }

        //Obtenir un utilisateur par idUtilisateur
        public function obtenir_utilisateur($id) {
            $requete = "SELECT idUtilisateur, prenom, nom, dateNaissance, adresse, codePostal, telephone, 
                cellulaire, courriel, pseudonyme, motDePasse, idVille, nomVilleFR, nomVilleEN, codeProvince, 
                nomProvinceFR, nomProvinceEN, idPays, nomPaysFR, nomPaysEN, privilegeId, nomPrivilegeFR, 
                nomPrivilegeEN FROM utilisateur JOIN ville ON villeId = idVille 
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

        //Déterminer le type d'utilisateur
        public function obtenir_privilege($pseudonyme) {
			$requete = "SELECT privilegeId FROM utilisateur WHERE pseudonyme = :ps";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> execute();
			$resultat = $requetePreparee -> fetch();
			
			return $resultat[0];
		}

        //Obtenir la taxe par utilisateur
        public function obtenir_taxe_utilisateur($idUtilisateur) {
            $requete = "SELECT nomTaxeFR, nomTaxeEn, provinceId, taux FROM taxe JOIN taxeProvince ON idTaxe = taxeId
                JOIN province ON provinceId = codeProvince JOIN ville ON codeProvince = provinceCode JOIN utilisateur
                ON idVille = villeId WHERE idUtilisateur = :idU";
			$requetePreparee = $this -> connexion -> prepare($requete);
			$requetePreparee -> bindParam(":idU", $idUtilisateur);
            $requetePreparee -> execute();
			$resultat = $requetePreparee -> fetchAll(PDO::FETCH_ASSOC);
			
			return $resultat;
        }

        /* Modification (UPDATE) */
        
        //Modification d'un nouvel utilisateur
        public function modifierUtilisateur(Utilisateur $utilisateur) {
            $requete = "UPDATE utilisateur SET prenom = :pr, nom = :nm, dateNaissance = :dN, 
                adresse = :ad, codePostal = :cP, telephone = :te, cellulaire = :ce, courriel = :co, 
                pseudonyme = :ps, motDePasse = :mP, villeId = :vId, privilegeId = :pId
                WHERE idUtilisateur = :idU";
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
            $requetePreparee -> bindParam(":pId", $privilegeId);
            $requetePreparee -> bindParam(":idU", $id);
            $requetePreparee -> execute();
        }

        //Modification mot de passe
        public function modifierMotDePasse($motDePasse, $pseudonyme) {
            $requete = "UPDATE utilisateur SET motDePasse = :mP WHERE pseudonyme = :ps";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":mP", $motDePasse);
            $requetePreparee -> bindParam(":ps", $pseudonyme);
            $requetePreparee -> execute();
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

        public function obtenir_villes() {
            $requete = "SELECT * FROM ville JOIN province ON provinceCode = codeProvince 
                WHERE ville.visibilite = 1";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            return $resultats -> fetchAll(PDO::FETCH_ASSOC);
        }

        //Modifier ville
        public function modifierVille($nomVilleFR, $nomVilleEN, $provinceCode, $idVille) {
            $requete = "UPDATE ville SET nomVilleFR = :nFR, nomVilleEN = :nEN, provinceCode = :pC 
                WHERE idVille = :idV";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomVilleFR);
            $requetePreparee -> bindParam(":nEN", $nomVilleEN);
            $requetePreparee -> bindParam(":pC", $provinceCode);
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

        public function obtenir_provinces() {
            $requete = "SELECT * FROM province JOIN pays ON paysId = idPays 
                WHERE province.visibilite = 1";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            return $resultats -> fetchAll(PDO::FETCH_ASSOC);
        }

        //Modifier province
        public function modifierProvince($nomProvinceFR, $nomProvinceEN, $paysId, $codeProvince) {
            $requete = "UPDATE province SET nomProvinceFR = :nFR, nomProvinceEN = :nEN, paysId = :pId
                WHERE codeProvince = :cP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomProvinceFR);
            $requetePreparee -> bindParam(":nEN", $nomProvinceEN);
            $requetePreparee -> bindParam(":pId", $paysId);
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
        public function modifierPays($nomPaysFR, $nomPaysEN, $idPays) {
            $requete = "UPDATE pays SET nomPaysFR = :nFR, nomPaysEN = :nEN WHERE idPays = :idP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPaysFR);
            $requetePreparee -> bindParam(":nEN", $nomPaysEN);
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
        public function modifierTaxe($nomTaxeFR, $nomTaxeEN, $idTaxe) {
            $requete = "UPDATE taxe SET nomTaxeFR = :nFR, nomTaxeEN = :nEN WHERE idTaxe = :idT";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomTaxeFR);
            $requetePreparee -> bindParam(":nEN", $nomTaxeEN);
            $requetePreparee -> bindParam(":idT", $idTaxe);
            $requetePreparee -> execute();
        }

        /*--------------- Table taxeProvince ---------------*/

        //Ajouter la taxe dans la table taxeProvince
        public function ajouterTaxeProvince($provinceId, $taxeId, $taux) {
            $requete = "INSERT INTO taxeProvince(provinceId, taxeId, taux) VALUES (:pId,:tId, :ta)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":pId", $provinceId);
            $requetePreparee -> bindParam(":tId", $taxeId);
            $requetePreparee -> bindParam(":ta", $taux);
            $requetePreparee -> execute();
            
            if($requetePreparee -> rowCount() > 0)
				return $this -> connexion -> lastInsertId();
			else
				return false;
        }

        //Modifier la taxe dans la table taxeProvince
        public function modifierTaxeProvince($provinceId, $taxeId, $taux) {
            $requete = "UPDATE taxeProvince SET provinceId = :pId, taux = :ta WHERE provinceId = :pId AND taxeId = :tId";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":pId", $provinceId);
            $requetePreparee -> bindParam(":ta", $taux);
            $requetePreparee -> bindParam(":tId", $taxeId);
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
        public function modifierPrivilege($nomPrivilegeFR, $nomProvinceEN, $idPrivilege) {
            $requete = "UPDATE privilege SET nomPrivilegeFR = :nFR, nomPrivilegeEN = :nEN WHERE idPrivilege = :idP";
			$requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":nFR", $nomPrivilegeFR);
            $requetePreparee -> bindParam(":nEN", $nomPrivilegeEN);
            $requetePreparee -> bindParam(":idP", $idPrivilege);
            $requetePreparee -> execute();
        }
        
        /*--------------- Table connexion ---------------*/

        //Ajouter la connexion de l'utilisateur
        public function ajouterConnexion($idUtilisateur) {
           $requete = "INSERT INTO connexion (idConnexion, adresseIp, dateConnexion, visibilite) 
                VALUES (:idC, '" . $_SERVER["REMOTE_ADDR"] . "', '" . date('Y-m-d H:i:s') . "', 1)";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":idC", $idUtilisateur);
            $requetePreparee -> execute();

            if($requetePreparee -> rowCount() > 0)
                return $this -> connexion -> lastInsertId();
            else
                return false;
        }

        //Modifier une connexion
        public function modifierConnexion($idUtilisateur) {
            $requete = "UPDATE connexion SET adresseIp = '" . $_SERVER["REMOTE_ADDR"] . "', dateConnexion = '" .
                date('Y-m-d H:i:s') . "', visibilite = 1 WHERE idConnexion = :id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $idUtilisateur);
            $requetePreparee -> execute();
        }
	}
?>