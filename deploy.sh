#!/usr/bin/env bash
# ==============================================================================
# Script Deployment SIMRS RS Tarakan - OAuth Service
# Lokasi Server: /var/www/oauth
# Service Systemd: octane-oauth (Port 8001)
# ==============================================================================

set -Eeuo pipefail

# Warna Output Terminal
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Direktori Target
DEPLOY_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" >/dev/null 2>&1 && pwd)"
cd "${DEPLOY_DIR}"

log_info() {
    echo -e "${CYAN}[$(date '+%Y-%m-%d %H:%M:%S')] [INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[$(date '+%Y-%m-%d %H:%M:%S')] [SUCCESS]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[$(date '+%Y-%m-%d %H:%M:%S')] [WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[$(date '+%Y-%m-%d %H:%M:%S')] [ERROR]${NC} $1" >&2
}

run_as_root() {
    if [ "$(id -u)" -eq 0 ]; then
        "$@"
    elif command -v sudo >/dev/null 2>&1; then
        sudo "$@"
    else
        log_error "Perintah '$*' membutuhkan hak akses root / sudo."
        exit 1
    fi
}

echo -e "${BLUE}================================================================${NC}"
echo -e "${BLUE}         DEPLOYMENT OAUTH SERVICE - RSUD TARAKAN                ${NC}"
echo -e "${BLUE}================================================================${NC}"
log_info "Direktori kerja: ${DEPLOY_DIR}"

# 1. Pengecekan Environment
log_info "=== [1/6] Memeriksa Environment & Dependencies ==="
if ! command -v php >/dev/null 2>&1; then
    log_error "PHP tidak terpasang di sistem!"
    exit 1
fi
if ! command -v composer >/dev/null 2>&1; then
    log_error "Composer tidak terpasang di sistem!"
    exit 1
fi
if ! command -v git >/dev/null 2>&1; then
    log_error "Git tidak terpasang di sistem!"
    exit 1
fi
log_success "Environment valid: PHP $(php -r 'echo PHP_VERSION;') & Composer"

# 2. Sinkronisasi Git
log_info "=== [2/6] Sinkronisasi Repositori Git (origin main) ==="
git fetch origin main
git pull origin main
CURRENT_COMMIT=$(git rev-parse --short HEAD)
CURRENT_MSG=$(git log -1 --pretty=%B | head -n 1)
log_success "Tersinkronisasi pada commit: ${CURRENT_COMMIT} - ${CURRENT_MSG}"

# 3. Instalasi / Pembaruan Dependensi Composer
log_info "=== [3/6] Menginstal Dependensi Composer (Production) ==="
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
log_success "Dependensi Composer siap"

# 4. Migrasi Database (Non-Destructive)
log_info "=== [4/7] Menjalankan Database Migrations ==="
# PERINGATAN KERAS: JANGAN PERNAH MENJALANKAN migrate:fresh PADA DATABASE STAGING / PRODUKSI
php artisan migrate --force
log_success "Migrasi database selesai dijalankan tanpa menghapus data yang ada"

# 5. Sinkronisasi Roles, Permissions & OAuth Clients (Database Seeding)
log_info "=== [5/7] Menjalankan Database Seeder (Roles, Permissions & OAuth Clients) ==="
php artisan db:seed --force
log_success "Roles, permissions, OAuth clients, dan akun staf berhasil disinkronkan"

# 6. Reset & Pemanasan Cache Framework
log_info "=== [6/7] Mengoptimalkan Cache Framework Laravel OAuth ==="
php artisan permission:cache-reset || log_warn "Permission cache reset dilewati"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
log_success "Konfigurasi, routing, dan view OAuth berhasil di-cache"

# 7. Restart Service & Health Check
log_info "=== [7/7] Me-restart Layanan Octane OAuth & Health Check ==="
if command -v systemctl >/dev/null 2>&1; then
    run_as_root systemctl restart octane-oauth
    sleep 2
    if systemctl is-active --quiet octane-oauth; then
        log_success "Service octane-oauth aktif dan berjalan normal"
    else
        log_error "Service octane-oauth gagal aktif. Periksa log: journalctl -u octane-oauth.service -n 50"
        exit 1
    fi
else
    log_warn "systemctl tidak ditemukan, me-restart octane via artisan..."
    php artisan octane:reload || true
fi

# Endpoint Health Check
HEALTH_CODE=$(curl -s -o /dev/null -w "%{http_code}" -X POST -H "Accept: application/json" http://127.0.0.1:8001/api/login || echo "000")
if [ "${HEALTH_CODE}" -eq 422 ] || [ "${HEALTH_CODE}" -eq 200 ]; then
    log_success "Health check endpoint login (Port 8001) sukses dengan HTTP status: ${HEALTH_CODE}"
else
    log_warn "Health check endpoint login (Port 8001) mengembalikan respons: HTTP ${HEALTH_CODE}"
fi

echo -e "${GREEN}================================================================${NC}"
echo -e "${GREEN}     DEPLOYMENT OAUTH SERVICE SELESAI DENGAN SUKSES!            ${NC}"
echo -e "${GREEN}================================================================${NC}"
