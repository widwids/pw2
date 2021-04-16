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

        }

        public function authentification($pseudonyme, $motDePasse) {

        }
	}
?>