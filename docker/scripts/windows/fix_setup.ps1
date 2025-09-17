# Seed Laravel into /tmp/seed inside the container
docker compose exec app bash -lc '
  set -e
  rm -rf /tmp/seed
  composer create-project --no-progress --prefer-dist laravel/laravel /tmp/seed
  # Copy only files that are missing (preserve anything you already have)
  cp -an /tmp/seed/. /var/www/html/
  ls -la public/index.php artisan
'

# Ensure .env & key
docker compose exec app bash -lc 'cp -n .env.example .env || true && php artisan key:generate || true'

# Because previous Composer runs happened without a Laravel skeleton,
# reset lock/vendor and re-require with dependency graph changes allowed
docker compose exec app bash -lc '
  rm -f composer.lock && rm -rf vendor/* && composer clear-cache || true
  COMPOSER_MEMORY_LIMIT=-1 COMPOSER_PROCESS_TIMEOUT=1800 composer require -W --no-progress --no-interaction --prefer-dist \
    filament/filament:^3.2 danharrin/livewire-rate-limiting:^1.3 laravel/sanctum:^4.0 laravel/breeze --dev
'

# Install Breeze + publish Sanctum (idempotent)
docker compose exec app bash -lc 'php artisan breeze:install blade --dark --pest || php artisan breeze:install blade --pest'
docker compose exec app bash -lc 'php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" --force || true'

# Run migrations (will no-op if none yet)
docker compose exec app bash -lc 'php artisan migrate --seed || true'

# Restart Nginx
docker compose restart web

# Sanity
docker compose exec app bash -lc 'php artisan --version && ls -la public/index.php'
