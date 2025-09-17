docker compose exec app bash -lc '
set -e

# 1) Write a patch script (quoted heredoc so PowerShell can’t mangle it)
cat > /tmp/filament_v3_patch.php <<'"'"'PHP'"'"'
<?php
$roots = [
    __DIR__ . "/../app/Filament/Resources",
    __DIR__ . "/../app/Filament/Pages",
    __DIR__ . "/../app/Filament",
];
$replacements = [
    // imports
    "use Filament\\Resources\\Form;"  => "use Filament\\Forms\\Form;",
    "use Filament\\Resources\\Table;" => "use Filament\\Tables\\Table;",
    "use Filament\\Pages\\Actions;"   => "use Filament\\Actions;",
    // type names (in signatures / bodies)
    "Filament\\Resources\\Form"  => "Filament\\Forms\\Form",
    "Filament\\Resources\\Table" => "Filament\\Tables\\Table",
];
$filesPatched = 0;
foreach ($roots as $root) {
    if (!is_dir($root)) continue;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if ($f->getExtension() !== "php") continue;
        $path = $f->getPathname();
        $code = file_get_contents($path);
        $orig = $code;
        foreach ($replacements as $from => $to) {
            $code = str_replace($from, $to, $code);
        }
        if ($code !== $orig) {
            file_put_contents($path, $code);
            $filesPatched++;
            echo "Patched: {$path}\n";
        }
    }
}
echo "Done. Files patched: {$filesPatched}\n";
PHP

# 2) Run the patcher
php /tmp/filament_v3_patch.php

# 3) Rebuild autoloads WITHOUT running composer scripts that currently fail
composer dump-autoload -o --no-scripts

# 4) Clear Laravel caches
php artisan optimize:clear
'
