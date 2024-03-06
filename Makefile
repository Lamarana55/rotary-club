# local:
#  @docker-compose stop && docker-compose up --build -d --remove-orphans
build:
	cp .env.example .env &&   composer update --ignore-platform-reqs &&   php artisan key:generate &&   php artisan storage:link &&   php artisan route:cache &&   php artisan config:cache &&   php artisan config:clear &&   php artisan cache:clear &&   php artisan migrate:fresh --seed

config-cache:
	  php artisan route:cache &&   php artisan config:cache &&   php artisan config:clear &&   php artisan cache:clear &&   php artisan view:clear
composer-update:
	  composer update --ignore-platform-reqs
composer-install:
	  composer update --ignore-platform-req=ext-zip
composer-dump-autoload:
	  composer dump-autoload
npm-install:
	  npm install --force &&   npm run dev
key-generate:
	docker-compose run  php artisan key:generate
M?=''
C?=''
T?=''
makemigrations:
	  php artisan make:migration create_$M_table
add-column:
	  php artisan make:migration add_$C_to_$T_table --table=$T
db-migrate:
	  php artisan migrate
db-refresh:
	  php artisan migrate:refresh --seed
db-fresh:
	  php artisan migrate:fresh --seed
seed:
	  php artisan db:seed

storage-link:
	  php artisan storage:link

drop:
	  php artisan schema:dump

component:
	  php artisan make:livewire $T

send_mail:
	  php artisan send:mail

