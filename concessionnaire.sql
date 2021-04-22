CREATE TABLE Corps (
	idCorps SMALLINT UNSIGNED AUTO_INCREMENT,
	nomCorpsFR VARCHAR(30) NOT NULL,/* ajouter */
	nomCorpsEN VARCHAR(30) NOT NULL,/* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idCorps)
);

CREATE TABLE MotoPropulseur (
	idMotoPro SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMotoPro VARCHAR(30) NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idMotoPro)
);

CREATE TABLE Carburant (
	idCarburant SMALLINT UNSIGNED AUTO_INCREMENT,
	typeCarburantFR VARCHAR(30) NOT NULL, /* ajouter */ 
	typeCarburantEN VARCHAR(30) NOT NULL, /* ajouter */ 
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idCarburant)
);

CREATE TABLE Transmission (
	idTransmission SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTransmissionFR  VARCHAR(30) NOT NULL, /* ajouter */
	nomTransmissionEN  VARCHAR(30) NOT NULL, /* ajouter */  
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(IdTransmission)
);

CREATE TABLE Annee (
	annee year NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */	
	PRIMARY KEY(annee)
);

CREATE TABLE Marque (
	idMarque SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMarque VARCHAR(30) NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idMarque)
);

CREATE TABLE Modele (
	idModele SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModele VARCHAR(30) NOT NULL,
	marqueId SMALLINT UNSIGNED,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idModele),
	FOREIGN KEY(marqueId) REFERENCES Marque(idMarque)
);

CREATE TABLE Voiture (
	noSerie CHAR(17) UNIQUE NOT NULL,
	descriptionFR text NOT NULL, /* ajouter */
	descriptionEN text NOT NULL, /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	kilometrage INT NOT NULL,
	dateArrivee date NOT NULL,
	prixAchat DECIMAL(8,2) NOT NULL,
	groupeMPId SMALLINT UNSIGNED NOT NULL,
	corpsId SMALLINT UNSIGNED NOT NULL,
	carburantId SMALLINT UNSIGNED NOT NULL,
	modeleId SMALLINT UNSIGNED NOT NULL,
	transmissionId SMALLINT UNSIGNED NOT NULL,
	anneeId YEAR NOT NULL,
	PRIMARY KEY(noSerie),
	FOREIGN KEY (groupeMPId) REFERENCES MotoPropulseur(idMotoPro),
	FOREIGN KEY (corpsId) REFERENCES Corps(idCorps),
	FOREIGN KEY (carburantId) REFERENCES Carburant(idCarburant),
	FOREIGN KEY (modeleId) REFERENCES Modele(idModele),
	FOREIGN KEY (transmissionId) REFERENCES Transmission(idTransmission),
	FOREIGN KEY (anneeId) REFERENCES Annee(annee)
);

CREATE TABLE Photo (
	idPhoto SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPhoto  VARCHAR(30) NOT NULL,
	Ordre TINYINT (2) NOT NULL, /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	autoId CHAR(17),
	PRIMARY KEY(idPhoto),
	FOREIGN KEY (autoId) REFERENCES Voiture(noSerie)
);

CREATE TABLE Pays (
	idPays SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPaysFR VARCHAR(50) NOT NULL, /* ajouter */
	nomPaysEN VARCHAR(50) NOT NULL, /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idPays)
);

CREATE TABLE Province (
	codeProvince CHAR(2),
	nomProvinceFR VARCHAR(50) NOT NULL, /* ajouter */
	nomProvinceEN VARCHAR(50) NOT NULL,/* ajouter */
	paysId SMALLINT UNSIGNED NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(codeProvince),
	FOREIGN KEY(paysId) REFERENCES Pays(idPays)
);

CREATE TABLE Ville (
	idVille SMALLINT UNSIGNED AUTO_INCREMENT,
	nomVilleFR VARCHAR(50) NOT NULL, /* ajouter */
	nomVilleEN VARCHAR(50) NOT NULL,/* ajouter */
	provinceCode CHAR(2) NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idVille),
	FOREIGN KEY(provinceCode) REFERENCES Province(codeProvince)
);

CREATE TABLE Taxe (
	idTaxe SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTaxeFR VARCHAR(30) NOT NULL,  /* ajouter */
	nomTaxeEN VARCHAR(30) NOT NULL,  /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idTaxe)
);

CREATE TABLE TaxeProvince (
	provinceId CHAR(2),
	taxeId SMALLINT UNSIGNED,
	taux DECIMAL(5,3) NOT NULL,
	PRIMARY KEY(provinceId, taxeId),
	FOREIGN KEY(provinceId) REFERENCES Province(codeProvince),
	FOREIGN KEY(taxeId) REFERENCES Taxe(idTaxe)
);

