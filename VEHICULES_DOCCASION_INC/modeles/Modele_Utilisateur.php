<?php
	class Modele_Utilisateur extends TemplateDAO {
		
        public function getNomTable() {
            return "utilisateur";
        }

        public function getClePrimaire() {
            return "idUtilisateur";
        }

        public function obtenir_par_id($id) {
            //Appel d'obtenir_par_id du parent
            $resultat = parent::obtenir_par_id($id);
            $utilisateur = $resultat -> fetch();
            return $utilisateur;
        }
	}
?>