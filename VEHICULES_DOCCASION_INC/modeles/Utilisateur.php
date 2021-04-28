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
        private $visibiliteUtilisateur;
        private $nomVilleUtilisateurFR;
        private $nomVilleUtilisateurEN;
        private $codeProvinceUtilisateur;
        private $nomProvinceUtilisateurFR;
        private $nomProvinceUtilisateurEN;
        private $idPaysUtilisateur;
        private $nomPaysUtilisateurFR;
        private $nomPaysUtilisateurEN;
        private $nomPrivilegeUtilisateurFR;
        private $nomPrivilegeUtilisateurEN;
        
        public function __construct($id = 0, $prenom = "", $nom = "", $dateNaissance = "", $adresse = "", 
                                    $codePostal = "", $telephone = "", $cellulaire = "", $courriel = "", 
                                    $pseudonyme = "", $motDePasse = "", $villeId = 0, $privilegeId = 0,
                                    $visibilite = 1, $nomVilleFR = "", $nomVilleEN = "", $codeProvince = "", 
                                    $nomProvinceFR = "", $nomProvinceEN = "", $idPays = 0, $nomPaysFR = "", 
                                    $nomPaysEN = "", $nomPrivilegeFR = "", $nomPrivilegeEN = "") {
            $this -> idUtilisateur = $id;
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
            $this -> visibilite = $visibilite;
            $this -> nomVilleFR = $nomVilleFR;
            $this -> nomVilleEN = $nomVilleEN;
            $this -> codeProvince = $codeProvince;
            $this -> nomProvince = $nomProvinceFR;
            $this -> nomProvinceEN = $nomProvinceEN;
            $this -> idPays = $idPays;
            $this -> nomPaysFR = $nomPaysFR;
            $this -> nomPaysEN = $nomPaysEN;
            $this -> nomPrivilegeFR = $nomPrivilegeFR;
            $this -> nomPrivilegeEN = $nomPrivilegeEN;     
        }

        //Table Utilisateur
        public function getId() {
            return $this -> idUtilisateur;
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

        public function getVisibilite() {
            return $this -> visibilite;
        }

        //Table Ville
        public function getVilleId() {
            return $this -> villeId;
        }
        
        public function getNomVilleFR() {
            return $this -> nomVilleFR;
        }

        public function getNomVilleEN() {
            return $this -> nomVilleEN;
        }

        //Table Province
        public function getCodeProvince() {
            return $this -> codeProvince;
        }

        public function getNomProvinceFR() {
            return $this -> nomProvinceFR;
        }

        public function getNomProvinceEN() {
            return $this -> nomProvinceEN;
        }

        //Table Pays
        public function getIdPays() {
            return $this -> idPays;
        }

        public function getNomPaysFR() {
            return $this -> nomPaysFR;
        }

        public function getNomPaysEN() {
            return $this -> nomPaysEN;
        }

        //Table Privilege
        public function getPrivilegeId() {
            return $this -> privilegeId;
        }

        public function getNomPrivilegeFR() {
            return $this -> nomPrivilegeFR;
        }

        public function getNomPrivilegeEN() {
            return $this -> nomPrivilegeEN;
        }
    }
?>