CREATE TABLE Privilege (
	idPrivilege SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPrivilegeFR VARCHAR(30) NOT NULL,/* ajouter */
	nomPrivilegeEN VARCHAR(30) NOT NULL,/* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idPrivilege)
);

CREATE TABLE Utilisateur (
	idUtilisateur SMALLINT UNSIGNED AUTO_INCREMENT,
	prenom VARCHAR(50) NOT NULL,
	nom VARCHAR(50) NOT NULL,
	dateNaissance DATE NOT NULL,
	adresse VARCHAR(60) NOT NULL,
	codePostal CHAR(7) NOT NULL,
	telephone CHAR(12) NOT NULL,
	cellulaire CHAR(12),
	courriel VARCHAR(60) NOT NULL,
	pseudonyme VARCHAR(20) NOT NULL,
	motDePasse VARCHAR(250) NOT NULL,
	codeOubliMDP VARCHAR(250) NOT NULL, /* ajouter */
	dateExpirationCode DATE NOT NULL, /* ajouter */
	villeId SMALLINT UNSIGNED NOT NULL,
	privilegeId SMALLINT UNSIGNED NOT NULL,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idUtilisateur),
	FOREIGN KEY(villeId) REFERENCES Ville(idVille),
	FOREIGN KEY(privilegeId) REFERENCES Privilege(idPrivilege)
);

CREATE TABLE Commande (
	noCommande SMALLINT UNSIGNED AUTO_INCREMENT,
	dateCommande DATETIME NOT NULL,
	/* prix DECIMAL(8,2) NOT NULL,  */
	visibilite TINYINT NOT NULL, /* ajouter */
	usagerId SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (noCommande),
	FOREIGN KEY(usagerId) REFERENCES Utilisateur(idUtilisateur)
);

CREATE TABLE Achat (
	commandeNo SMALLINT UNSIGNED,
	voitureId CHAR(17),
	statutFR ENUM('en attente', 'réservé', 'facturé') NOT NULL,  /* ajouter */
	statutEN ENUM('pending', 'reserved ', 'invoiced') NOT NULL,  /* ajouter */
	depot DECIMAL(8,2),
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(commandeNo, voitureId),
	FOREIGN KEY(commandeNo) REFERENCES Commande(noCommande),
	FOREIGN KEY(voitureId) REFERENCES Voiture(noSerie)
);

CREATE TABLE ModePaiement (
	idModePaiement SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModeFR VARCHAR(50),  /* ajouter */
	nomModeEN VARCHAR(50),  /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idModePaiement)
);

CREATE TABLE Facture (
	noFacture SMALLINT UNSIGNED AUTO_INCREMENT,
	dateFacture DATETIME NOT NULL,
	expeditionFR ENUM('livraison locale', 'ramassage') NOT NULL, /* ajouter */
	expeditionEN ENUM('local delivery', 'pickup') NOT NULL, /* ajouter */
	prixFinal DECIMAL(8,2) NOT NULL, /* ajouter */
	visibilite TINYINT NOT NULL, /* ajouter */
	commandeId SMALLINT UNSIGNED NOT NULL,
	modePaiementId SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (noFacture),
	FOREIGN KEY (commandeId) REFERENCES Commande(noCommande),
	FOREIGN KEY (modePaiementId) REFERENCES ModePaiement(idModePaiement)
);

CREATE TABLE Connexion (
	idConnexion SMALLINT UNSIGNED AUTO_INCREMENT,
	adresseIp VARCHAR(11),
	dateConnexion DATETIME,
	visibilite TINYINT NOT NULL, /* ajouter */
	PRIMARY KEY(idConnexion),
	FOREIGN KEY(idConnexion) REFERENCES Utilisateur(idUtilisateur)
);

INSERT INTO Corps (nomCorpsFR, nomCorpsEN, visibilite) VALUES
	('Berline', 'Hatchback', 1), 
	('Coupé','Coupe', 1), 
	('Convertible', 'Convertible', 1), 
	('Mini Van' ,'Mini Van' , 1 );
	
INSERT INTO MotoPropulseur (nomMotoPro, visibilite) VALUES
	('4x4',1), 
	('4x2',1);

INSERT INTO Carburant (typeCarburantFR, typeCarburantEN, visibilite) VALUES
	('Diesel','Diesel',1), 
	('Essence','Gasoline',1), 
	('Électrique','Electric',1);

INSERT INTO Transmission (nomTransmissionFR, nomTransmissionEN, visibilite) VALUES
	('Automatique','Automatic',1), 
	('Manuelle','Manual',1);

