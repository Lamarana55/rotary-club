# local:
#  @docker-compose stop && docker-compose up --build -d --remove-orphans
build:
	cp .env.example .env && docker-compose run --rm web composer update --ignore-platform-reqs && docker-compose run --rm web php artisan key:generate && docker-compose run --rm web php artisan storage:link && docker-compose run --rm web php artisan route:cache && docker-compose run --rm web php artisan config:cache && docker-compose run --rm web php artisan config:clear && docker-compose run --rm web php artisan cache:clear && docker-compose run --rm web php artisan migrate:fresh --seed

config-cache:
	docker-compose run --rm web php artisan route:cache && docker-compose run --rm web php artisan config:cache && docker-compose run --rm web php artisan config:clear && docker-compose run --rm web php artisan cache:clear && docker-compose run --rm web php artisan view:clear
composer-update:
	docker-compose run --rm web composer update --ignore-platform-reqs
composer-install:
	docker-compose run --rm web composer update --ignore-platform-req=ext-zip
composer-dump-autoload:
	docker-compose run --rm web composer dump-autoload
npm-install:
	docker-compose run --rm web npm install --force && docker-compose run --rm web npm run dev
key-generate:
	docker-compose run web php artisan key:generate
M?=''
C?=''
T?=''
makemigrations:
	docker-compose run --rm web php artisan make:migration create_$M_table
add-column:
	docker-compose run --rm web php artisan make:migration add_$C_to_$T_table --table=$T
db-migrate:
	docker-compose run --rm web php artisan migrate
db-refresh:
	docker-compose run --rm web php artisan migrate:refresh --seed
db-fresh:
	docker-compose run --rm web php artisan migrate:fresh --seed
seed:
	docker-compose run --rm web php artisan db:seed

storage-link:
	docker-compose run --rm web php artisan storage:link

drop:
	docker-compose run --rm web php artisan schema:dump

component:
	docker-compose run --rm web php artisan make:livewire $T

send_mail:
	docker-compose run --rm web php artisan send:mail

