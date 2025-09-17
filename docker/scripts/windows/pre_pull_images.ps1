foreach ($img in @("php:8.3-fpm","composer:2","nginx:1.27-alpine","mysql:8.4","redis:7-alpine")) {
  Write-Host "Pulling $img ..."
  for ($i=1; $i -le 3; $i++) { docker pull $img && break; Start-Sleep -Seconds 5 }
}
