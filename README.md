# Sistem Informasi Manajemen Bengkel - Tri Jaya Motor

Aplikasi web berbasis **CodeIgniter 4** untuk membantu pengelolaan operasional bengkel, mencakup manajemen data master, transaksi servis kendaraan, inventaris sparepart, sistem kasir, hingga pelaporan operasional.

Project ini dikembangkan sebagai implementasi digitalisasi proses bisnis bengkel berdasarkan observasi, wawancara, dan analisis kebutuhan operasional nyata di lapangan.

---

## Fitur Utama

- Autentikasi pengguna
- Role-Based Access Control (RBAC)
- Dashboard operasional
- Manajemen data pelanggan
- Manajemen data kendaraan
- Manajemen data mekanik
- Manajemen data sparepart
- Manajemen supplier
- Manajemen jasa servis
- Manajemen jasa luar / bubut
- Transaksi servis kendaraan
- Sistem kasir
- Pengelolaan pembelian sparepart
- Pengelolaan biaya operasional
- Pengelolaan kompensasi / pembayaran mekanik
- Laporan operasional
- Export PDF / Excel
- Migration & Seeder support

---

## Teknologi yang Digunakan

- PHP >= 8.1
- CodeIgniter 4
- MySQL / MariaDB
- Composer
- Bootstrap
- AdminLTE 3
- JavaScript
- jQuery

---

# Prasyarat

Pastikan environment development Anda sudah memiliki:

- Git
- Composer
- PHP >= 8.1
- MySQL / MariaDB
- Apache (opsional)
- Laragon / XAMPP (Windows)

---

## Required PHP Extensions

Pastikan extension berikut aktif:

- intl
- mbstring
- mysqli
- json
- openssl
- xml
- curl
- fileinfo

Cek PHP:

```bash
php -v
```

Cek Composer:

```bash
composer --version
```

---

# Install Git

Jika Git belum terinstall, install terlebih dahulu sesuai sistem operasi.

Cek Git:

```bash
git --version
```

Jika command tidak dikenali, lakukan install berikut.

---

## Windows

Download installer:

```text
https://git-scm.com/download/win
```

Jalankan installer.

Recommended setup:

- Use Git from the Windows Command Prompt
- Checkout Windows-style, commit Unix-style line endings
- Use OpenSSL library
- Use bundled OpenSSH

Setelah selesai:

```cmd
git --version
```

---

## Linux

### Ubuntu / Debian

```bash
sudo apt update
sudo apt install git -y
```

### Fedora

```bash
sudo dnf install git -y
```

### CentOS / RHEL

```bash
sudo yum install git -y
```

atau:

```bash
sudo dnf install git -y
```

### Arch Linux

```bash
sudo pacman -S git
```

Verifikasi:

```bash
git --version
```

---

## macOS

### Opsi 1 — Homebrew

Jika Homebrew belum tersedia:

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

Install Git:

```bash
brew install git
```

Verifikasi:

```bash
git --version
```

### Opsi 2 — Xcode Command Line Tools

```bash
xcode-select --install
```

Verifikasi:

```bash
git --version
```

---

## Konfigurasi Git (Recommended)

Setelah install:

```bash
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
```

Cek:

```bash
git config --list
```

---

# Clone Repository

> **Catatan:** Repository saat ini masih bersifat **private** karena project masih dalam tahap pengembangan dan belum dipresentasikan.

Clone repository:

```bash
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
cd tri-jaya-motor
```

Jika repository private, pastikan akun GitHub Anda memiliki akses.

Jika menggunakan HTTPS dan diminta autentikasi, gunakan GitHub Personal Access Token.

Alternatif SSH:

```bash
git clone git@github.com:alhilalakbar/tri-jaya-motor.git
```

---

# Penempatan Project Directory

Lokasi project tergantung environment development.

---

## Windows — XAMPP

Jika menggunakan XAMPP:

simpan project di:

```text
C:\xampp\htdocs\
```

