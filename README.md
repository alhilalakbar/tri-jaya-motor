# Sistem Informasi Manajemen Bengkel - Tri Jaya Motor

Aplikasi web berbasis CodeIgniter 4 untuk membantu pengelolaan operasional bengkel, mencakup manajemen data master, transaksi servis kendaraan, inventaris sparepart, sistem kasir, hingga pelaporan operasional.

Project ini dikembangkan sebagai implementasi digitalisasi proses bisnis bengkel berdasarkan observasi, wawancara, dan analisis kebutuhan operasional nyata di lapangan.

---

## 🌟 Fitur Utama

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

## 🛠️ Teknologi yang Digunakan

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

Pastikan environment development Anda sudah memiliki:

- Git
- Composer
- PHP >= 8.1
- MySQL / MariaDB
- Apache (opsional)
- Laragon / XAMPP (Windows)

### Required PHP Extensions

Pastikan extension berikut aktif:

`intl`, `mbstring`, `mysqli`, `json`, `openssl`, `xml`, `curl`, `fileinfo`

### Cek versi PHP

```bash
php -v
```

### Cek versi Composer

```bash
composer --version
```

---

## 🚀 Instalasi Git

Jika Git belum terinstall, lakukan instalasi sesuai sistem operasi Anda.

Cek instalasi:

```bash
git --version
```

### Windows

1. Download installer:
   https://git-scm.com/download/win

2. Jalankan installer dengan pengaturan yang direkomendasikan:
   - Use Git from the Windows Command Prompt
   - Checkout Windows-style, commit Unix-style line endings
   - Use OpenSSL library
   - Use bundled OpenSSH

### Linux

#### Ubuntu / Debian

```bash
sudo apt update
sudo apt install git -y
```

#### Fedora / CentOS / RHEL

```bash
sudo dnf install git -y

# atau

sudo yum install git -y
```

#### Arch Linux

```bash
sudo pacman -S git
```

### macOS

#### Opsi 1 — Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
brew install git
```

#### Opsi 2 — Xcode Command Line Tools

```bash
xcode-select --install
```

### Konfigurasi Git (Recommended)

```bash
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
git config --list
```

---

## 📥 Clone Repository

> **Catatan:** Repository saat ini masih private. Pastikan akun GitHub Anda memiliki akses.
> Jika menggunakan HTTPS dan diminta autentikasi, gunakan GitHub Personal Access Token.

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

### Windows — XAMPP

Simpan project di:

```text
C:\xampp\htdocs
```

Clone repository:

```bash
cd C:\xampp\htdocs
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

Jika command PHP tidak dikenali:

```bash
C:\xampp\php\php.exe spark serve
```

MySQL CLI:

```bash
C:\xampp\mysql\bin\mysql -u root -p
```

---

### Windows — Laragon

Simpan project di:

```text
C:\laragon\www
```

Clone repository:

```bash
cd C:\laragon\www
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

URL default:

```text
http://tri-jaya-motor.test
```

MySQL CLI:

```bash
mysql -u root -p
```

---

### Linux

```bash
mkdir -p ~/projects
cd ~/projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

---

### macOS

```bash
mkdir -p ~/Projects
cd ~/Projects
git clone https://github.com/alhilalakbar/tri-jaya-motor.git
```

---

## 📦 Install Dependency

```bash
composer install
```

---

## ⚙️ Setup Environment (.env)

CodeIgniter 4 membutuhkan file `.env`.

### Linux/macOS

```bash
cp env .env
```

Jika file `env` tidak tersedia:

```bash
cp vendor/codeigniter4/framework/env .env
```

### Windows (CMD/PowerShell)

```cmd
copy env .env
```

Jika file `env` tidak tersedia:

```cmd
copy vendor\codeigniter4\framework\env .env
```

### Konfigurasi `.env`

```ini
CI_ENVIRONMENT = development

app.indexPage = ''
app.baseURL = 'http://localhost:8080/'

# Laragon:
# app.baseURL = 'http://tri-jaya-motor.test/'

database.default.hostname = localhost
database.default.database = tri_jaya_motor_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

## 🗄️ Setup Database

Pilih salah satu metode berikut:

- **Opsi A:** Migration + Seeder (clean setup)
- **Opsi B:** Import SQL backup (quick setup)

> Jangan jalankan keduanya pada database yang sama.

### Membuat Database

```sql
CREATE DATABASE tri_jaya_motor_db;
EXIT;
```

### Opsi A — Migration & Seeder

```bash
php spark migrate
php spark db:seed CounterKodeSeeder
```

### Membuat Akun Administrator

Generate password hash:

```bash
php -r "echo password_hash('PasswordAdmin123', PASSWORD_DEFAULT) . PHP_EOL;"
```

Masuk ke MySQL:

```sql
USE tri_jaya_motor_db;

INSERT INTO pengguna (nama_pengguna, kata_sandi, peran)
VALUES (
    'Administrator',
    'PASTE_HASH_DI_SINI',
    'Admin'
);
```

Login:

- Username: `Administrator`
- Password: `PasswordAdmin123`

---

### Opsi B — Import SQL Backup

```bash
mysql -u root -p tri_jaya_motor_db < tri_jaya_motor_refinement_new_view.sql
```

---

## 🖥️ Menjalankan Aplikasi

### Opsi 1 — CodeIgniter Development Server (Recommended)

```bash
php spark serve
```

Akses:

```text
http://localhost:8080
```

### Opsi 2 — XAMPP / Laragon

XAMPP:

```text
http://localhost/tri-jaya-motor/public
```

Laragon:

```text
http://tri-jaya-motor.test
```

### Opsi 3 — Apache Virtual Host (Linux)

Buat virtual host:

```text
trijaya.test
```

Arahkan `DocumentRoot` ke folder:

```text
public/
```

Tambahkan ke `/etc/hosts`:

```text
127.0.0.1 trijaya.test
```

---

## 📁 Struktur Project

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

### Composer Error

```bash
composer install
```

### Database Connection Error

Periksa file `.env` dan pastikan:

- Nama database benar
- Username/password sesuai
- MySQL sedang berjalan

### Command PHP Tidak Dikenali (Windows)

```cmd
C:\xampp\php\php.exe spark serve
```

Atau tambahkan PHP ke environment variable `PATH`.

### Cache Permission Error

```bash
chmod -R 775 writable
```

atau:

```bash
sudo chown -R $USER:www-data writable
chmod -R 775 writable
```

### Base URL Invalid Error

Benar:

```text
http://localhost:8080/
```

Salah:

```text
http//localhost:8080/
```

---

## 📝 Catatan Tambahan

- **Metodologi:** SDLC Waterfall
- **Autentikasi:** tabel `pengguna` (`nama_pengguna`, `kata_sandi`, `peran`)
- **Keamanan:** file `.env` tidak disertakan di repository
- Password wajib menggunakan `password_hash()`

---

## 📄 Lisensi

Project ini dikembangkan untuk kebutuhan akademik dan implementasi sistem informasi manajemen bengkel.
