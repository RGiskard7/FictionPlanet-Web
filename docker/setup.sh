#!/bin/bash
set -e

echo "== FictionPlanet Docker Setup =="
echo ""

if ! command -v docker &> /dev/null; then
    echo "Docker no instalado."
    echo "Instala Docker Desktop para Apple Silicon:"
    echo "  https://www.docker.com/products/docker-desktop/"
    exit 1
fi

echo "[1/4] Copiando .env.docker → .env"
cp .env.docker .env

echo "[2/4] Construyendo imagen..."
docker compose build

echo "[3/4] Levantando contenedores (PHP + MariaDB)..."
docker compose up -d

echo "[4/4] Instalando dependencias Composer..."
docker compose exec app composer install --no-interaction --optimize-autoloader

echo ""
echo "== Listo =="
echo "App:      http://localhost:8080"
echo "Login:    Asimov / 1234 (Root)"
echo "          Asimov2 / 1234 (Admin)"
echo ""
echo "Comandos útiles:"
echo "  docker compose down          # Parar contenedores"
echo "  docker compose up -d         # Iniciar en segundo plano"
echo "  docker compose logs -f app   # Ver logs de la app"
echo "  docker compose exec app bash # Shell dentro del contenedor"
echo "  docker compose exec app composer test  # Ejecutar tests"
