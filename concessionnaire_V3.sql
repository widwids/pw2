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
	visibilite BOOLEAN NOT NULL,
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
	usagerId SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY (noCommande),
	FOREIGN KEY(usagerId) REFERENCES utilisateur(idUtilisateur)
);

CREATE TABLE modePaiement (
	idModePaiement SMALLINT UNSIGNED AUTO_INCREMENT,
	nomModeFR VARCHAR(50),
	nomModeEN VARCHAR(50),
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idModePaiement)
);

CREATE TABLE statut (
	idStatut SMALLINT UNSIGNED AUTO_INCREMENT,
	nomStatutFR VARCHAR(50) NOT NULL,
	nomStatutEN VARCHAR(50) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idStatut)
);

CREATE TABLE expedition (
	idExpedition SMALLINT UNSIGNED AUTO_INCREMENT,
	nomExpeditionFR VARCHAR(50) NOT NULL,
	nomExpeditionEN VARCHAR(50) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(idExpedition)
);

CREATE TABLE commandeVoiture (
	commandeNo SMALLINT UNSIGNED,
	voitureId CHAR(17),
	prixVente DECIMAL(8,2) NOT NULL,
	depot DECIMAL(8,2),
	statutId SMALLINT UNSIGNED NOT NULL,
	expeditionId SMALLINT UNSIGNED NOT NULL,
	modePaiementNo SMALLINT UNSIGNED NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY(commandeNo, voitureId),
	FOREIGN KEY(commandeNo) REFERENCES commande(noCommande),
	FOREIGN KEY(voitureId) REFERENCES voiture(noSerie),
	FOREIGN KEY(statutId) REFERENCES statut(idStatut),
	FOREIGN KEY(expeditionId) REFERENCES expedition(idExpedition),
	FOREIGN KEY (modePaiementNo) REFERENCES modePaiement(idModePaiement)
);

