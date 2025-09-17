docker compose down -v
$env:DOCKER_BUILDKIT="0"
$env:COMPOSE_DOCKER_CLI_BUILD="0"
docker buildx prune -af
docker system prune -af --volumes
wsl --shutdown
# start Docker Desktop again and wait ~30s
