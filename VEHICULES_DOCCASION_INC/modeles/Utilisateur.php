<?php
    class Utilisateur {
        private $idUtilisateur;
        private $prenomUtilisateur;
        private $nomUtilisateur;
        private $dateDeNaissanceUtilisateur;
        private $pseudonymeUtilisateur;
        private $motDePasseUtilisateur;

        public function __construct($id = 0, $prenom = "", $nom = "", $dateDeNaissance = "", $pseudonyme = "", $motDePasse = "") {
            $this -> id = $id;
            $this -> prenom = $prenom;
            $this -> nom = $nom;
            $this -> dateDeNaissance = $dateDeNaissance;
            $this -> pseudonyme = $pseudonyme;
            $this -> motDePasse = $motDePasse;
        }

        public function getId() {
            return $this -> id;
        }

        public function getPrenom() {
            return $this -> prenom;
        }

        public function getNom() {
            return $this -> nom;
        }

        public function getDateNaissance() {
            return $this -> dateDeNaissance;
        }

        public function getPseudonyme() {
            return $this -> pseudonyme;
        }

        public function getMotDePasse() {
            return $this -> motDePasse;
        }
    }
?>