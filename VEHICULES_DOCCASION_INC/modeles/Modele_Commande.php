<?php
	class Modele_Commande extends TemplateDAO {
		
		public function getNomTable() {
            return "commande";
        }

        public function getClePrimaire() {
            return "noCommande";
        }
		
	}
?>