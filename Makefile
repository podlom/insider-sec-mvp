SHELL := /bin/bash

up: ## Start stack
	docker compose up -d --build

down: ## Stop stack
	docker compose down -v

sh: ## Shell into app
	docker compose exec app bash

bootstrap: up ## Create Laravel skeleton & install packages inside container
	# Create Laravel if artisan is missing
	docker compose exec app bash -lc 'test -f artisan || composer create-project laravel/laravel .'
	# Require core packages
	docker compose exec app bash -lc 'composer require filament/filament:^3.2 spatie/laravel-permission:^6.10 spatie/laravel-activitylog:^4.7 laravel/scout:^10.6 meilisearch/meilisearch-php:^1.6 league/csv:^9.0 laravel/sanctum:^4.0'
	# Dev scaffolding
	docker compose exec app bash -lc 'composer require laravel/breeze --dev'
	# Install Breeze (Blade)
	docker compose exec app bash -lc 'php artisan breeze:install blade --dark --pest'
	docker compose exec app bash -lc 'php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"'
	# Copy our app files
	docker compose exec app bash -lc 'mkdir -p app/Filament/Providers app/Filament/Resources app/Http/Middleware app/Services/Rules app/Console/Commands database/seeders database/migrations routes docker/php docker/nginx storage/app config'
	# After copying (host->container bind mount already has files)
	# Migrate & seed
	docker compose exec app bash -lc 'cp -n .env.example .env || true && php artisan key:generate && php artisan migrate --seed'
	# Build frontend (optional)
	docker compose exec app bash -lc 'npm install && npm run build || true'

app-install: ## Composer install + key + migrate + seed (for existing app)
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --seed

queue: ## Run queue worker (dev)
	docker compose exec app php artisan queue:work --tries=1

seed-demo: ## Seed demo data & sample CSV import
	docker compose exec app php artisan demo:seed
	docker compose exec app php artisan security:events:import --file=security_events.csv
