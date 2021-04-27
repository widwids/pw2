<?php
	abstract class TemplateDAO {
		
		protected $connexion;
		
		public function __construct() {
			$this->connexion = new PDO("mysql:host=localhost;dbname=concessionnaire", "root", "");
			$this->connexion->exec("SET NAMES'UTF8'"); // Affichage des caractères UTF8
		}

        public function obtenir_nom_id($nomTable) {
			$requete = "SELECT column_name FROM information_schema.key_column_usage WHERE constraint_schema = 
                'concessionnaire' AND constraint_name = 'primary' AND table_name = '$nomTable'";
			$resultats = $this -> connexion -> query($requete);
			$resultats -> execute();
			return $resultats -> fetch()[0];
		}

		//Lecture(READ)
        public function obtenir_par_id($nomTable, $nomId, $id) {
            $requete = "SELECT * FROM $nomTable WHERE $nomId =:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee;
        }

        public function obtenir_tous($nomTable) {
            $requete = "SELECT * FROM $nomTable";
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