CREATE TABLE facture (
	noFacture SMALLINT UNSIGNED,
	dateFacture DATETIME NOT NULL,
	prixFinal DECIMAL(10,2) NOT NULL,
	visibilite BOOLEAN NOT NULL,
	PRIMARY KEY (noFacture),
	FOREIGN KEY (noFacture) REFERENCES commande(noCommande)
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
	('Sport', 'Sport', 1), 
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
	(2009, 1);
	
INSERT INTO marque (nomMarque, visibilite) VALUES
	('Audi', 1),
	('Porsche', 1),
	('Bugatti', 1),
	('McLaren', 1),
	('Lamborghini', 1),
	('Ferrari', 1),
	('Ford', 1),
	('Aston Martin', 1),
	('Chevrolet', 1),
	('BMW', 1),
	('Mercedes', 1);
	
INSERT INTO modele (nomModele, marqueId, visibilite) VALUES
	('918 spyder', 2, 1),
	('911 RSR', 2, 1),
	('AMD GT', 11, 1),
	('Senna', 4, 1),
	('P1', 4, 1),
	('720S', 4, 1),
	('675 LT', 4, 1),
	('650S', 4, 1),
	('600 LT', 4, 1),
	('570S GT', 4, 1),
	('570S', 4, 1),
	('Veneno', 5, 1),
	('Terzo Millennio', 5, 1),
	('SC20', 5, 1),
	('SC18', 5, 1),
	('Huracan Evo', 5, 1),
	('Huracan', 5, 1),
	('Centenario', 5, 1),
	('Aventador SVJ', 5, 1),
	('Aventador', 5, 1),
	('GT', 7, 1),
	('La Ferrari', 6, 1),
	('488 GTB', 6, 1),
	('Corvette', 9, 1),
	('Chiron', 3, 1),
	('i8', 1, 1),
	('R8 V10', 10, 1),
	('Vanquish', 8, 1);
	
	
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
	('TPS', 'GST', 1),
	('TVH', 'HST', 1),
	('TVP', 'PST', 1),
	('TVQ', 'QST', 1);

INSERT INTO taxeProvince (provinceId, taxeId, taux, visibilite) VALUES
	('AL', 1, 5.000, 1),
	('BC', 1, 5.000, 1),
	('BC', 3, 7.000, 1),
	('MB', 1, 5.000, 1),
	('MB', 3, 7.000, 1),
	('NB', 2, 15.000, 1),
	('NL', 2, 15.000, 1),
	('NS', 2, 15.000, 1),
	('NT', 1, 5.000, 1),
	('NU', 1, 5.000, 1),
	('ON', 2, 13.000, 1),
	('PE', 2, 15.000, 1),
	('QC', 1, 5.000, 1),
	('QC', 4, 9.975, 1),
	('SK', 1, 5.000, 1),
	('SK', 3, 6.000, 1),
	('YT', 1, 5.000, 1);

INSERT INTO voiture (noSerie, descriptionFR, descriptionEN, kilometrage, dateArrivee, prixAchat, groupeMPId, corpsId, carburantId, modeleId, transmissionId, anneeId, visibilite) VALUES 
	('ACC12578400954379', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!', 
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 12000, '2021-02-18', '129000.00', 1, 1, 2, 1, 1, 2017, 1),
	('BRD57578474621344', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 561, '2021-02-18', '89000.00', 1, 2, 2, 2, 1, 2014, 1),
	('YXZ38473738092839', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 2445, '2021-02-18', '125000.00', 1, 2, 2, 3, 1, 2011, 1),
	('VFC12304514954319', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!', 
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 8770, '2021-02-18', '99000.00', 1, 1, 2, 4, 1, 2011, 1),
	('TGE45837438306027', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 12464, '2021-02-18', '176000.00', 1, 2, 2, 5, 1, 2013, 1),
	('JLW49382754048933', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 1245, '2021-02-18', '233000.00', 1, 2, 2, 6, 1, 2017, 1),
	('ZZC12300000954321', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 369, '2021-02-18', '127000.00', 1, 1, 2, 7, 1, 2016, 1),
	('PRT27348357191193', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 11014, '2021-02-18', '162000.00', 1, 2, 2, 8, 1, 2017, 1),
	('ABC12300067154336', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 8577, '2021-02-18', '140000.00', 1, 2, 2, 9, 1, 2019, 1),
	('CBF09938547384752', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!',
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 13400, '2021-02-18', '145000.00', 1, 1, 2, 10, 1, 2020, 1),
	('TWQ98675548573754', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 3647, '2021-02-18', '177000.00', 1, 2, 2, 11, 1, 2020, 1),
	('AVF51847456154145', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 345, '2021-02-18', '122000.00', 1, 1, 2, 12, 1, 2010, 1),
	('SLF70908898475838', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 989, '2021-02-18', '155000.00', 1, 2, 2, 13, 1, 2009, 1),
	('YOI27117384583833', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!',
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 9472, '2021-02-18', '175000.00', 1, 1, 2, 14, 1, 2011, 1),
	('DSC45127456364136', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 10050, '2021-02-18', '199000.00', 1, 2, 2, 15, 1, 2012, 1),
	('WFB57382284395839', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 2667, '2021-02-18', '89000.00', 1, 2, 2, 16, 1, 2013, 1),
	('ZFA16900014979233', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 12034, '2021-02-18', '111000.00', 1, 2, 2, 17, 1, 2014, 1),
	('LPP47551182837438', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 145, '2021-02-18', '102000.00', 1, 1, 2, 18, 1, 2014, 1),
	('POQ00979798966966', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!',
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 13753, '2021-02-18', '120000.00', 1, 2, 2, 19, 1, 2016, 1),
	('FDD57281182322381', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 9714, '2021-02-18', '115000.00', 1, 2, 2, 20, 1, 2015, 1),
	('CXZ57129119239238', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 15000, '2021-02-18', '199000.00', 1, 2, 2, 21, 1, 2017, 1),
	('YQS48534723283457', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!',
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 14277, '2021-02-18', '130000.00', 1, 1, 2, 22, 1, 2018, 1),
	('UTY58475573280090', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 11515, '2021-02-18', '133000.00', 1, 2, 2, 23, 1, 2009, 1),
	('AZA38483284722822', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 14348, '2021-02-18', '89000.00', 1, 2, 2, 24, 1, 2011, 1),
	('LAQ48374832371909', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 10189, '2021-02-18', '140000.00', 1, 2, 2, 25, 1, 2017, 1),
	('RHR47283748373749', 'Ce modèle reçu cette année, remis à neuf, comprend toutes les caractéristiques recherchées dans les véhicules de grand prestige. Comfort, utilité, puissance et l’art de faire tourner toutes les têtes. Une occasion à ne pas manquer!',
	'This model received this year, refurbished, includes all the features sought in prestigious vehicles. Comfort, utility, power and the art of turning every head. An opportunity not to be missed!', 6535, '2021-02-18', '110000.00', 1, 2, 2, 26, 1, 2015, 1),
	('PYT50987956506921', 'Une rare acquisition de YVMA cette année. Ce véhicule prestigieux est en tout point le summum de l’ingéniosité humaine et son éternel désir de se surpasser. Une puissance extrême, un design unique et des fonctionnalités sorties tout droit de la science-fiction. Ce rare véhicule pourrait être à vous.  Contactez-nous dès maintenant et devenez le roi incontesté de la route.', 
	'A rare acquisition from YVMA this year. This prestigious vehicle is in every way the pinnacle of human ingenuity and its eternal desire to surpass itself. Extreme power, unique design and functionality straight out of science fiction. This rare vehicle could be yours. Contact us now and become the undisputed king of the road.', 12000, '2021-02-18', '110000.00', 1, 2, 2, 27, 1, 2014, 1),
	('XVC48574837458848', 'Véhicule puissant datant de quelques années, peu de kilométrage, état impeccable. Toute imperfection préalablement corrigée par nos techniciens chevronnés YVMA. Look sportive, courbes attrayantes, contrôle sur la route irréprochable. Partez à l’aventure avec la crème des véhicules sport. Ce modèle est toujours populaire aujourd’hui grâce à sa grande performance et sa fiabilité. Faites vite, ils ne restent jamais longtemps!', 
	'Powerful vehicle a few years old, low mileage, immaculate condition. Any imperfection previously corrected by our experienced YVMA technicians. Sporty look, attractive curves, impeccable road control. Go on an adventure with the cream of sports vehicles. This model is still popular today thanks to its great performance and reliability. Hurry, they never stay long!', 5585, '2021-02-18', '172000.00', 1, 2, 2, 28, 1, 2020, 1),
	('JYC48374832219067', 'Cet arrivage récent et en parfait état est parfait pour le gentleman désireux de luxe et de prestige. Un intérieur en cuir véritable, une puissance inégalée et un design unique en son genre; quoi désirer de plus pour un véhicule de rêve comme celui-ci? N’hésitez pas et communiquez avec nous pour réserver!', 
	'This recent arrival is in mint condition and perfect for the distinguished gentleman seeking luxury and prestige. Genuine leather interior, unmatched power and one-of-a-kind design; what more could you want for a dream vehicle like this? Do not hesitate and contact us to reserve!', 975, '2021-02-18', '80000.00', 1, 2, 2, 28, 1, 2019, 1);


INSERT INTO photo (nomPhoto, ordre, autoId, visibilite) VALUES
	('PO_918spyder_1'  , 1, 'ACC12578400954379', 1),
	('PO_918spyder_2' ,  2, 'ACC12578400954379', 1),
	('PO_918spyder_3' , 3, 'ACC12578400954379', 1),
	('PO_911_RSR_1' , 1, 'BRD57578474621344', 1),
	('PO_911_RSR_2' , 2, 'BRD57578474621344', 1),
	('MER_amd_gt_1' , 1, 'YXZ38473738092839', 1),
	('MER_amd_gt_2' , 2, 'YXZ38473738092839', 1),
	('McL_senna_1', 1, 'VFC12304514954319', 1),
	('McL_senna_2', 2, 'VFC12304514954319', 1),
	('McL_senna_3', 3, 'VFC12304514954319', 1),
	('McL_P1_1', 1, 'TGE45837438306027', 1),
	('McL_P1_2', 2, 'TGE45837438306027', 1),
	('McL_720s_1', 1, 'JLW49382754048933', 1),
	('McL_720s_2', 2, 'JLW49382754048933', 1),
	('McL_675LT_1', 1, 'ZZC12300000954321', 1),
	('McL_675LT_2', 2, 'ZZC12300000954321', 1),
	('McL_650S_1', 1, 'PRT27348357191193', 1),
	('McL_650S_2', 2, 'PRT27348357191193', 1),
	('McL_600LT_1', 1, 'ABC12300067154336', 1),
	('McL_600LT_2', 2, 'ABC12300067154336', 1),
	('McL_570S_GT4_1', 1, 'CBF09938547384752', 1),
	('McL_570S_GT4_2', 2, 'CBF09938547384752', 1),
	('McL_570S_1', 1, 'TWQ98675548573754', 1),
	('McL_570S_2', 2, 'TWQ98675548573754', 1),
	('McL_570S_3', 3, 'TWQ98675548573754', 1),
	('LA_veneno_1', 1, 'AVF51847456154145', 1),
	('LA_veneno_2', 2, 'AVF51847456154145', 1),
	('LA_terzo_millennio_1', 1, 'SLF70908898475838', 1),
	('LA_terzo_millennio_2', 2, 'SLF70908898475838', 1),
	('LA_SC20_1', 1, 'YOI27117384583833', 1),
	('LA_SC20_2', 2, 'YOI27117384583833', 1),
	('LA_SC18_1', 1, 'DSC45127456364136', 1),
	('LA_SC18_2', 2, 'DSC45127456364136', 1),
	('LA_huracan_evo_1', 1, 'WFB57382284395839', 1),
	('LA_huracan_evo_2', 2, 'WFB57382284395839', 1),
	('LA_huracan_1', 1, 'ZFA16900014979233', 1),
	('LA_huracan_2', 2, 'ZFA16900014979233', 1),
	('LA_huracan_3', 3, 'ZFA16900014979233', 1),
	('LA_huracan_4', 4, 'ZFA16900014979233', 1),
	('LA_centenario_1', 1, 'LPP47551182837438', 1),
	('LA_centenario_2', 2, 'LPP47551182837438', 1),
	('LA_centenario_3', 3, 'LPP47551182837438', 1),
	('LA_aventador_SVJ_1', 1, 'POQ00979798966966', 1),
	('LA_aventador_SVJ_2', 2, 'POQ00979798966966', 1),
	('LA_aventador_1', 1, 'FDD57281182322381', 1),
	('LA_aventador_2', 2, 'FDD57281182322381', 1),
	('FO_gt_1', 1, 'CXZ57129119239238', 1),
	('FO_gt_2', 2, 'CXZ57129119239238', 1),
	('FE_laferrari_1', 1, 'YQS48534723283457', 1),
	('FE_laferrari_2', 2, 'YQS48534723283457', 1),
	('FE_laferrari_3', 3, 'YQS48534723283457', 1),
	('FE_laferrari_4', 4, 'YQS48534723283457', 1),
	('FE_488GTB_1', 1, 'UTY58475573280090', 1),
	('FE_488GTB_2', 2, 'UTY58475573280090', 1),
	('CH_corvette_C8_1', 1, 'AZA38483284722822', 1),
	('CH_corvette_C8_2', 2, 'AZA38483284722822', 1),
	('BU_chiron_GT_1', 1, 'LAQ48374832371909', 1),
	('BU_chiron_GT_2', 2, 'LAQ48374832371909', 1),
	('BU_chiron_1', 1, 'RHR47283748373749', 1),
	('BU_chiron_2', 2, 'RHR47283748373749', 1),
	('BU_chiron_3', 3, 'RHR47283748373749', 1),
	('BU_chiron_4', 4, 'RHR47283748373749', 1),
	('BMW_i8_1', 1, 'PYT50987956506921', 1),
	('BMW_i8_2', 2, 'PYT50987956506921', 1),
	('BMW_i8_3', 3, 'PYT50987956506921', 1),
	('AU_r8_v10_1', 1, 'XVC48574837458848', 1),
	('AU_r8_v10_2', 2, 'XVC48574837458848', 1),
	('AsM_vanquish_1', 1, 'JYC48374832219067', 1),
	('AsM_vanquish_2', 2, 'JYC48374832219067', 1);

INSERT INTO privilege (nomPrivilegeFR, nomPrivilegeEN, visibilite) VALUES
	('Administrateur', 'Administrator', 1),
	('Employé', 'Employee', 1), 
	('Client', 'Customer', 1);
	
INSERT INTO utilisateur (prenom, nom, dateNaissance, adresse, codePostal, telephone, cellulaire, courriel, pseudonyme, motDePasse, codeOubliMDP, dateExpirationCode, villeId, privilegeId, visibilite) VALUES 
	('Bob', 'Ross', '1942-10-29', '123 Arc-en-ciel', 'H1H 2H2', '514-555-5555', '438-444-4444', 'bob.ross@gmail.com', 'brosse', '$2y$10$xUgJZzRMPpNpEzVpIqy2oOjq.H2TPktBuc9eV2W1LmcInvgW2u3SO', 'test code mot passe', '2020-10-29', 1, 1, 1),
	('Annie', 'Brocoli', '1971-01-22', '456 Arc-en-ciel', 'H1H 2H2', '514-555-2222', '438-444-3333', 'annie.b@gmail.com', 'brocoli', '$2y$10$yU05MLPgLbfEAdSypKGnX.9zRQwk7HdWdt1S3H3xxR.09a6rWCf8a', 'test 2 code mot passe2', '2023-06-12', 1, 3, 1);

INSERT INTO commande (dateCommande, usagerId, visibilite) VALUES 
	('2021-04-13 00:45:52', 2, 1);

INSERT INTO modePaiement (nomModeFR, nomModeEN, visibilite) VALUES
	('Espèces', 'Cash', 1), 
	('Carte de crédit', 'Credit card', 1), 
	('Carte de débit', 'Debit card', 1), 
	('Virement bancaire', 'Bank transfer', 1), 
	('Passerelle de paiement', 'Payment Gateway', 1);

INSERT INTO statut (nomStatutFR, nomStatutEN, visibilite) VALUES
	('En attente', 'Pending', 1), 
	('Réservé', 'Reserved', 1),
	('Facturé', 'Invoiced', 1);

INSERT INTO expedition (nomExpeditionFR, nomExpeditionEN, visibilite) VALUES
	('Livraison locale', 'Local Delivery', 1), 
	('Ramassage', 'Pickup', 1);
	
INSERT INTO commandeVoiture (commandeNo, voitureId, prixVente, depot, statutId, expeditionId, modePaiementNo, visibilite) VALUES 
	(1, 'ABC12300067154336', 15000.00, 0, 1, 2, 2, 1),
	(1, 'AVF51847456154145', 15000.00, 5000.00, 3, 2, 2, 1);

INSERT INTO facture (noFacture, dateFacture, prixFinal, visibilite) VALUES 
	(1, '2021-04-14 01:01:12', 150000, 1);