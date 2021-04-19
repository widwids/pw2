CREATE TABLE Corps (
	idCorps SMALLINT UNSIGNED AUTO_INCREMENT,
	nomCorps VARCHAR(30) NOT NULL,
	PRIMARY KEY(idCorps)
);

CREATE TABLE MotoPropulseur (
	idMotoPro SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMotoPro VARCHAR(30) NOT NULL,
	PRIMARY KEY(idMotoPro)
);

CREATE TABLE Carburant (
	idCarburant SMALLINT UNSIGNED AUTO_INCREMENT,
	typeCarburant VARCHAR(30) NOT NULL,
	PRIMARY KEY(idCarburant)
);

CREATE TABLE Transmission (
	idTransmission SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTransmission  VARCHAR(30) NOT NULL,
	PRIMARY KEY(IdTransmission)
);

CREATE TABLE Annee (
	annee year NOT NULL,	
	PRIMARY KEY(annee)
);

CREATE TABLE Marque (
	idMarque SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMarque VARCHAR(30) NOT NULL,
	PRIMARY KEY(idMarque)
);

CREATE TABLE Modele (
	idModele SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModele VARCHAR(30) NOT NULL,
	marqueId SMALLINT UNSIGNED,
	PRIMARY KEY(idModele),
	FOREIGN KEY(marqueId) REFERENCES Marque(idMarque)
);

CREATE TABLE Voiture (
	noSerie CHAR(17) UNIQUE NOT NULL,
	kilometrage INT NOT NULL,
	dateArrivee date NOT NULL,
	prixAchat DECIMAL(8,2) NOT NULL,
	groupeMPId SMALLINT UNSIGNED NOT NULL,
	corpsId SMALLINT UNSIGNED NOT NULL,
	carburantId SMALLINT UNSIGNED NOT NULL,
	modeleId SMALLINT UNSIGNED NOT NULL,
	transmissionId SMALLINT UNSIGNED NOT NULL,
	anneeId YEAR NOT NULL,
	photoAccueil VARCHAR(30) NOT NULL,
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
	autoId CHAR(17) NOT NULL,
	PRIMARY KEY(idPhoto),
	FOREIGN KEY (autoId) REFERENCES Voiture(noSerie)
);

CREATE TABLE Pays (
	idPays SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPays VARCHAR(50) NOT NULL,
	PRIMARY KEY(idPays)
);

CREATE TABLE Province (
	codeProvince CHAR(2),
	nomProvince VARCHAR(50) NOT NULL,
	paysId SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY(codeProvince),
	FOREIGN KEY(paysId) REFERENCES Pays(idPays)
);

CREATE TABLE Ville (
	idVille SMALLINT UNSIGNED AUTO_INCREMENT,
	nomVille VARCHAR(50) NOT NULL,
	provinceCode CHAR(2) NOT NULL,
	PRIMARY KEY(idVille),
	FOREIGN KEY(provinceCode) REFERENCES Province(codeProvince)
);

CREATE TABLE Taxe (
	idTaxe SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTaxe VARCHAR(30) NOT NULL,
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
	nomPrivilege VARCHAR(30) NOT NULL,
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
	villeId SMALLINT UNSIGNED NOT NULL,
	privilegeId SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY(idUtilisateur),
	FOREIGN KEY(villeId) REFERENCES Ville(idVille),
	FOREIGN KEY(privilegeId) REFERENCES Privilege(idPrivilege)
);

CREATE TABLE Commande (
	noCommande SMALLINT UNSIGNED AUTO_INCREMENT,
	dateCommande DATETIME NOT NULL,
	prix DECIMAL(8,2) NOT NULL,
	usagerId SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (noCommande),
	FOREIGN KEY(usagerId) REFERENCES Utilisateur(idUtilisateur)
);

CREATE TABLE Achat (
	commandeNo SMALLINT UNSIGNED,
	voitureId CHAR(17),
	statut ENUM('en attente', 'réservé', 'facturé') NOT NULL,
	depot DECIMAL(8,2),
	PRIMARY KEY(commandeNo, voitureId),
	FOREIGN KEY(commandeNo) REFERENCES Commande(noCommande),
	FOREIGN KEY(voitureId) REFERENCES Voiture(noSerie)
);

CREATE TABLE ModePaiement (
	idModePaiement SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMode VARCHAR(50),
	PRIMARY KEY(idModePaiement)
);

CREATE TABLE Facture (
	noFacture SMALLINT UNSIGNED AUTO_INCREMENT,
	dateFacture DATETIME NOT NULL,
	expedition ENUM('livraison locale', 'ramassage') NOT NULL,
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
	PRIMARY KEY(idConnexion),
	FOREIGN KEY(idConnexion) REFERENCES Utilisateur(idUtilisateur)
);

INSERT INTO Corps (nomCorps) VALUES
	('Hatchback'), 
	('Coupé'), 
	('Convertible'), 
	('Mini Van');
	
INSERT INTO MotoPropulseur (nomMotoPro) VALUES
	('4x4'), 
	('4x2');

INSERT INTO Carburant (typeCarburant) VALUES
	('Diesel'), 
	('Essence'), 
	('Électrique');

INSERT INTO Transmission (nomTransmission) VALUES
	('Automatique'), 
	('Manuelle');

