@echo off
REM Windows bootstrap (CMD) — v5
docker compose up -d --build
docker compose exec app bash -lc "composer --version && composer config -g process-timeout 1800 && composer config -g cache-dir ${COMPOSER_CACHE_DIR:-/tmp/composer-cache}"
docker compose exec app bash -lc "[ -f composer.json ] || composer create-project --no-progress --no-interaction --prefer-dist laravel/laravel ."
docker compose exec app bash -lc "rm -f composer.lock && rm -rf vendor/* && composer clear-cache || true"
docker compose exec app bash -lc "COMPOSER_MEMORY_LIMIT=-1 COMPOSER_PROCESS_TIMEOUT=1800 COMPOSER_ALLOW_SUPERUSER=1 composer require -W --no-progress --no-interaction --prefer-dist filament/filament:^3.2 danharrin/livewire-rate-limiting:^1.3 laravel/sanctum:^4.0 laravel/breeze --dev || composer require -W --no-progress --no-interaction --prefer-dist filament/filament:^3.2 danharrin/livewire-rate-limiting:^1.3 laravel/sanctum:^4.0 laravel/breeze --dev"
docker compose exec app bash -lc "php artisan breeze:install blade --dark --pest || php artisan breeze:install blade --pest"
docker compose exec app bash -lc "php artisan vendor:publish --provider=Laravel\Sanctum\SanctumServiceProvider --force"
docker compose exec app bash -lc "cp -n .env.example .env || true && php artisan key:generate || true"
docker compose exec app bash -lc "php artisan migrate --seed || true"
echo.
echo Done. Open http://localhost:8080 (admin at /admin). Default login: admin@example.com / password
echo.
