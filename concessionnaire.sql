CREATE TABLE corps (
	idCorps SMALLINT UNSIGNED AUTO_INCREMENT,
	nomCorpsFR VARCHAR(30) NOT NULL,
	nomCorpsEN VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idCorps)
);

CREATE TABLE motopropulseur (
	idMotopro SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMotopro VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idMotopro)
);

CREATE TABLE carburant (
	idCarburant SMALLINT UNSIGNED AUTO_INCREMENT,
	typeCarburantFR VARCHAR(30) NOT NULL,
	typeCarburantEN VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idCarburant)
);

CREATE TABLE transmission (
	idTransmission SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTransmissionFR  VARCHAR(30) NOT NULL,
	nomTransmissionEN  VARCHAR(30) NOT NULL,   
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idTransmission)
);

CREATE TABLE annee (
	annee year NOT NULL,
	visibilite BOOLEAN NOT NULL,	
	PRIMARY KEY(annee)
);

CREATE TABLE marque (
	idMarque SMALLINT UNSIGNED AUTO_INCREMENT,
	nomMarque VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idMarque)
);

CREATE TABLE modele (
	idModele SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModele VARCHAR(30) NOT NULL,
	marqueId SMALLINT UNSIGNED,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idModele),
	FOREIGN KEY(marqueId) REFERENCES marque(idMarque)
);

CREATE TABLE voiture (
	noSerie CHAR(17) UNIQUE NOT NULL,
	descriptionFR text NOT NULL,
	descriptionEN text NOT NULL,
	kilometrage INT NOT NULL,
	dateArrivee date NOT NULL,
	prixAchat DECIMAL(8,2) NOT NULL,
	groupeMPId SMALLINT UNSIGNED NOT NULL,
	corpsId SMALLINT UNSIGNED NOT NULL,
	carburantId SMALLINT UNSIGNED NOT NULL,
	modeleId SMALLINT UNSIGNED NOT NULL,
	transmissionId SMALLINT UNSIGNED NOT NULL,
	anneeId YEAR NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(noSerie),
	FOREIGN KEY (groupeMPId) REFERENCES motopropulseur(idMotopro),
	FOREIGN KEY (corpsId) REFERENCES corps(idCorps),
	FOREIGN KEY (carburantId) REFERENCES carburant(idCarburant),
	FOREIGN KEY (modeleId) REFERENCES modele(idModele),
	FOREIGN KEY (transmissionId) REFERENCES transmission(idTransmission),
	FOREIGN KEY (anneeId) REFERENCES annee(annee)
);

CREATE TABLE photo (
	idPhoto SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPhoto VARCHAR(30) NOT NULL,
	ordre TINYINT(2) UNSIGNED NOT NULL,
	autoId CHAR(17),
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idPhoto),
	FOREIGN KEY (autoId) REFERENCES voiture(noSerie)
);

CREATE TABLE pays (
	idPays SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPaysFR VARCHAR(50) NOT NULL,
	nomPaysEN VARCHAR(50) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idPays)
);

CREATE TABLE province (
	codeProvince CHAR(2),
	nomProvinceFR VARCHAR(50) NOT NULL,
	nomProvinceEN VARCHAR(50) NOT NULL,
	paysId SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(codeProvince),
	FOREIGN KEY(paysId) REFERENCES pays(idPays)
);

CREATE TABLE ville (
	idVille SMALLINT UNSIGNED AUTO_INCREMENT,
	nomVilleFR VARCHAR(50) NOT NULL,
	nomVilleEN VARCHAR(50) NOT NULL,
	provinceCode CHAR(2) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idVille),
	FOREIGN KEY(provinceCode) REFERENCES province(codeProvince)
);

CREATE TABLE taxe (
	idTaxe SMALLINT UNSIGNED AUTO_INCREMENT,
	nomTaxeFR VARCHAR(30) NOT NULL,
	nomTaxeEN VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idTaxe)
);

CREATE TABLE taxeProvince (
	provinceId CHAR(2),
	taxeId SMALLINT UNSIGNED,
	taux DECIMAL(5,3) NOT NULL,
	PRIMARY KEY(provinceId, taxeId),
	FOREIGN KEY(provinceId) REFERENCES province(codeProvince),
	FOREIGN KEY(taxeId) REFERENCES taxe(idTaxe)
);

