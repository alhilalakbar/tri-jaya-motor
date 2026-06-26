# Sistem Informasi Manajemen Bengkel — Tri Jaya Motor

Aplikasi web berbasis **CodeIgniter 4** untuk membantu pengelolaan operasional bengkel, mencakup manajemen data master, transaksi servis kendaraan, inventaris sparepart, sistem kasir, hingga pelaporan operasional.

Proyek ini dikembangkan sebagai implementasi digitalisasi proses bisnis bengkel berdasarkan observasi, wawancara, dan analisis kebutuhan operasional nyata di lapangan.

---

## 📚 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Prasyarat](#-prasyarat)
- [Required PHP Extensions](#required-php-extensions)
- [Install Git](#-install-git)
- [Konfigurasi Git](#-konfigurasi-git-recommended)
- [Clone Repository](#-clone-repository)
- [Penempatan Project Directory](#-penempatan-project-directory)
- [Install Dependency](#-install-dependency)
- [Setup Environment (.env)](#setup-environment-env)
- [Setup Database](#setup-database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Project](#-struktur-project)
- [Troubleshooting](#-troubleshooting)
- [Catatan](#-catatan)
- [Lisensi](#-lisensi)

---

## 🌟 Fitur Utama

Aplikasi ini menyediakan fitur-fitur berikut:

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
- Pengelolaan upah harian mekanik / pembayaran harian mekanik
- Laporan operasional
- Export PDF / Excel
- Migration & Seeder support

---

## 🛠️ Teknologi yang Digunakan

Stack teknologi yang digunakan dalam proyek ini:

- PHP >= 8.1
- CodeIgniter 4
- MySQL / MariaDB
- Composer
- Bootstrap
- AdminLTE 3
- JavaScript
- jQuery

---

## 📋 Prasyarat

Sebelum menjalankan proyek ini, pastikan environment development Anda sudah memiliki:

- Git
- Composer
- PHP >= 8.1
- MySQL / MariaDB
- Apache (opsional)
- Laragon / XAMPP (Windows)

---

## Required PHP Extensions

Pastikan extension PHP berikut sudah aktif:

- `intl`
- `mbstring`
- `mysqli`
- `json`
- `openssl`
- `xml`
- `curl`
- `fileinfo`

### Cek Versi PHP

```bash
php -v
```

### Cek Versi Composer

```bash
composer --version
```

---

## 🚀 Install Git

Jika Git belum terinstall, install terlebih dahulu sesuai sistem operasi Anda.

### Cek Apakah Git Sudah Terinstall

```bash
git --version
```

Jika command di atas tidak dikenali, lanjutkan instalasi sesuai OS Anda.

---

### Windows

Download installer Git:

```text
https://git-scm.com/download/win
```

Jalankan installer.

Recommended setup:

- Use Git from the Windows Command Prompt
- Checkout Windows-style, commit Unix-style line endings
- Use OpenSSL library
- Use bundled OpenSSH

Verifikasi:

```cmd
git --version
```

---

### Linux

#### Ubuntu / Debian

```bash
sudo apt update
sudo apt install git -y
```

#### Fedora

```bash
sudo dnf install git -y
```

#### CentOS / RHEL

```bash
sudo yum install git -y
```

atau:

```bash
sudo dnf install git -y
```

#### Arch Linux

```bash
sudo pacman -S git
```

Verifikasi:

```bash
git --version
```

---

### macOS

#### Opsi 1 — Homebrew

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

---

#### Opsi 2 — Xcode Command Line Tools

```bash
xcode-select --install
```

Verifikasi:

```bash
git --version
```

---

## 🔧 Konfigurasi Git (Recommended)

Gunakan identitas GitHub Anda untuk konfigurasi global Git.

Contoh:

```bash
git config --global user.name "alhilalakbar"
git config --global user.email "alhilalakbar@gmail.com"
git config --list
```

---

## 📥 Clone Repository

Repository dapat di-clone menggunakan salah satu metode berikut.

### HTTPS

```bash
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
cd tri-jaya-motor
```

### SSH

```bash
git clone git@github.com:alhilalakbar/tri-jaya-motor.git
cd tri-jaya-motor
```
---

## 📂 Penempatan Project Directory

Lokasi penyimpanan project tergantung environment development yang Anda gunakan.

---

### Windows — XAMPP

Jika menggunakan XAMPP, simpan project di:

```text
C:\xampp\htdocs\
```

Contoh:

```text
C:\xampp\htdocs\tri-jaya-motor
```

Clone repository:

```bash
cd C:\xampp\htdocs
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika menggunakan Apache bawaan XAMPP, akses aplikasi melalui:

```text
http://localhost/tri-jaya-motor/public
```

Jika menggunakan:

```bash
php spark serve
```

lokasi project bebas.

Jika command `php` tidak dikenali:

```cmd
C:\xampp\php\php.exe spark serve
```

Akses MySQL CLI:

```cmd
C:\xampp\mysql\bin\mysql -u root -p
```

---

### Windows — Laragon

Jika menggunakan Laragon, simpan project di:

```text
C:\laragon\www\
```

Contoh:

```text
C:\laragon\www\tri-jaya-motor
```

Clone repository:

```bash
cd C:\laragon\www
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Pastikan fitur **Auto Virtual Hosts** aktif.

Biasanya URL otomatis:

```text
http://tri-jaya-motor.test
```

Update `.env`:

```env
app.baseURL = 'http://tri-jaya-motor.test/'
```

Jika menggunakan:

```bash
php spark serve
```

lokasi project bebas.

Akses MySQL CLI:

```bash
mysql -u root -p
```

---

### Linux

Linux lebih fleksibel untuk penempatan project.

---

#### Opsi 1 — Development Directory (Recommended)

Direktori yang direkomendasikan:

```text
/home/hillal/projects/
```

Contoh:

```text
/home/hillal/projects/tri-jaya-motor
```

> [!NOTE]
> Jika username Linux Anda bukan `hillal`, ganti `hillal` sesuai username Anda.

Clone repository:

```bash
mkdir -p ~/projects
cd ~/projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika menggunakan development server:

```bash
php spark serve
```

opsi ini sangat direkomendasikan.

---

#### Opsi 2 — Apache Document Root

Gunakan jika ingin menjalankan aplikasi langsung melalui Apache.

Direktori:

```text
/var/www/
```

Contoh:

```text
/var/www/tri-jaya-motor
```

Clone repository:

```bash
cd /var/www
sudo git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Set permission:

```bash
sudo chown -R hillal:www-data /var/www/tri-jaya-motor
sudo chmod -R 775 /var/www/tri-jaya-motor
```

> [!NOTE]
> Ganti `hillal` sesuai username Linux Anda.

---

### macOS

Direktori development yang umum digunakan:

```text
~/Projects/
```

Contoh:

```text
/Users/hillal/Projects/tri-jaya-motor
```

> [!NOTE]
> Jika username macOS Anda bukan `hillal`, sesuaikan path di atas.

Clone repository:

```bash
mkdir -p ~/Projects
cd ~/Projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika menggunakan Apache bawaan macOS:

```text
/Library/WebServer/Documents/
```

Namun development menggunakan:

```bash
php spark serve
```

lebih direkomendasikan.

---

## 📦 Install Dependency

Install seluruh dependency project menggunakan Composer:

```bash
composer install
```

---

## Setup Environment (.env)

File `.env` tidak disertakan dalam repository demi alasan keamanan.

CodeIgniter 4 membutuhkan file `.env`.

---

### Jika File `env` Tersedia

#### Linux/macOS

```bash
cp env .env
```

#### Windows CMD

```cmd
copy env .env
```

#### Windows PowerShell

```powershell
Copy-Item env .env
```

---

### Jika File `env` Tidak Tersedia

Beberapa setup CodeIgniter 4 tidak menyertakan file `env` di root project.

Gunakan template bawaan framework.

#### Linux/macOS

```bash
cp vendor/codeigniter4/framework/env .env
```

#### Windows CMD

```cmd
copy vendor\codeigniter4\framework\env .env
```

#### Windows PowerShell

```powershell
Copy-Item vendor\codeigniter4\framework\env .env
```

---

## Konfigurasi `.env`

Edit file `.env`, lalu isi:

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

Penjelasan:

- `tri_jaya_motor_db` adalah nama database MySQL yang akan Anda gunakan
- Jika ingin menggunakan nama lain, pastikan nama tersebut sama dengan database yang dibuat

Jika menggunakan Laragon:

```env
app.baseURL = 'http://tri-jaya-motor.test/'
```

Jika menggunakan Apache Linux:

```env
app.baseURL = 'http://trijaya.test/'
```

---

## Setup Database

### Membuat Database

Pilih salah satu metode berikut untuk membuat database.

---

#### Opsi 1 — Menggunakan phpMyAdmin (Recommended)

1. Jalankan **Apache** dan **MySQL** melalui XAMPP atau Laragon.
2. Buka browser, lalu akses:

```text
http://localhost/phpmyadmin
```

3. Klik **New** pada panel sebelah kiri.
4. Masukkan nama database:

```text
tri_jaya_motor_db
```

5. Biarkan **Collation** menggunakan nilai default.
6. Klik **Create**.

Pastikan nama database sama dengan yang dikonfigurasi pada file `.env`.

---

#### Opsi 2 — Menggunakan MySQL Command Line

##### Windows (XAMPP)

Buka **Command Prompt**, lalu masuk ke direktori MySQL XAMPP:

```cmd
cd C:\xampp\mysql\bin
```

Jalankan MySQL:

```cmd
mysql.exe -u root -p
```

Apabila password pengguna `root` kosong, cukup tekan **Enter** saat diminta memasukkan password.

##### Windows (Laragon)

Buka **Command Prompt** atau **Terminal Laragon**, kemudian jalankan:

```cmd
mysql -u root -p
```

Apabila password pengguna `root` kosong, cukup tekan **Enter** saat diminta memasukkan password.

##### Linux

Buka Terminal, kemudian jalankan:

```bash
mysql -u root -p
```

##### macOS

Buka Terminal, kemudian jalankan:

```bash
mysql -u root -p
```

Setelah berhasil masuk ke MySQL, buat database dengan perintah berikut:

```sql
CREATE DATABASE tri_jaya_motor_db;
EXIT;
```

Apabila nama database pada file `.env` berbeda, sesuaikan nama database yang dibuat.

---

### Menjalankan Migration

Buat seluruh struktur tabel:

```bash
php spark migrate
```

---

### Menjalankan Seeder

Inisialisasi data awal aplikasi:

```bash
php spark db:seed DatabaseSeeder
```

---

## 🔑 Default Login

| Role | Username | Password |
|------|----------|----------|
| Pemilik | owner | owner123 |
| Admin | admin | admin123 |
| Mekanik | mekanik | mekanik123 |

> [!NOTE]
> Password pada database disimpan menggunakan algoritma **bcrypt** (`password_hash()`).

Apabila ingin membuat hash password baru, jalankan:

```bash
php -r "echo password_hash('password_baru', PASSWORD_DEFAULT) . PHP_EOL;"
```

---

## Menjalankan Aplikasi

Berikut beberapa opsi untuk menjalankan aplikasi sesuai environment development Anda.

---

### Opsi 1 — CodeIgniter Development Server (Recommended)

Metode ini adalah opsi termudah untuk development lokal.

Jalankan:

```bash
php spark serve
```

Jika berhasil, output biasanya:

```text
CodeIgniter development server started on http://localhost:8080
```

Akses aplikasi:

```text
http://localhost:8080
```

---

### Opsi 2 — Apache Virtual Host (Linux)

Gunakan metode ini jika ingin menjalankan project melalui Apache.

---

#### Start Service

##### Ubuntu / Debian

Jika menggunakan MySQL:

```bash
sudo systemctl start apache2
sudo systemctl start mysql
```

Jika menggunakan MariaDB:

```bash
sudo systemctl start apache2
sudo systemctl start mariadb
```

##### Fedora / CentOS / RHEL

```bash
sudo systemctl start httpd
sudo systemctl start mariadb
```

---

#### Enable mod_rewrite

CodeIgniter membutuhkan Apache rewrite module.

Ubuntu / Debian:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

#### Buat Virtual Host

Buat file konfigurasi:

```bash
sudo nano /etc/apache2/sites-available/trijaya.conf
```

Isi:

```apache
<VirtualHost *:80>
    ServerName trijaya.test
    DocumentRoot /home/hillal/projects/tri-jaya-motor/public

    <Directory /home/hillal/projects/tri-jaya-motor/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
```

> [!NOTE]
> Jika username Linux Anda bukan `hillal`, sesuaikan path di atas.

Enable site:

```bash
sudo a2ensite trijaya.conf
```

Reload Apache:

```bash
sudo systemctl reload apache2
```

---

#### Tambahkan Hosts Entry

Edit file:

```bash
sudo nano /etc/hosts
```

Tambahkan:

```text
127.0.0.1 trijaya.test
```

Reload service:

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

### Opsi 3 — XAMPP

Pastikan service berikut aktif:

- Apache
- MySQL

Jika project berada di:

```text
C:\xampp\htdocs\tri-jaya-motor
```

Akses:

```text
http://localhost/tri-jaya-motor/public
```

Atau gunakan:

```bash
php spark serve
```

---

### Opsi 4 — Laragon

Pastikan:

- Apache aktif
- MySQL aktif
- Auto Virtual Hosts aktif

Jika project berada di:

```text
C:\laragon\www\tri-jaya-motor
```

Akses:

```text
http://tri-jaya-motor.test
```

Atau gunakan:

```bash
php spark serve
```

---

### Opsi 5 — macOS

Jalankan Apache:

```bash
sudo apachectl start
```

Jika menggunakan MySQL:

```bash
brew services start mysql
```

Jika menggunakan MariaDB:

```bash
brew services start mariadb
```

Atau gunakan:

```bash
php spark serve
```

---

## 📁 Struktur Project

Struktur direktori utama:

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

## 🔧 Troubleshooting

Jika mengalami kendala saat setup atau menjalankan aplikasi, cek bagian berikut.

---

### Composer Error

Jika dependency belum terinstall:

```bash
composer install
```

---

### Database Connection Error

Periksa konfigurasi `.env`:

```env
database.default.database = tri_jaya_motor_db
database.default.username = root
database.default.password =
```

Pastikan:

- database sudah dibuat
- username MySQL benar
- password MySQL benar
- service MySQL / MariaDB sedang berjalan

---

### Migration Gagal

Pastikan:

- database sudah dibuat
- PHP CLI tersedia
- konfigurasi `.env` benar
- MySQL / MariaDB aktif

Tes PHP CLI:

```bash
php -v
```

---

### Cache Permission Error

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
sudo chown -R hillal:www-data writable
chmod -R 775 writable
```

> [!NOTE]
> Ganti `hillal` sesuai username Linux Anda.

---

### Command PHP Tidak Dikenali (Windows)

Jika muncul:

```text
'php' is not recognized as an internal or external command
```

Gunakan full path:

```cmd
C:\xampp\php\php.exe spark serve
```

Atau tambahkan folder PHP ke Environment Variable `PATH`.

---

### Base URL Invalid Error

Jika muncul:

```text
Config\App::$baseURL is not a valid URL
```

Contoh benar:

```env
app.baseURL = 'http://localhost:8080/'
```

Contoh salah:

```env
app.baseURL = 'http//localhost:8080/'
```

Kesalahan umum:

- lupa tanda `:`
- lupa slash `/`

---

### Cache Bermasalah

Clear cache:

```bash
php spark cache:clear
```

atau manual:

Linux/macOS:

```bash
rm -rf writable/cache/*
```

Windows CMD:

```cmd
del /q writable\cache\*
```

---

### Virtual Host Tidak Bisa Diakses

Periksa:

- `/etc/hosts`
- konfigurasi Apache virtual host
- `app.baseURL`
- Apache aktif
- mod_rewrite aktif
- firewall lokal

---

### Git Authentication Error

Jika repository private dan clone gagal:

```text
Repository not found
```

atau:

```text
Authentication failed
```

Pastikan:

- akun GitHub Anda memiliki akses
- GitHub token valid
- URL repository benar

---

## 📝 Catatan

- Proyek ini dikembangkan menggunakan pendekatan **SDLC Waterfall**
- Fokus pada digitalisasi proses bisnis operasional bengkel berdasarkan analisis kebutuhan nyata di lapangan
- Autentikasi menggunakan tabel `pengguna`

Field autentikasi:

- `nama_pengguna`
- `kata_sandi`
- `peran`

Password:

- wajib menggunakan `password_hash()`
- jangan menyimpan password dalam bentuk plain text

Catatan keamanan:

- file `.env` tidak disertakan dalam repository
- jangan commit `.env` ke GitHub public repository
- jangan membagikan credential database

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan akademik dan implementasi sistem informasi manajemen bengkel.
