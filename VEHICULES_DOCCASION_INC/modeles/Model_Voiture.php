<?php
	class Model_Voiture extends TemplateDAO {
		
		public function getTable() {
			return "voiture";
		}
		
		public function obtenirTous() {
			try {
				$stmt = $this->connexion->query("SELECT *  FROM voiture  ");

				$stmt->execute();
				return $stmt->fetchAll();

			}
			catch(Exception $exc) {
				return 0;
			}
		}
		
	}
?>