Change directory and start a PHP-server to connect to localhost for testing the program:

cd phproot
php -S 127.0.0.1:8080

Then use a web brower to start the pogram by going to
http://localhost:8080/index.php

Use the "Place Orders" button to place orders into the system.

Use the "Block Cookies" button to block cookies from delivery.

Use the "Produce Pallets" button to turn orders into produced cookies on pallets. This needs to be done for the "Block Cookies" and "Search" buttons to work properly.

Use the "Search" button to search for pallets with different criterias.

Use the "List available ingredients" button to list all the available ingredients.

Use the "List recipes" button to list the recipes for the cookies that can be produced and ordered.

To add more ingredients, recipies and delivery dates, use mysql to access the database and modify the values. 