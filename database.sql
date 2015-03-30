

set foreign_key_checks = 0;
drop table if exists Pallet;
drop table if exists Customer;
drop table if exists Cookie;
drop table if exists Ingredient;
drop table if exists Recipe;
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

CREATE TABLE Recipe (
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
	productionDate DATE,
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
INSERT INTO Ingredient values('Flour', '250000');
INSERT INTO Ingredient values('Butter', '250000');
INSERT INTO Ingredient values('Icing sugar', '250000');
INSERT INTO Ingredient values('Roasted, chopped nuts', '250000');
INSERT INTO Ingredient values('Fine-ground nuts', '250000');
INSERT INTO Ingredient values('Ground, roasted nuts', '250000');
INSERT INTO Ingredient values('Bread crumbs', '250000');
INSERT INTO Ingredient values('Egg whites', '20000');
INSERT INTO Ingredient values('Chocolate', '25000');
INSERT INTO Ingredient values('Marzipan', '500000');
INSERT INTO Ingredient values('Eggs', '250000');
INSERT INTO Ingredient values('Potato starch', '20000');
INSERT INTO Ingredient values('Wheat flour', '20000');
INSERT INTO Ingredient values('Sodium bicarbonate', '25000');
INSERT INTO Ingredient values('Vanilla', '25000');
INSERT INTO Ingredient values('Chopped almonds', '250000');
INSERT INTO Ingredient values('Sugar', '250000');
INSERT INTO Ingredient values('Cinnamon', '20000');
INSERT INTO Ingredient values('Vanilla sugar', '25000');
INSERT INTO Recipe values('Nut ring', 'Flour', 450);
INSERT INTO Recipe values('Nut ring', 'Butter', 450);
INSERT INTO Recipe values('Nut ring', 'Icing sugar', 190);
INSERT INTO Recipe values('Nut ring', 'Roasted, chopped nuts', 225);
INSERT INTO Recipe values('Nut cookie', 'Fine-ground nuts', 750);
INSERT INTO Recipe values('Nut cookie', 'Ground, roasted nuts', 625);
INSERT INTO Recipe values('Nut cookie', 'Bread crumbs', 125);
INSERT INTO Recipe values('Nut cookie', 'Sugar', 375);
INSERT INTO Recipe values('Nut cookie', 'Egg whites', 35);
INSERT INTO Recipe values('Nut cookie', 'Chocolate', 50);
INSERT INTO Recipe values('Amneris', 'Marzipan', 750);
INSERT INTO Recipe values('Amneris', 'Butter', 250);
INSERT INTO Recipe values('Amneris', 'Eggs', 250);
INSERT INTO Recipe values('Amneris', 'Potato starch', 25);
INSERT INTO Recipe values('Amneris', 'Wheat flour', 25);
INSERT INTO Recipe values('Tango', 'Butter', 200);
INSERT INTO Recipe values('Tango', 'Sugar', 250);
INSERT INTO Recipe values('Tango', 'Flour', 300);
INSERT INTO Recipe values('Tango', 'Sodium bicarbonate', 4);
INSERT INTO Recipe values('Tango', 'Vanilla', 2);
INSERT INTO Recipe values('Almond delight', 'Butter', 400);
INSERT INTO Recipe values('Almond delight', 'Sugar', 270);
INSERT INTO Recipe values('Almond delight', 'Chopped almonds', 279);
INSERT INTO Recipe values('Almond delight', 'Flour', 400);
INSERT INTO Recipe values('Almond delight', 'Cinnamon', 10);
INSERT INTO Recipe values('Berliner', 'Flour', 350);
INSERT INTO Recipe values('Berliner', 'Butter', 250);
INSERT INTO Recipe values('Berliner', 'Icing sugar', 100);
INSERT INTO Recipe values('Berliner', 'Eggs', 50);
INSERT INTO Recipe values('Berliner', 'Vanilla sugar', 5);
INSERT INTO Recipe values('Berliner', 'Chocolate', 50);

INSERT INTO Orders values(NULL, 'Finkakor AB', '2015-02-20');
INSERT INTO OrderQuantity values('Nut ring', 1, 20);
INSERT INTO Orders values(NULL, 'Smabrod AB', '2015-02-21');
INSERT INTO OrderQuantity values('Nut cookie', 2, 30);
INSERT INTO Orders values(NULL, 'Kalaskakor AB', '2015-02-22');
INSERT INTO OrderQuantity values('Almond delight', 3, 10);


