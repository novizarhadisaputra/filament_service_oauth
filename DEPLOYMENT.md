# Panduan Deployment OAuth Service - SIMRS RSUD Tarakan

Dokumen ini memuat panduan standar operasional deployment untuk layanan **OAuth Authentication & Authorization Service** (Filament + Passport) SIMRS RSUD Tarakan.

---

## 1. Informasi Layanan & Arsitektur

| Parameter | Detail |
| :--- | :--- |
| **Repositori Internal** | `http://192.168.6.179/novizar/oauth.git` |
| **Direktori Server** | `/var/www/oauth` |
| **Engine / Runtime** | PHP 8.4 (CLI & FPM) + RoadRunner v3 |
| **Application Server** | Laravel Octane (`octane-oauth.service`) |
| **Port Internal** | `8001` (Listening: `0.0.0.0:8001`) |
| **Database** | PostgreSQL (`oauth`) |

---

## 2. Persyaratan Sistem (Prerequisites)

- **PHP**: Versi `>= 8.2` (Rekomendasi server: `8.4`) dengan ekstensi: `pdo_pgsql`, `pgsql`, `redis`, `gd`, `zip`, `bcmath`, `sockets`.
- **Composer**: Versi `>= 2.7.x`.
- **Git**: Akses pull ke branch `main`.
- **RoadRunner Binary**: Terpasang di `/var/www/oauth/rr`.
- **Hak Akses**: User `novizar` dengan izin `sudo` untuk mengelola service systemd.

---

## 3. Prosedur Deployment Standar (Manual Step-by-Step)

Jalankan langkah-langkah berikut secara berurutan saat melakukan pembaruan di server staging maupun produksi:

### Langkah 1: Masuk ke Direktori Layanan OAuth
```bash
cd /var/www/oauth
```

### Langkah 2: Sinkronisasi Source Code Terbaru
```bash
git fetch origin main
git pull origin main
```

### Langkah 3: Update Dependensi PHP (Composer) & Filament Assets
```bash
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
```

### Langkah 4: Eksekusi Migrasi Database (Non-Destructive)
> [!CAUTION]
> **ATURAN MUTLAK:** Dilarang keras menjalankan `php artisan migrate:fresh` pada database staging/produksi. Semua skema dan data user OAuth harus dipertahankan. Gunakan `php artisan migrate --force`.

```bash
php artisan migrate --force
```

### Langkah 5: Reset & Optimasi Cache Framework Laravel OAuth
```bash
# Reset cache permission & roles
php artisan permission:cache-reset

# Bersihkan cache lama
php artisan optimize:clear

# Kompilasi cache konfigurasi, routing, dan view Blade/Filament
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Langkah 6: Me-restart Layanan Laravel Octane OAuth
```bash
sudo systemctl restart octane-oauth
```

Pastikan status service aktif dan berjalan normal:
```bash
systemctl status octane-oauth --no-pager
```

### Langkah 7: Verifikasi Kesehatan Endpoint (Health Check)
```bash
# Uji endpoint login API OAuth (respons normal: 422 jika tanpa payload, 200 jika kredensial valid)
curl -s -o /dev/null -w "OAuth Service Status: %{http_code}\n" \
  -X POST \
  -H "Accept: application/json" \
  http://127.0.0.1:8001/api/login
```
*Hasil yang diharapkan: `HTTP 422` (menandakan routing auth OAuth siap melayani autentikasi SSO SIMRS).*

---

## 4. Prosedur Deployment Cepat (Automated Script)

Script otomasi telah disediakan di direktori aplikasi:

```bash
cd /var/www/oauth
./deploy.sh
```

Atau dijalankan dengan sudo:
```bash
echo 'n0v1@26' | sudo -S /var/www/oauth/deploy.sh
```

---

## 5. Troubleshooting & Rollback

### A. Melihat Log Error Layanan Octane OAuth
```bash
journalctl -u octane-oauth.service -n 100 -f
tail -n 100 /var/www/oauth/storage/logs/laravel.log
```

### B. Rollback ke Commit Sebelumnya
```bash
git checkout <COMMIT_HASH_SEBELUMNYA>
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart octane-oauth
```
