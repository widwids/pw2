<?php
	abstract class TemplateDAO {
		
		protected $connexion;
		
		public function __construct() {
			$this->connexion = new PDO("mysql:host=localhost;dbname=concessionnaire", "root", "");
			$this->connexion->exec("SET NAMES'UTF8'"); // Affichage des caractères UTF8
		}

        //Obtenir le nom de la clé primaire
        public function obtenir_nom_id($nomTable) {
			$requete = "SHOW KEYS FROM $nomTable WHERE Key_name = 'PRIMARY'";
			$resultats = $this -> connexion -> query($requete);
			$resultats -> execute();
			return $resultats -> fetch()[4];
		}

		//Lecture(READ)
        public function obtenir_par_id($nomTable, $nomId, $id) {
            $requete = "SELECT * FROM $nomTable WHERE $nomId =:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee -> fetch();
        }

        public function obtenir_tous($nomTable) {
            $requete = "SELECT * FROM $nomTable WHERE $nomTable.visibilite = 1";
            $resultats = $this -> connexion -> query($requete);
            $resultats -> execute();
            return $resultats -> fetchAll();
        }

        //"Suppression" (DELETE)
        public function supprime($nomTable, $nomId, $id) {
            $requete = "UPDATE $nomTable SET visibilite = 0 WHERE $nomId = :id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour du nombre de rangées affectées 
            return $requetePreparee -> rowCount();
        }
	}
?>