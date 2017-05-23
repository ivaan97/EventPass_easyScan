CREATE TABLE Tisch (
	tischNr int,
	kapazitaet int default 6 NOT NULL,
	PRIMARY KEY(tischNr)
);

CREATE TABLE Event (
	eID int NOT NULL AUTO_INCREMENT,
	eName varchar(255),
	eStartZeit  datetime,
	eEndeZeit datetime,
	eOrt varchar(255),
	eVeranstalter varchar(255),
	PRIMARY KEY(eID)
);

CREATE TABLE Benutzer (
	bEmail varchar(255),
	vorname varchar(255),
	nachname varchar(255),
	passwort varchar(255),
	typ int NOT NULL,
	PRIMARY KEY(bEmail)
);

CREATE TABLE Gast (
	barcode integer(255),
	vorname varchar(255),
	nachname varchar(255),
	geburtsDatum date,
	gIN boolean,
	eID int,
	tischNr int,
	bEmail varchar(255),
	PRIMARY KEY (barcode),
	FOREIGN KEY (eID) REFERENCES Event(eID),
	FOREIGN KEY (tischNr) REFERENCES Tisch(tischNr),
	FOREIGN KEY (bEmail) REFERENCES Benutzer(bEmail)
);
	
INSERT INTO Benutzer(bEmail, vorname, nachname, passwort, typ) VALUES ("admin@info.com", "Admin", "SystemAdmin", 1234, 1);      


