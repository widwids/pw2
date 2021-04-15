<?php
    class Utilisateur {
        private $idUtilisateur;
        private $prenomUtilisateur;
        private $nomUtilisateur;
        private $dateNaissanceUtilisateur;
        private $adresseUtilisateur;
        private $codePostalUtilisateur;
        private $telephoneUtilisateur;
        private $cellulaireUtilisateur;
        private $courrielUtilisateur;
        private $pseudonymeUtilisateur;
        private $motDePasseUtilisateur;
        private $villeIdUtilisateur;
        private $privilegeIdUtilisateur;
        private $nomVilleUtilisateur;
        private $codeProvinceUtilisateur;
        private $nomProvinceUtilisateur;
        private $idPaysUtilisateur;
        private $nomPaysUtilisateur;

        public function __construct($id = 0, $prenom = "", $nom = "", $dateNaissance = "", $adresse = "", 
                                    $codePostal = "", $telephone = "", $cellulaire = "", $courriel = "", 
                                    $pseudonyme = "", $motDePasse = "", $villeId = 0, $privilegeId = 0,
                                    $nomVille = "", $codeProvince = "", $nomProvince = "", $idPays = 0,
                                    $nomPays = "") {
            $this -> id = $id;
            $this -> prenom = $prenom;
            $this -> nom = $nom;
            $this -> dateNaissance = $dateNaissance;
            $this -> adresse = $adresse;
            $this -> codePostal = $codePostal;
            $this -> telephone = $telephone;
            $this -> cellulaire = $cellulaire;
            $this -> courriel = $courriel;
            $this -> pseudonyme = $pseudonyme;
            $this -> motDePasse = $motDePasse;
            $this -> villeId = $villeId;
            $this -> privilegeId = $privilegeId;
            $this -> nomVille = $nomVille;
            $this -> codeProvince = $codeProvince;
            $this -> nomProvince = $nomProvince;
            $this -> idPays = $idPays;
            $this -> nomPays = $nomPays;
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
            return $this -> dateNaissance;
        }

        public function getAdresse() {
            return $this -> adresse;
        }

        public function getCodePostal() {
            return $this -> codePostal;
        }

        public function getTelephone() {
            return $this -> telephone;
        }

        public function getCellulaire() {
            return $this -> cellulaire;
        }

        public function getCourriel() {
            return $this -> courriel;
        }

        public function getPseudonyme() {
            return $this -> pseudonyme;
        }

        public function getMotDePasse() {
            return $this -> motDePasse;
        }

        public function getVilleId() {
            return $this -> villeId;
        }

        public function getPrivilegeId() {
            return $this -> privilegeId;
        }

        public function getNomVille() {
            return $this -> nomVille;
        }

        public function getCodeProvince() {
            return $this -> codeProvince;
        }

        public function getNomProvince() {
            return $this -> nomProvince;
        }

        public function getIdPays() {
            return $this -> idPays;
        }

        public function getNomPays() {
            return $this -> nomPays;
        }
    }
?>