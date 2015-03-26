USE db42;

set foreign_key_checks = 0;
drop table if exists Pallet;
drop table if exists Customer;
drop table if exists Cookie;
drop table if exists Ingredient;
drop table if exists Recepie;
drop table if exists IngredientPurchase;
drop table if exists OrderQuantity;
drop table if exists Orders;
set foreign_key_checks = 1;


CREATE TABLE Customer (
    name VARCHAR(50) NOT NULL,
	location VARCHAR(50) NOT NULL,
    PRIMARY KEY (name)
);

CREATE TABLE Cookie (
   	name VARCHAR(50) NOT NULL,
    PRIMARY KEY (name)
);

CREATE TABLE Ingredient (
    name VARCHAR(50) NOT NULL,
    amount FLOAT,
    PRIMARY KEY (name)
);

CREATE TABLE Orders (
	orderNbr INT auto_increment,
    customerName VARCHAR(50) NOT NULL,
    deliveryDate DATE NOT NULL,
    PRIMARY KEY (orderNbr),
	FOREIGN KEY (customerName) REFERENCES Customer(name)
);

CREATE TABLE Recepie (
    cookieName VARCHAR(50) NOT NULL,
	ingredientName VARCHAR(50) NOT NULL,
    amountUsed FLOAT,
    FOREIGN KEY (cookieName) REFERENCES Cookie(name),
	FOREIGN KEY (ingredientName) REFERENCES Ingredient(name)
);

CREATE TABLE IngredientPurchase (
    ingredientName VARCHAR(50) NOT NULL,
	time DATE NOT NULL,
    quantity FLOAT,
    FOREIGN KEY (ingredientName) REFERENCES Ingredient(name)
);

CREATE TABLE OrderQuantity (
    cookieName VARCHAR(50) NOT NULL,
	orderNbr INT NOT NULL,
    quantity INT,
    FOREIGN KEY (cookieName) REFERENCES Cookie(name),
	FOREIGN KEY (orderNbr) REFERENCES Orders(orderNbr)
);

CREATE TABLE Pallet (
    palletID INT auto_increment,
    cookieName VARCHAR(50) NOT NULL,
	purchaseDate DATE,
	deliveredDate DATE,
	isBlocked INT NOT NULL,
	orderNbr INT,
    PRIMARY KEY (palletID),
	FOREIGN KEY (cookieName) REFERENCES Cookie(name),
	FOREIGN KEY (orderNbr) REFERENCES Orders(OrderNbr)
);

INSERT INTO Customer values('Finkakor AB', 'Helsingborg');
INSERT INTO Customer values('Smabrod AB', 'Malmo');
INSERT INTO Customer values('Kaffebrod AB', 'Landskrona');
INSERT INTO Customer values('Bjudkakor AB', 'Ystad');
INSERT INTO Customer values('Kalaskakor AB', 'Trelleborg');
INSERT INTO Customer values('Partykakor AB', 'Kristianstad');
INSERT INTO Cookie values('Nut ring');
INSERT INTO Cookie values('Nut cookie');
INSERT INTO Cookie values('Amneris');
INSERT INTO Cookie values('Tango');
INSERT INTO Cookie values('Almond delight');
INSERT INTO Cookie values('Berliner');
