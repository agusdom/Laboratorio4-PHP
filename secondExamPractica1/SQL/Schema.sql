drop DATABASE if EXISTS clientsdb; 
CREATE DATABASE clientsdb;

USE clientsdb;

CREATE TABLE users
(
    userId INT NOT NULL AUTO_INCREMENT,
    email NVARCHAR(100) NOT NULL,
    password NVARCHAR(100) NOT NULL,
    PRIMARY KEY (userId)
)ENGINE=InnoDB;

CREATE TABLE categories
(
    categoryId INT NOT NULL AUTO_INCREMENT,
    description NVARCHAR(100) NOT NULL,
    isActive BIT DEFAULT 1,
    PRIMARY KEY (categoryId)
)ENGINE=InnoDB;

CREATE TABLE clients
(
    clientId INT NOT NULL AUTO_INCREMENT,
    categoryId INT NOT NULL,
    lastName NVARCHAR(100) NOT NULL,
    firstName NVARCHAR(100) NOT NULL,
    dni CHAR(8) NOT NULL,
    email NVARCHAR(100) NOT NULL,
    address NVARCHAR(500) NOT NULL,
    picture NVARCHAR(500) NOT NULL,
    PRIMARY KEY (clientId)
)ENGINE=InnoDB;

ALTER TABLE clients ADD FOREIGN KEY FK_Clients_Categories (categoryId) REFERENCES categories (categoryId) ON UPDATE RESTRICT ON DELETE RESTRICT;

DELIMITER $$
CREATE PROCEDURE Clients_Add(IN CategoryId INT, IN LastName NVARCHAR(100), IN FirstName NVARCHAR(100), IN DNI CHAR(8), IN Email NVARCHAR(100), IN Address NVARCHAR(250), IN picture NVARCHAR(250))
BEGIN
	INSERT INTO clients
		(categoryId, lastName, firstName, dni, email, address, picture)
	VALUES
		(CategoryId, LastName, FirstName, DNI, Email, Address, picture);
END$$
DELIMITER ;

INSERT INTO users
    (email, password)
VALUES
    ('user1@miapp.com', 'user123'),
    ('user2@miapp.com', 'user789');

INSERT INTO categories
    (description, isActive)
VALUES
    ('Individual', 1),
    ('Corporate', 1),
    ('Premier', 0),
    ('Black', 1);