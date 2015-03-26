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
    amount INT,
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
    amountUsed INT,
    FOREIGN KEY (cookieName) REFERENCES Cookie(name),
	FOREIGN KEY (ingredientName) REFERENCES Ingredient(name)
);

CREATE TABLE IngredientPurchase (
    ingredientName VARCHAR(50) NOT NULL,
	time DATE NOT NULL,
    quantity INT,
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

INSERT INTO Customer values('Customer A', 'Location A');
INSERT INTO Customer values('Customer B', 'Location A');

