<?php

	/*
	https://www.php.net/manual/fr/language.oop5.autoload.php
	*/

	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/VEHICULES_DOCCASION_INC/");
	define("RACINEWEB", "http://" . $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . "/VEHICULES_DOCCASION_INC/");


    // Définition de la fonction d'autoload
    function mon_autoloader($classe) {
        // Liste des répertoires à fouiller pour trouver les classes
        $repertoires = array(RACINE . "controller/", 
						RACINE . "model/", 
						RACINE . "view/");
        
        foreach ($repertoires as $rep) {
            if (file_exists($rep . $classe . ".php")) {
                require_once($rep . $classe . ".php");
                return;
            }                
        }
    }

    // Enregistrer cette fonction comme étant notre autoloader
	spl_autoload_register("mon_autoloader");
	
	Routeur::route();
?>