CREATE TABLE privilege (
	idPrivilege SMALLINT UNSIGNED AUTO_INCREMENT,
	nomPrivilegeFR VARCHAR(30) NOT NULL,
	nomPrivilegeEN VARCHAR(30) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idPrivilege)
);

CREATE TABLE utilisateur (
	idUtilisateur SMALLINT UNSIGNED AUTO_INCREMENT,
	prenom VARCHAR(50) NOT NULL,
	nom VARCHAR(50) NOT NULL,
	dateNaissance DATE NOT NULL,
	adresse VARCHAR(60) NOT NULL,
	codePostal CHAR(7) NOT NULL,
	telephone CHAR(12) NOT NULL,
	cellulaire CHAR(12),
	courriel VARCHAR(60) NOT NULL,
	pseudonyme VARCHAR(20) UNIQUE NOT NULL,
	motDePasse VARCHAR(250) NOT NULL,
	codeOubliMDP VARCHAR(250),
	dateExpirationCode DATE,
	villeId SMALLINT UNSIGNED NOT NULL,
	privilegeId SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idUtilisateur),
	FOREIGN KEY(villeId) REFERENCES ville(idVille),
	FOREIGN KEY(privilegeId) REFERENCES privilege(idPrivilege)
);

CREATE TABLE commande (
	noCommande SMALLINT UNSIGNED AUTO_INCREMENT,
	dateCommande DATETIME NOT NULL,
	/* prix DECIMAL(8,2) NOT NULL,  */
	usagerId SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY (noCommande),
	FOREIGN KEY(usagerId) REFERENCES utilisateur(idUtilisateur)
);

CREATE TABLE achat (
	commandeNo SMALLINT UNSIGNED,
	voitureId CHAR(17),
	statutFR ENUM('en attente', 'réservé', 'facturé') NOT NULL,
	statutEN ENUM('pending', 'reserved ', 'invoiced') NOT NULL,
	depot DECIMAL(8,2),
	prixVente DECIMAL(8,2) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(commandeNo, voitureId),
	FOREIGN KEY(commandeNo) REFERENCES commande(noCommande),
	FOREIGN KEY(voitureId) REFERENCES voiture(noSerie)
);

CREATE TABLE modePaiement (
	idModePaiement SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModeFR VARCHAR(50),
	nomModeEN VARCHAR(50),
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idModePaiement)
);

CREATE TABLE facture (
	noFacture SMALLINT UNSIGNED AUTO_INCREMENT,
	dateFacture DATETIME NOT NULL,
	expeditionFR ENUM('livraison locale', 'ramassage') NOT NULL,
	expeditionEN ENUM('local delivery', 'pickup') NOT NULL,
	prixFinal DECIMAL(8,2) NOT NULL,
	commandeId SMALLINT UNSIGNED NOT NULL,
	modePaiementId SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY (noFacture),
	FOREIGN KEY (commandeId) REFERENCES commande(noCommande),
	FOREIGN KEY (modePaiementId) REFERENCES modePaiement(idModePaiement)
);

CREATE TABLE connexion (
	idConnexion SMALLINT UNSIGNED AUTO_INCREMENT,
	adresseIp VARCHAR(11),
	dateConnexion DATETIME,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idConnexion),
	FOREIGN KEY(idConnexion) REFERENCES utilisateur(idUtilisateur)
);

INSERT INTO corps (nomCorpsFR, nomCorpsEN, visibilite) VALUES
	('Berline', 'Hatchback', 1), 
	('Coupé', 'Coupe', 1), 
	('Convertible', 'Convertible', 1), 
	('Mini Van', 'Mini Van', 1 );
	
INSERT INTO motopropulseur (nomMotopro, visibilite) VALUES
	('4x4', 1), 
	('4x2', 1);

INSERT INTO carburant (typeCarburantFR, typeCarburantEN, visibilite) VALUES
	('Diesel', 'Diesel', 1), 
	('Essence', 'Gasoline', 1), 
	('Électrique', 'Electric', 1);

INSERT INTO transmission (nomTransmissionFR, nomTransmissionEN, visibilite) VALUES
	('Automatique', 'Automatic', 1), 
	('Manuelle', 'Manual', 1);

INSERT INTO annee (annee, visibilite) VALUES
	(2021, 1),
	(2020, 1),
	(2019, 1),
	(2018, 1),
	(2017, 1),
	(2016, 1),
	(2015, 1),
	(2014, 1),
	(2013, 1),
	(2012, 1),
	(2011, 1),
	(2010, 1),
	(2009, 1),
	(2008, 1),
	(2007, 1),
	(2006, 1),
	(2005, 1),
	(2004, 1),
	(2003, 1),
	(2002, 1),
	(2001, 1),
	(2000, 1);
	
