default: setup

setup: up install migration test

install:
	docker compose run --rm php sh -c "composer install"

migration:
	docker compose run --rm php sh -c "bin/console doctrine:migrations:migrate --no-interaction"

up:
	docker compose up -d

test:
	docker compose run --rm php sh -c "composer install && php /var/www/html/vendor/phpunit/phpunit/phpunit --no-configuration /var/www/html/tests/Unit"
