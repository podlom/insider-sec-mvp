docker compose exec app bash -lc '
  set -e
  if [ ! -f artisan ] || [ ! -f public/index.php ]; then
    rm -rf /tmp/seed
    COMPOSER_PROCESS_TIMEOUT=1800 composer create-project --no-progress --prefer-dist laravel/laravel:^11.0 /tmp/seed
    # copy only missing files to preserve your repo
    cp -an /tmp/seed/. /var/www/html/
  fi
  ls -la public/index.php artisan
'
