<?php
	abstract class TemplateDAO {
		
		protected $connexion;
		
		//Méthodes abstraites à être définies plus tard
		abstract function getClePrimaire();
		abstract function getNomTable();
		
		public function __construct() {
			$this->connexion = new PDO("mysql:host=localhost;dbname=concessionnaire", "root", "");
			$this->connexion->exec("SET NAMES'UTF8'"); // Affichage des caractères UTF8
		}

		//Lecture(READ)
        public function obtenir_par_id($id) {
            $requete = "SELECT * FROM " . $this -> getNomTable() . " WHERE " . $this -> getClePrimaire() . "=:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour de l'identifiant de la dernière insertion
            return $requetePreparee;
        }

        public function obtenir_tous() {
            $requete = "SELECT * FROM " . $this -> getNomTable();
            $resultats = $this -> connexion -> query($requete);
            return $resultats;
        }

        //Suppression (DELETE)
        public function supprime($id) {
            $requete = "DELETE FROM " . $this -> getNomTable() . " WHERE " . $this -> getClePrimaire() . "=:id";
            $requetePreparee = $this -> connexion -> prepare($requete);
            $requetePreparee -> bindParam(":id", $id);
            $requetePreparee -> execute();

            //Retour du nombre de rangées affectées 
            return $requetePreparee -> rowCount();
        }
	}
?>