Contoh:

```text
C:\xampp\htdocs\tri-jaya-motor
```

Clone:

```bash
cd C:\xampp\htdocs
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika menggunakan Apache bawaan XAMPP:

akses:

```text
http://localhost/tri-jaya-motor/public
```

Jika menggunakan `php spark serve`, lokasi project bebas.

Jika command `php` tidak dikenali:

```cmd
C:\xampp\php\php.exe spark serve
```

---

## Windows — Laragon

Jika menggunakan Laragon:

simpan project di:

```text
C:\laragon\www\
```

Contoh:

```text
C:\laragon\www\tri-jaya-motor
```

Clone:

```bash
cd C:\laragon\www
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Pastikan **Auto Virtual Hosts** aktif.

Biasanya URL otomatis:

```text
http://tri-jaya-motor.test
```

Update `.env`:

```env
app.baseURL = 'http://tri-jaya-motor.test/'
```

Jika menggunakan `php spark serve`, lokasi project bebas.

---

## Linux

Linux fleksibel.

---

### Opsi 1 — Development Directory (Recommended)

Gunakan:

```text
/home/USERNAME/projects/
```

Contoh:

```text
/home/hillal/projects/tri-jaya-motor
```

Clone:

```bash
mkdir -p ~/projects
cd ~/projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Recommended jika menggunakan:

```bash
php spark serve
```

---

### Opsi 2 — Apache Document Root

Gunakan:

```text
/var/www/
```

Contoh:

```text
/var/www/tri-jaya-motor
```

Clone:

```bash
cd /var/www
sudo git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Set permission:

```bash
sudo chown -R $USER:www-data /var/www/tri-jaya-motor
sudo chmod -R 775 /var/www/tri-jaya-motor
```

---

## macOS

Gunakan:

```text
~/Projects/
```

Contoh:

```text
/Users/USERNAME/Projects/tri-jaya-motor
```

Clone:

```bash
mkdir -p ~/Projects
cd ~/Projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika menggunakan Apache bawaan macOS:

```text
/Library/WebServer/Documents/
```

Namun development dengan:

```bash
php spark serve
```

lebih direkomendasikan.

---

# Install Dependency

Install dependency:

```bash
composer install
```

---

# Setup Environment (.env)

File `.env` tidak disertakan dalam repository demi keamanan.

CodeIgniter 4 membutuhkan file `.env`.

---

## Jika file env tersedia

Linux/macOS:

```bash
cp env .env
```

Windows CMD:

```cmd
copy env .env
```

PowerShell:

```powershell
Copy-Item env .env
```

---

## Jika file env tidak tersedia

Beberapa setup CodeIgniter 4 tidak menyediakan file `env` di root project.

Gunakan template bawaan framework.

Linux/macOS:

```bash
cp vendor/codeigniter4/framework/env .env
```

Windows CMD:

```cmd
copy vendor\codeigniter4\framework\env .env
```

PowerShell:

```powershell
Copy-Item vendor\codeigniter4\framework\env .env
```

---

# Konfigurasi .env

Edit `.env`:

```env
CI_ENVIRONMENT = development

app.indexPage = ''
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = tri_jaya_motor_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Jika menggunakan Laragon:

```env
app.baseURL = 'http://tri-jaya-motor.test/'
```

Jika menggunakan Apache Linux:

```env
app.baseURL = 'http://trijaya.test/'
```

---

# Setup Database

Buat database:

```sql
CREATE DATABASE tri_jaya_motor_db;
```

atau via CLI:

```bash
mysql -u root -p
```

lalu:

```sql
CREATE DATABASE tri_jaya_motor_db;
```

---

# Migration & Seeder

Jalankan migration:

```bash
php spark migrate
```

Jalankan seeder:

```bash
php spark db:seed CounterKodeSeeder
```

---

# Opsi Manual (Import SQL)

Jika menggunakan backup SQL:

