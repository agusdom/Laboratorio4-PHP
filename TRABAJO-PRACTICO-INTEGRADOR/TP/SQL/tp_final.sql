CREATE DATABASE tp_final;

use tp_final;

CREATE TABLE tp_final.artists
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    artisticName VARCHAR(30) NOT NULL,
    picture VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)Engine=InnoDB;


CREATE TABLE tp_final.categories
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
)Engine=InnoDB;

CREATE TABLE tp_final.events
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    categoryId INT NOT NULL DEFAULT 0,
    picture VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (categoryId) REFERENCES categories(id) 
)Engine=InnoDB;

CREATE TABLE tp_final.rol
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
)Engine=InnoDB;

CREATE TABLE tp_final.users
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    rolId INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (rolId) REFERENCES rol(id) 
)Engine=InnoDB;

CREATE TABLE tp_final.placeEvents
(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    capacity INT NOT NULL,
    PRIMARY KEY (id)
)Engine=InnoDB;

CREATE TABLE tp_final.calendars
(
	idCalendar INT NOT NULL UNIQUE AUTO_INCREMENT,
    dateCalendar DATE NOT NULL,
    idEvent INT NOT NULL,
    idPlace INT NOT NULL, 
    PRIMARY KEY (idCalendar),
    FOREIGN KEY (idEvent) REFERENCES events(id),
    FOREIGN KEY (idPlace) REFERENCES placeEvents(id)
)Engine=InnoDB;

CREATE TABLE tp_final.artistsXcalendars
(
	idArtist INT NOT NULL,
	idCalendar INT NOT NULL,
    PRIMARY KEY (idArtist, idCalendar),
    FOREIGN KEY (idArtist) REFERENCES artists(id),
    FOREIGN KEY (idCalendar) REFERENCES calendars(idCalendar) ON DELETE CASCADE
)Engine=InnoDB;

CREATE TABLE tp_final.SeatTypes
(
	idSeatType INT NOT NULL UNIQUE AUTO_INCREMENT,
    typeName VARCHAR(30) NOT NULL,
    PRIMARY KEY (idSeatType)
)Engine=InnoDB;

CREATE TABLE tp_final.EventSeats
(
	idEventSeat INT NOT NULL UNIQUE AUTO_INCREMENT,
    price DECIMAL(15,2) NOT NULL,
    quantity INT NOT NULL,
    remains INT NOT NULL,
    idCalendar INT NOT NULL,
    idSeatType INT NOT NULL,
    PRIMARY KEY (idEventSeat),
    FOREIGN KEY (idCalendar) REFERENCES calendars(idCalendar),
    FOREIGN KEY (idSeatType) REFERENCES SeatTypes(idSeatType)
)Engine=InnoDB;

CREATE TABLE tp_final.Purchases
(
	idPurchase INT NOT NULL UNIQUE AUTO_INCREMENT,
    datePurchase DATE NOT NULL,
    idUser INT NOT NULL,
    PRIMARY KEY (idPurchase),
    FOREIGN KEY (idUser) REFERENCES users(id)
)Engine=InnoDB;

CREATE TABLE tp_final.PurchaseRows
(
	idPurchaseRow INT NOT NULL UNIQUE AUTO_INCREMENT,
	idPurchase INT NOT NULL,
    idEventSeat INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    PRIMARY KEY (idPurchaseRow),
    FOREIGN KEY (idPurchase) REFERENCES purchases(idPurchase),
    FOREIGN KEY (idEventSeat) REFERENCES EventSeats(idEventSeat)
)Engine=InnoDB;


#Carga de roles
INSERT INTO `rol`(`id`, `name`) VALUES (1,"admin");
INSERT INTO `rol`(`id`, `name`) VALUES (2,"cliente"); 

#Carga de un usuario para comprobar el log1n 
INSERT INTO `users` (`name`, `lastname`, `email`, `password`, `rolId`) VALUES
('agustin', 'caceres', 'agustincaceres96@hotmail.com', '123', 1),
('nicolas', 'rimoldi', 'rimoldinicolas@gmail.com', '123', 2);