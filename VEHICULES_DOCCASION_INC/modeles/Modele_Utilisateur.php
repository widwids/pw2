<?php
	class Modele_Utilisateur extends TemplateDAO {
		
        public function getNomTable() {
            return "utilisateur";
        }

        public function getClePrimaire() {
            return "idUtilisateur";
        }

        public function obtenir_par_id($id) {
            //Appel d'obtenir_par_id du parent et on crée un objet Usager à partir de la rangée retournée
            $resultat = parent::obtenir_par_id($id);
            $resultat -> setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Utilisateur");
            $utilisateur = $resultat -> fetch();
            return $utilisateur;
        }
	}
?>