# Dev Docs
The purpose to develop this tools for develop documentation and store it into database and make it centralize. 
### How to install it?
Install composer package's first.

    composer install

Clear cache and other stuffs.

    php artisan optimze:clear

Make migration in your database

    php artisan migrate

Install passport

	php artisan passpost:install

Make this project live

	php artisan serve

Run docker to run following command 

	docker compose up -d