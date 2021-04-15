<?php
	abstract class BaseControleur {
	
		// La fonction qui sera appelle par le routeur
		public abstract function traite(array $params);
		
		protected function afficheVue($nomVue, $data = null) {

			$cheminVue = RACINE . "vues/" . $nomVue . ".php";
			
			if (file_exists($cheminVue)) {
				include($cheminVue); 
			} else {
				die("Erreur 404! La vue n'existe pas.");				
			}
		}

		public function obtenirDAO($nomModele) {
            $classe = "Modele_" . $nomModele;

            if(class_exists($classe)) {
                //Création de la connexion à la base de données (les constantes sont dans config.php)
                $connexionPDO = DBFactory::getDB(DBTYPE, DBNAME, HOST, USER, PWD);

                //Création d'une instance de la classe Modele_$nomModele
                $objetModele = new $classe($connexionPDO);

                if($objetModele instanceof TemplateDAO)
                    return $objetModele;
                else
                    trigger_error("Modèle invalide!");  
                
            } else
                trigger_error("La classe $classe n'existe pas.");
        }
	}
?>