INSERT INTO Annee (annee, visibilite ) VALUES
	(2021,1),
	(2020,1),
	(2019,1),
	(2018,1),
	(2017,1),
	(2016,1),
	(2015,1),
	(2014,1),
	(2013,1),
	(2012,1),
	(2011,1),
	(2010,1),
	(2009,1),
	(2008,1),
	(2007,1),
	(2006,1),
	(2005,1),
	(2004,1),
	(2003,1),
	(2002,1),
	(2001,1),
	(2000,1);
	
INSERT INTO Marque (nomMarque, visibilite) VALUES
	('Audi',1),
	('BMW',1),
	('Bugatti',1),
	('Cadillac',1),
	('Dodge',1),
	('Ferrari',1),
	('Ford',1),
	('Honda',1),
	('Jeep',1);
	
INSERT INTO Modele (nomModele, marqueId, visibilite) VALUES
	('A1', 1, 1),
	('i3', 2, 1),
	('i8', 2, 1),
	('Veyron', 3, 1),
	('ELR', 4, 1),
	('Viper', 5, 1),
	('F430', 6, 1),
	('Mustang', 7, 1),
	('NSX', 8, 1),
	('S2000', 8, 1),
	('Compass', 9, 1);
	
INSERT INTO Pays (nomPaysFR, nomPaysEN, visibilite) VALUES
	('Canada','Canada',1),
	('États-Unis','United State', 1);

INSERT INTO Province (codeProvince, nomProvinceFR, nomProvinceEN, visibilite, paysId) VALUES
	('AL', 'Alberta', 'Alberta', 1, 1),
	('BC', 'Colombie-Britannique','British Columbia', 1, 1),
	('MB', 'Manitoba','Manitoba', 1, 1),
	('NB', 'Nouveau-Brunswick','New Brunswick', 1, 1),
	('NL', 'Terre-Neuve-et-Labrador', 'Newfoundland and Labrador', 1, 1),
	('NS', 'Nouvelle-Écosse', 'New Scotland', 1, 1),
	('NT', 'Territoires du Nord-Ouest', 'Northwest Territories', 1, 1),
	('NU', 'Nunavut', 'Nunavut', 1, 1),
	('ON', 'Ontario', 'Ontario', 1, 1),
	('PE', 'Île-du-Prince-Édouard', 'Prince Edward Island', 1, 1),
	('QC', 'Québec', 'Québec', 1, 1),
	('SK', 'Saskatchewan', 'Saskatchewan', 1, 1),
	('YT', 'Yukon', 'Yukon', 1 ,1);

INSERT INTO Ville (nomVilleFR, nomVilleEN, visibilite, provinceCode) VALUES
	('Montréal', 'Montreal', 1,'QC'),
	('Laval', 'Laval', 1, 'QC'),
	('Longueuil', 'Longueuil', 1, 'QC'),
	('Toronto', 'Toronto', 1, 'ON');
	
INSERT INTO Taxe (NomTaxeFR, NomTaxeEN, visibilite) VALUES
	('TPS', 'TPS', 1),
	('TVH', 'TVH', 1),
	('TVP', 'TVP', 1),
	('TVQ', 'TVQ', 1);

INSERT INTO TaxeProvince (provinceId, taxeId, taux) VALUES
	('AL', 1, 5.000),
	('BC', 1, 5.000),
	('BC', 3, 7.000),
	('MB', 1, 5.000),
	('MB', 3, 7.000),
	('NB', 2, 15.000),
	('NL', 2, 15.000),
	('NS', 2, 15.000),
	('NT', 1, 5.000),
	('NU', 1, 5.000),
	('ON', 2, 13.000),
	('PE', 2, 15.000),
	('QC', 1, 5.000),
	('QC', 4, 9.975),
	('SK', 1, 5.000),
	('SK', 3, 6.000),
	('YT', 1, 5.000);

INSERT INTO Voiture (noSerie, descriptionFR, descriptionEN, visibilite, kilometrage, dateArrivee, prixAchat, groupeMPId, corpsId, carburantId, modeleId, transmissionId, anneeId) VALUES 
	('ACC12578400954379', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 12000, '2021-02-18', '12000.00', 1, 2, 2, 2, 1, 2017),
	('VFC12304514954319', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 12000, '2021-05-01', '9000.00', 1, 2, 2, 2, 1, 2017),
	('ZZC12300000954321', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 12000, '2021-04-10', '4000.00', 1, 2, 2, 2, 1, 2017),
	('ABC12300067154336', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 12000, '2021-08-09', '8500.00', 1, 2, 2, 2, 1, 2017),
	('AVF51847456154145', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 210000, '2021-03-02', '7800.00', 2, 4, 2, 2, 1, 2010),
	('DSC45127456364136', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 180500, '2021-04-01', '9950.00', 2, 1, 2, 8, 1, 2009),
	('ZFA16900014979233', 'Description en francais ...!!???', 'Description en englais ...!!???', 1, 15000, '2021-04-13', '35000.00', 1, 3, 2, 4, 2, 2015);

