# Dev Docs
The purpose of developing these tools for develop documentation and store it in the database and make it centralized. 
### How to install it?
Install composer packages first.

    composer install

Clear cache and other stuff.    

    php artisan optimize:clear

Make migration in your database

    php artisan migrate

Install passport

	php artisan passport:install

Make this project live

	php artisan serve

Run docker to run following command 

	docker compose up -d