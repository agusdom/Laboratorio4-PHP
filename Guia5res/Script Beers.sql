-- create database beers;
use beers;

-- BEER TYPES --------------------------------------------------------------------

-- create table beertypes(
--     Id int not null AUTO_INCREMENT,
--     beertypecode INT not null unique,
--     Name nvarchar(120) not null,
--     Description nvarchar(256) DEFAULT "",
--     recipe nvarchar(256) DEFAULT "",
--     Primary key(Id)
-- );

-- insert into beertypes (beertypecode, name, description, recipe) values
-- (101, 'Roja', 'Red Description', 'Red Recipe'),
-- (102, 'Rubia', 'Blond Description', 'Blond Recipe'),
-- (103, 'Negra', 'Black Description', 'Black Recipe');

-- select * from beertypes;


-- BEERS --------------------------------------------------------------------------
-- create table beers(
--     Id int AUTO_INCREMENT,
--     beercode int not null unique,
--     fk_beerTypeCode int not null,
--     Name nvarchar(120) not null,
--     Description nvarchar(256) DEFAULT '',
--     density decimal DEFAULT 0.0,
--     origin nvarchar(80) DEFAULT 'Sin Asignar',
--     price decimal DEFAULT 0.0,
--     Primary key(Id),
--     FOREIGN KEY (fk_beerTypeCode) REFERENCES beerTypes (beertypecode)
-- );

-- insert into beers (beercode, fk_beertypecode, name, description, density, origin, price) VALUES
-- (100, 101, 'Imperial Pale Ale', 'Descripcion de IPA', 5.40, 'Belgica', 120.00),
-- (200, 102, 'Burton', 'Descripcion de Burton', 4.90, 'Alemania', 100.00),
-- (300, 103, 'American Amber Ale', 'Descripcion de AAA', 6.26, 'EEUU', 110.00),
-- (302, 103, 'Viejo Lobo', 'Descripcion de Viejo Lobo', 7.4, 'Belgica', 100.00);

-- select * from beers;