INSERT INTO photo (nomPhoto, Ordre, visibilite, autoId) VALUES
	('4232'  , 1, 1, 'ACC12578400954379'),
	('5430' ,  2, 1, 'ACC12578400954379'),
	('33159' , 3, 1, 'ACC12578400954379'),
	('46148' , 4, 1, 'ACC12578400954379'),
	('49099' , 5, 1, 'ACC12578400954379'),
	('53441' , 6, 1, 'ACC12578400954379'),
	('84575' , 7, 1, 'ACC12578400954379'),
	('162070', 1, 1, 'VFC12304514954319'),
	('190752', 2, 1, 'VFC12304514954319'),
	('190753', 3, 1, 'VFC12304514954319'),
	('229745', 4, 1, 'VFC12304514954319'),
	('218319', 1, 1, 'ZZC12300000954321'),
	('244353', 2, 1, 'ZZC12300000954321'),
	('319090', 3, 1, 'ZZC12300000954321'),
	('351527', 4, 1, 'ZZC12300000954321'),
	('386171', 5, 1, 'ZZC12300000954321'),
	('434581', 1, 1, 'ABC12300067154336'),
	('434584', 2, 1, 'ABC12300067154336'),
	('434590', 3, 1, 'ABC12300067154336'),
	('434599', 4, 1, 'ABC12300067154336'),
	('434604', 5, 1, 'ABC12300067154336'),
	('434609', 6, 1, 'ABC12300067154336'),
	('434614', 1, 1, 'AVF51847456154145'),
	('434617', 2, 1, 'AVF51847456154145'),
	('434619', 3, 1, 'AVF51847456154145'),
	('434609', 4, 1, 'AVF51847456154145'),
	('434621', 5, 1, 'AVF51847456154145'),
	('434623', 1, 1, 'DSC45127456364136'),
	('434629', 2, 1, 'DSC45127456364136'),
	('434635', 3, 1, 'DSC45127456364136'),
	('434638', 4, 1, 'DSC45127456364136'),
	('434648', 5, 1, 'DSC45127456364136'),
	('434652', 1, 1, 'ZFA16900014979233'),
	('434648', 2, 1, 'ZFA16900014979233'),
	('434657', 3, 1, 'ZFA16900014979233');




INSERT INTO Privilege (nomPrivilegeFR, nomPrivilegeEN, visibilite) VALUES
	('Administrateur', 'Administrator', 1),
	('Employé', 'Employee', 1), 
	('Client', 'Customer', 1);
	
INSERT INTO Utilisateur (prenom, nom, dateNaissance, codeOubliMDP, dateExpirationCode, visibilite, adresse, codePostal, telephone, cellulaire, courriel, pseudonyme, motDePasse, villeId, privilegeId) VALUES 
	('Bob', 'Ross', '1942-10-29', 'test code mot passe ', '2020-10-29' , 1, '123 Arc-en-ciel', 'H1H 2H2', '514-555-5555', '438-444-4444', 'bob.ross@gmail.com', 'brosse', 'test', '1', '1'),
	('Annie', 'Brocoli', '1971-01-22', 'test 2 code mot passe2  ', '2023-06-12' , 1, '456 Arc-en-ciel', 'H1H 2H2', '514-555-2222', '438-444-3333', 'annie.b@gmail.com', 'brocoli', '123Annie!!', '1', '2');

INSERT INTO Commande (dateCommande, visibilite, usagerId) VALUES 
	('2021-04-13 00:45:52', 1, '2');
	
INSERT INTO Achat (commandeNo, voitureId, statutFR, statutEN, visibilite, depot) VALUES 
	(1, 'ABC12300067154336', 'en attente', 'pending', 1, NULL),
	(1, 'AVF51847456154145', 'réservé', 'reserved',1 , '5000.00');

INSERT INTO ModePaiement (nomModeFR, nomModeEN, visibilite) VALUES
	('Espèces', 'Species', 1), 
	('Carte de crédit', 'Credit card', 1), 
	('Carte de débit', 'Debit card', 1), 
	('Virement bancaire', 'Bank transfer', 1), 
	('Passerelle de paiement', 'Payment Gateway', 1);

INSERT INTO Facture (dateFacture, expeditionFR, expeditionEN, prixFinal, visibilite, commandeId, modePaiementId) VALUES 
	('2021-04-14 01:01:12', 'ramassage', 'pickup', 15000, 1, 1, 2);	