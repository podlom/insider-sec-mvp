# InsiderSec MVP (Windows Ready v5)

This package:
- Bakes Composer into the PHP image
- Uses named volumes for vendor/ and node_modules/
- Cleans composer.lock/vendor before install to avoid partial-update conflicts
- Uses `composer require -W --prefer-dist` (and retries once)
- Increases Composer timeout to 1800s

## Run
1) Extract to a path outside OneDrive if possible (e.g., C:\dev\insider-sec-mvp)
2) PowerShell:  ./bootstrap.ps1   (or CMD: bootstrap.bat)
3) Visit http://localhost:8080  (admin at /admin)
   Default user: admin@example.com / password

If you previously tried other versions, you may want to reset once:
    docker compose down -v
