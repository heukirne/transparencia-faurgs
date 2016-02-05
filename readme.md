## Transparencia Faurgs

Based on https://github.com/laravel/quickstart-intermediate/

Install Project

* git clone 
* sudo a2ensite faurgs.conf
* sudo a2enmod rewrite
* composer install
* cp .env.example .env (change database config and app_key)
* chmod -R o+w storage
* chmod -R o+w bootstrap/cache