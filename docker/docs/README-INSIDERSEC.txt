Sanctum protection for /admin:
1) This project ships a middleware App\Http\Middleware\SanctumOrSession.
2) Add an alias in app/Http/Kernel.php:
   protected $middlewareAliases = [
       // ...
       'sanctum_or_session' => \App\Http\Middleware\SanctumOrSession::class,
   ];
3) The Filament panel provider already references the class directly in ->middleware().

Auth setup:
- Run `make bootstrap` to install Laravel, Sanctum, Breeze, and publish Sanctum.
- Then visit http://localhost:8080/login, log in as the seeded user (admin@example.com / password), and open /admin.
- For token-auth access to /admin, create a token: user()->createToken('panel')->plainTextToken and send it as Bearer token.