INSERT INTO marque (nomMarque, visibilite) VALUES
	('Audi', 1),
	('BMW', 1),
	('Bugatti', 1),
	('Cadillac', 1),
	('Dodge', 1),
	('Ferrari', 1),
	('Ford', 1),
	('Honda', 1),
	('Jeep', 1);
	
INSERT INTO modele (nomModele, marqueId, visibilite) VALUES
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
	
INSERT INTO pays (nomPaysFR, nomPaysEN, visibilite) VALUES
	('Canada', 'Canada', 1),
	('États-Unis', 'United States', 1);

INSERT INTO province (codeProvince, nomProvinceFR, nomProvinceEN, paysId, visibilite) VALUES
	('AL', 'Alberta', 'Alberta', 1, 1),
	('BC', 'Colombie-Britannique','British Columbia', 1, 1),
	('MB', 'Manitoba','Manitoba', 1, 1),
	('NB', 'Nouveau-Brunswick','New Brunswick', 1, 1),
	('NL', 'Terre-Neuve-et-Labrador', 'Newfoundland and Labrador', 1, 1),
	('NS', 'Nouvelle-Écosse', 'Nova Scotia', 1, 1),
	('NT', 'Territoires du Nord-Ouest', 'Northwest Territories', 1, 1),
	('NU', 'Nunavut', 'Nunavut', 1, 1),
	('ON', 'Ontario', 'Ontario', 1, 1),
	('PE', 'Île-du-Prince-Édouard', 'Prince Edward Island', 1, 1),
	('QC', 'Québec', 'Quebec', 1, 1),
	('SK', 'Saskatchewan', 'Saskatchewan', 1, 1),
	('YT', 'Yukon', 'Yukon', 1, 1);

INSERT INTO ville (nomVilleFR, nomVilleEN, provinceCode, visibilite) VALUES
	('Montréal', 'Montreal', 'QC', 1),
	('Laval', 'Laval', 'QC', 1),
	('Longueuil', 'Longueuil', 'QC', 1),
	('Toronto', 'Toronto', 'ON', 1);
	
INSERT INTO taxe (nomTaxeFR, nomTaxeEN, visibilite) VALUES
	('TPS', 'TPS', 1),
	('TVH', 'TVH', 1),
	('TVP', 'TVP', 1),
	('TVQ', 'TVQ', 1);

INSERT INTO taxeProvince (provinceId, taxeId, taux) VALUES
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

INSERT INTO voiture (noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat, groupeMPId, corpsId, carburantId, modeleId, transmissionId, anneeId, visibilite) VALUES 
	('ACC12578400954379', 'Description en français ...!!???', 'Description en anglais ...!!???', 12000, '2021-02-18', '12000.00', 1, 2, 2, 2, 1, 2017, 1),
	('VFC12304514954319', 'Description en français ...!!???', 'Description en anglais ...!!???', 12000, '2021-05-01', '9000.00', 1, 2, 2, 2, 1, 2017, 1),
	('ZZC12300000954321', 'Description en français ...!!???', 'Description en anglais ...!!???', 12000, '2021-04-10', '4000.00', 1, 2, 2, 2, 1, 2017, 1),
	('ABC12300067154336', 'Description en français ...!!???', 'Description en anglais ...!!???', 12000, '2021-08-09', '8500.00', 1, 2, 2, 2, 1, 2017, 1),
	('AVF51847456154145', 'Description en français ...!!???', 'Description en anglais ...!!???', 210000, '2021-03-02', '7800.00', 2, 4, 2, 2, 1, 2010, 1),
	('DSC45127456364136', 'Description en français ...!!???', 'Description en anglais ...!!???', 180500, '2021-04-01', '9950.00', 2, 1, 2, 8, 1, 2009, 1),
	('ZFA16900014979233', 'Description en français ...!!???', 'Description en anglais ...!!???', 15000, '2021-04-13', '35000.00', 1, 3, 2, 4, 2, 2015, 1);

