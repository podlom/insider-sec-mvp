docker compose exec app bash -lc ^
'set -e; rm -f composer.lock; rm -rf vendor/*; composer clear-cache; \
COMPOSER_MEMORY_LIMIT=-1 COMPOSER_PROCESS_TIMEOUT=1800 composer require -W --no-progress --no-interaction --prefer-dist \
  filament/filament:^3.3 \
  danharrin/livewire-rate-limiting:^1.3 \
  laravel/sanctum:^4.0 \
  laravel/breeze:^2.3 --dev'
