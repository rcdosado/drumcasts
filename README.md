# Drumcasts
Drummers directory index. REST API

Installation
------------

  1. clone the repository `git clone https://github.com/rcdosado/drumcasts.git`
  2. `cd drumcasts`
  3. `composer install`
  4. install mysql, create drumcasts and drumcasts_testing databases, run it
  5. create .env file i.e `touch .env` then put necessary values like so:
  ```
	APP_NAME=Drumcasts
	APP_ENV=local
	APP_KEY=
	APP_DEBUG=true
	APP_LOG_LEVEL=debug
	APP_URL=http://localhost:3000

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=drumcasts
	DB_USERNAME=root
	DB_PASSWORD=yourpasswordtoyourdatabasehere

	BROADCAST_DRIVER=log
	CACHE_DRIVER=file
	SESSION_DRIVER=file
	QUEUE_DRIVER=sync

	REDIS_HOST=127.0.0.1
	REDIS_PASSWORD=null
	REDIS_PORT=6379

	MAIL_DRIVER=smtp
	MAIL_HOST=smtp.mailtrap.io
	MAIL_PORT=2525
	MAIL_USERNAME=null
	MAIL_PASSWORD=null
	MAIL_ENCRYPTION=null

  ```
  6. run migration `php artisan migrate`
  7. run tests `vendor/bin/phpunit`
  8. (optional)seed values `php artisan db:seed` (see model factory) defaults to 25 entries
  9. run server `php -S localhost:3000 -t public/` or use LAMP or WAMP
  10. go to url `localhost:3000/drummers`