INSERT INTO Annee (annee) VALUES
	(2021),
	(2020),
	(2019),
	(2018),
	(2017),
	(2016),
	(2015),
	(2014),
	(2013),
	(2012),
	(2011),
	(2010),
	(2009),
	(2008),
	(2007),
	(2006),
	(2005),
	(2004),
	(2003),
	(2002),
	(2001),
	(2000);
	
INSERT INTO Marque (nomMarque) VALUES
	('Audi'),
	('BMW'),
	('Bugatti'),
	('Cadillac'),
	('Dodge'),
	('Ferrari'),
	('Ford'),
	('Honda'),
	('Jeep');
	
INSERT INTO Modele (nomModele, marqueId) VALUES
	('A1', 1),
	('i3', 2),
	('i8', 2),
	('Veyron', 3),
	('ELR', 4),
	('Viper', 5),
	('F430', 6),
	('Mustang', 7),
	('NSX', 8),
	('S2000', 8),
	('Compass', 9);
	
INSERT INTO Pays (nomPays) VALUES
	('Canada'),
	('États-Unis');

INSERT INTO Province (codeProvince, nomProvince, paysId) VALUES
	('AL', 'Alberta', 1),
	('BC', 'Colombie-Britannique', 1),
	('MB', 'Manitoba', 1),
	('NB', 'Nouveau-Brunswick', 1),
	('NL', 'Terre-Neuve-et-Labrador', 1),
	('NS', 'Nouvelle-Écosse', 1),
	('NT', 'Territoires du Nord-Ouest', 1),
	('NU', 'Nunavut', 1),
	('ON', 'Ontario', 1),
	('PE', 'Île-du-Prince-Édouard', 1),
	('QC', 'Québec', 1),
	('SK', 'Saskatchewan', 1),
	('YT', 'Yukon', 1);

INSERT INTO Ville (nomVille, provinceCode) VALUES
	('Montréal', 'QC'),
	('Laval', 'QC'),
	('Longueuil', 'QC'),
	('Toronto', 'ON');
	
INSERT INTO Taxe (nomTaxe) VALUES
	('TPS'),
	('TVH'),
	('TVP'),
	('TVQ');

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

INSERT INTO Voiture (noSerie, kilometrage, dateArrivee, prixAchat, groupeMPId, corpsId, carburantId, modeleId, transmissionId, anneeId, photoAccueil) VALUES 
	('ACC12578400954379', 12000, '2021-02-18', '12000.00', 1, 2, 2, 2, 1, 2017, '33159'),
	('VFC12304514954319', 12000, '2021-05-01', '9000.00', 1, 2, 2, 2, 1, 2017, '434638'),
	('ZZC12300000954321', 12000, '2021-04-10', '4000.00', 1, 2, 2, 2, 1, 2017, '434629'),
	('ABC12300067154336', 12000, '2021-08-09', '8500.00', 1, 2, 2, 2, 1, 2017, '434660'),
	('AVF51847456154145', 210000, '2021-03-02', '7800.00', 2, 4, 2, 2, 1, 2010, '434663'),
	('DSC45127456364136', 180500, '2021-04-01', '9950.00', 2, 1, 2, 8, 1, 2009, '84575'),
	('ZFA16900014979233', 15000, '2021-04-13', '35000.00', 1, 3, 2, 4, 2, 2015, '49099');

INSERT INTO Photo (`idPhoto`, `nomPhoto`, `autoId`) VALUES
	(1, '4232',   'ABC12300067154336'),
	(2, '5430',   'ZZC12300000954321'),
	(3, '162070', 'ABC12300067154336'),
	(5, '218319', 'AVF51847456154145'),
	(6, '124088', 'AVF51847456154145');

INSERT INTO Privilege (nomPrivilege) VALUES
	('Administrateur'),
	('Employé'), 
	('Client');
	
INSERT INTO Utilisateur (prenom, nom, dateNaissance, adresse, codePostal, telephone, cellulaire, courriel, pseudonyme, motDePasse, villeId, privilegeId) VALUES 
	('Bob', 'Ross', '1942-10-29', '123 Arc-en-ciel', 'H1H 2H2', '514-555-5555', '438-444-4444', 'bob.ross@gmail.com', 'brosse', 'test', '1', '1'),
	('Annie', 'Brocoli', '1971-01-22', '456 Arc-en-ciel', 'H1H 2H2', '514-555-2222', '438-444-3333', 'annie.b@gmail.com', 'brocoli', '123Annie!!', '1', '2');

INSERT INTO Commande (dateCommande, prix, usagerId) VALUES 
	('2021-04-13 00:45:52', '45000.00', '2');
	
INSERT INTO Achat (commandeNo, voitureId, statut, depot) VALUES 
	(1, 'ABC12300067154336', 'en attente', NULL),
	(1, 'AVF51847456154145', 'réservé', '5000.00');

INSERT INTO ModePaiement (nomMode) VALUES
	('Espèces'), 
	('Carte de crédit'), 
	('Carte de débit'), 
	('Virement bancaire'), 
	('Passerelle de paiement');

INSERT INTO Facture (dateFacture, expedition, commandeId, modePaiementId) VALUES 
	('2021-04-14 01:01:12', 'ramassage', 1, 2);	