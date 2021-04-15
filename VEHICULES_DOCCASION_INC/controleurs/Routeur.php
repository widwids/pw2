<?php
	class Routeur {
		public static function route() {
			// Obtenir le controleur qui devra traiter la requète
			
			// Obtenir la query string
			$chaineRequete = $_SERVER["QUERY_STRING"];
			$posEperluette = strpos($chaineRequete, "&");
			$controleur = substr($chaineRequete, 0, $posEperluette);
			//var_dump("chaineRequete : " . $chaineRequete);
			//var_dump("posEperluette : " . $posEperluette);
			//var_dump("controleur : " . $controleur);

			//var_dump($controleur);
			
			if ($controleur != "") {
				//chercher la classe du controleur
				$classe = "Controleur_" . $controleur;
			} else {	
				//controleur par défaut
				//$classe = "Controller_List";
				$classe = "Controleur_Voiture";
			}

			//var_dump("classe : " . $classe);
			
			// Vérifier que la classe existe
			if (class_exists($classe)) {
				// Dans $classe se trouve le nom de la classe ex : "Controleur_Liste"
				$objetControleur = new $classe;
				$objetControleur->traite($_REQUEST);
			} else {
				die("Erreur 404! Le controleur n'existe pas.");
			}
		}
	}
?>