$ErrorActionPreference = "Stop"

$projectRoot = Split-Path -Parent $PSScriptRoot
Set-Location $projectRoot

function Invoke-Compose {
    param([string[]]$Arguments)

    & docker compose @Arguments
    if ($LASTEXITCODE -ne 0) {
        throw "docker compose $($Arguments -join ' ') ha fallado con código $LASTEXITCODE."
    }
}

Write-Host "== FictionPlanet Docker Setup =="
Write-Host ""

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    throw "Docker no está instalado o no está disponible en PATH. Instala Docker Desktop."
}

& docker compose version *> $null
if ($LASTEXITCODE -ne 0) {
    throw "Docker Compose no está disponible. Abre Docker Desktop y vuelve a intentarlo."
}

Write-Host "[1/4] Copiando .env.docker -> .env"
Copy-Item -Force .env.docker .env

Write-Host "[2/4] Construyendo imagen..."
Invoke-Compose @("build")

Write-Host "[3/4] Levantando contenedores (PHP + MariaDB)..."
Invoke-Compose @("up", "-d")

Write-Host "[4/4] Instalando dependencias Composer..."
Invoke-Compose @("exec", "app", "composer", "install", "--no-interaction", "--optimize-autoloader")

Write-Host ""
Write-Host "== Listo =="
Write-Host "App:      http://localhost:8080"
Write-Host "Login:    Asimov / 1234 (Root)"
Write-Host "          Asimov2 / 1234 (Admin)"