INSERT INTO photo (nomPhoto, ordre, autoId, visibilite) VALUES
	('4232'  , 1, 'ACC12578400954379', 1),
	('5430' ,  2, 'ACC12578400954379', 1),
	('33159' , 3, 'ACC12578400954379', 1),
	('46148' , 4, 'ACC12578400954379', 1),
	('49099' , 5, 'ACC12578400954379', 1),
	('53441' , 6, 'ACC12578400954379', 1),
	('84575' , 7, 'ACC12578400954379', 1),
	('162070', 1, 'VFC12304514954319', 1),
	('190752', 2, 'VFC12304514954319', 1),
	('190753', 3, 'VFC12304514954319', 1),
	('229745', 4, 'VFC12304514954319', 1),
	('218319', 1, 'ZZC12300000954321', 1),
	('244353', 2, 'ZZC12300000954321', 1),
	('319090', 3, 'ZZC12300000954321', 1),
	('351527', 4, 'ZZC12300000954321', 1),
	('386171', 5, 'ZZC12300000954321', 1),
	('434581', 1, 'ABC12300067154336', 1),
	('434584', 2, 'ABC12300067154336', 1),
	('434590', 3, 'ABC12300067154336', 1),
	('434599', 4, 'ABC12300067154336', 1),
	('434604', 5, 'ABC12300067154336', 1),
	('434609', 6, 'ABC12300067154336', 1),
	('434614', 1, 'AVF51847456154145', 1),
	('434617', 2, 'AVF51847456154145', 1),
	('434619', 3, 'AVF51847456154145', 1),
	('434609', 4, 'AVF51847456154145', 1),
	('434621', 5, 'AVF51847456154145', 1),
	('434623', 1, 'DSC45127456364136', 1),
	('434629', 2, 'DSC45127456364136', 1),
	('434635', 3, 'DSC45127456364136', 1),
	('434638', 4, 'DSC45127456364136', 1),
	('434648', 5, 'DSC45127456364136', 1),
	('434652', 1, 'ZFA16900014979233', 1),
	('434648', 2, 'ZFA16900014979233', 1),
	('434657', 3, 'ZFA16900014979233', 1);

INSERT INTO privilege (nomPrivilegeFR, nomPrivilegeEN, visibilite) VALUES
	('Administrateur', 'Administrator', 1),
	('Employé', 'Employee', 1), 
	('Client', 'Customer', 1);
	
INSERT INTO utilisateur (prenom, nom, dateNaissance, adresse, codePostal, telephone, cellulaire, courriel, pseudonyme, motDePasse, codeOubliMDP, dateExpirationCode, villeId, privilegeId, visibilite) VALUES 
	('Bob', 'Ross', '1942-10-29', '123 Arc-en-ciel', 'H1H 2H2', '514-555-5555', '438-444-4444', 'bob.ross@gmail.com', 'brosse', '$2y$10$xUgJZzRMPpNpEzVpIqy2oOjq.H2TPktBuc9eV2W1LmcInvgW2u3SO', 'test code mot passe', '2020-10-29', 1, 1, 1),
	('Annie', 'Brocoli', '1971-01-22', '456 Arc-en-ciel', 'H1H 2H2', '514-555-2222', '438-444-3333', 'annie.b@gmail.com', 'brocoli', '$2y$10$yU05MLPgLbfEAdSypKGnX.9zRQwk7HdWdt1S3H3xxR.09a6rWCf8a', 'test 2 code mot passe2', '2023-06-12', 1, 2, 1);

INSERT INTO commande (dateCommande, usagerId, visibilite) VALUES 
	('2021-04-13 00:45:52', 2, 1);
	
INSERT INTO achat (commandeNo, voitureId, statutFR, statutEN, depot, prixVente, visibilite) VALUES 
	(1, 'ABC12300067154336', 'en attente', 'pending', NULL, 15000.00, 1),
	(1, 'AVF51847456154145', 'réservé', 'reserved', 5000.00, 15000.00, 1);

INSERT INTO modePaiement (nomModeFR, nomModeEN, visibilite) VALUES
	('Espèces', 'Cash', 1), 
	('Carte de crédit', 'Credit card', 1), 
	('Carte de débit', 'Debit card', 1), 
	('Virement bancaire', 'Bank transfer', 1), 
	('Passerelle de paiement', 'Payment Gateway', 1);

INSERT INTO facture (dateFacture, expeditionFR, expeditionEN, prixFinal, commandeId, modePaiementId, visibilite) VALUES 
	('2021-04-14 01:01:12', 'ramassage', 'pickup', 15000, 1, 2, 1);