```bash
mysql -u root -p tri_jaya_motor_db < tri_jaya_motor_refinement_new_view.sql
```

---

# Menjalankan Aplikasi

## Opsi 1 — CodeIgniter Development Server (Recommended)

Jalankan:

```bash
php spark serve
```

Akses:

```text
http://localhost:8080
```

---

## Opsi 2 — Apache Virtual Host (Linux)

Start service.

Ubuntu / Debian:

```bash
sudo systemctl start apache2 && sudo systemctl start mysql
```

Jika MariaDB:

```bash
sudo systemctl start apache2 && sudo systemctl start mariadb
```

Fedora / CentOS / RHEL:

```bash
sudo systemctl start httpd && sudo systemctl start mariadb
```

Enable rewrite:

Ubuntu / Debian:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Buat virtual host:

```apache
<VirtualHost *:80>
    ServerName trijaya.test
    DocumentRoot /home/USERNAME/projects/tri-jaya-motor/public

    <Directory /home/USERNAME/projects/tri-jaya-motor/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
```

Tambahkan host:

```bash
sudo nano /etc/hosts
```

Isi:

```text
127.0.0.1 trijaya.test
```

Reload:

Ubuntu / Debian:

```bash
sudo systemctl reload apache2
```

Fedora / CentOS:

```bash
sudo systemctl reload httpd
```

Akses:

```text
http://trijaya.test
```

---

## Opsi 3 — XAMPP

Pastikan:

- Apache aktif
- MySQL aktif

Akses:

```text
http://localhost/tri-jaya-motor/public
```

atau:

```bash
php spark serve
```

---

## Opsi 4 — Laragon

Pastikan:

- Apache aktif
- MySQL aktif
- Auto Virtual Hosts aktif

Akses:

```text
http://tri-jaya-motor.test
```

atau:

```bash
php spark serve
```

---

## Opsi 5 — macOS

Jalankan Apache:

```bash
sudo apachectl start
```

Jalankan MySQL:

```bash
brew services start mysql
```

atau MariaDB:

```bash
brew services start mariadb
```

Jalankan:

```bash
php spark serve
```

---

# Struktur Project

```text
app/
├── Config/
├── Controllers/
├── Database/
│   ├── Migrations/
│   └── Seeds/
├── Models/
└── Views/

public/
└── assets/

vendor/
writable/
.env
composer.json
spark
```

---

# Troubleshooting

## Composer Error

Jika dependency belum terinstall:

```bash
composer install
```

---

## Database Connection Error

Periksa `.env`:

```env
database.default.database = tri_jaya_motor_db
database.default.username = root
database.default.password =
```

Pastikan database service berjalan.

---

## Migration Gagal

Pastikan:

- database sudah dibuat
- PHP CLI tersedia
- konfigurasi `.env` benar
- MySQL / MariaDB aktif

---

## Cache Permission Error

Jika muncul:

```text
Cache unable to write to writable/cache
```

Linux/macOS:

```bash
chmod -R 775 writable
```

atau:

```bash
sudo chown -R $USER:www-data writable
chmod -R 775 writable
```

---

## Base URL Invalid Error

Jika muncul:

```text
Config\App::$baseURL is not a valid URL
```

Benar:

```env
app.baseURL = 'http://localhost:8080/'
```

Salah:

```env
app.baseURL = 'http//localhost:8080/'
```

Tanda `:` setelah `http` wajib ada.

---

## Cache Bermasalah

Clear cache:

```bash
php spark cache:clear
```

atau:

```bash
rm -rf writable/cache/*
```

---

## Virtual Host Tidak Bisa Diakses

Periksa:

- `/etc/hosts`
- Apache virtual host
- `app.baseURL`
- service Apache aktif

---

# Catatan

Project ini dikembangkan menggunakan pendekatan **SDLC Waterfall** dengan fokus pada digitalisasi proses bisnis operasional bengkel berdasarkan analisis kebutuhan nyata di lapangan.
