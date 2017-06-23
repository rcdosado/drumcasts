# drumcasts
Drummers directory index. REST API

installation
------------

  1. clone the repository `git clone https://github.com/rcdosado/drumcasts.git`
  2. `cd drumcasts`
  3. `composer install`
  4. install mysql, create drumcasts and drumcasts_testing databases
  5. create .env file i.e `touch .env` then put necessary values like so:

  6. run migration `php artisan migrate`
  7. run tests `vendor/bin/phpunit`
  8. (optional)seed values `php artisan db:seed` (see model factory) defaults to 25 entries
  9. run server `php -S localhost:3000 -t public/` or use LAMP or WAMP
  10. go to url `localhost:3000/drummers`
