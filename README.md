# Sistem Informasi Manajemen Bengkel - Tri Jaya Motor

Aplikasi web berbasis **CodeIgniter 4** untuk membantu pengelolaan operasional bengkel, mencakup manajemen data master, transaksi servis kendaraan, inventaris sparepart, sistem kasir, serta pelaporan operasional.

## Fitur Utama

- Autentikasi admin
- Manajemen data pelanggan
- Manajemen data mekanik
- Manajemen data sparepart
- Transaksi servis kendaraan
- Sistem kasir
- Laporan operasional
- Database migration & seeder support

## Teknologi yang Digunakan

- PHP
- CodeIgniter 4
- MySQL / MariaDB
- Composer
- AdminLTE 3
- Bootstrap
- JavaScript
- jQuery

---

## Instalasi

Install dependency project menggunakan Composer:

```bash
composer install
```

Buat file environment:

```bash
cp env .env
```

Konfigurasikan file `.env` sesuai environment lokal Anda:

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

---

## Setup Database

Buat database terlebih dahulu:

```sql
CREATE DATABASE tri_jaya_motor_db;
```

Jalankan migration:

```bash
php spark migrate
```

Jalankan seeder:

```bash
php spark db:seed CounterKodeSeeder
```

### Opsi Manual (Import SQL)

Jika ingin menggunakan backup database manual:

```bash
mysql -u root -p tri_jaya_motor_db < tri_jaya_motor_refinement_new_view.sql
```

---

## Menjalankan Aplikasi

### Opsi 1 — Development Server (Rekomendasi)

Jalankan development server bawaan CodeIgniter:

```bash
php spark serve
```

Akses aplikasi melalui browser:

```text
http://localhost:8080
```

---

### Opsi 2 — Linux (Apache / Virtual Host)

Pastikan Apache dan MySQL/MariaDB berjalan:

**Ubuntu / Debian:**

```bash
sudo systemctl start apache2
sudo systemctl start mysql
```

**CentOS / Fedora / RHEL:**

```bash
sudo systemctl start httpd
sudo systemctl start mariadb
```

Contoh virtual host Apache:

```apache
<VirtualHost *:80>
    ServerName tri-jaya-motor.local
    DocumentRoot /var/www/tri-jaya-motor/public

    <Directory /var/www/tri-jaya-motor/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Tambahkan host:

```bash
sudo nano /etc/hosts
```

Tambahkan:

```text
127.0.0.1 tri-jaya-motor.local
```

Reload Apache:

```bash
sudo systemctl reload apache2
```

atau:

```bash
sudo systemctl reload httpd
```

Ubah `.env`:

```env
app.baseURL = 'http://tri-jaya-motor.local/'
```

Akses:

```text
http://tri-jaya-motor.local
```

---

### Opsi 3 — macOS (Apache + MySQL)

Jalankan Apache:

```bash
sudo apachectl start
```

Jika menggunakan Homebrew MySQL:

```bash
brew services start mysql
```

Jika menggunakan Homebrew MariaDB:

```bash
brew services start mariadb
```

Jalankan aplikasi menggunakan development server:

```bash
php spark serve
```

Akses:

```text
http://localhost:8080
```

---

### Opsi 4 — Windows (XAMPP / Laragon)

Pastikan:

- Apache berjalan
- MySQL berjalan
- PHP tersedia di PATH (jika memakai terminal)

Jalankan:

```bash
php spark serve
```

Akses:

```text
http://localhost:8080
```

---

## Struktur Project

```text
app/
├── Controllers/
├── Database/
│   ├── Migrations/
│   └── Seeds/
├── Models/
└── Views/

public/
└── assets/

writable/
```

---

## Troubleshooting

### Composer dependency error

Jika dependency belum terinstall:

```bash
composer install
```

---

### Database connection error

Pastikan konfigurasi database pada `.env` sudah benar:

```env
database.default.database = tri_jaya_motor_db
database.default.username = root
database.default.password =
```

---

### Migration gagal

Pastikan:

- Database sudah dibuat
- MySQL / MariaDB berjalan
- Konfigurasi `.env` sesuai
- PHP CLI tersedia

---

### Permission issue (Linux/macOS)

Jika folder writable tidak bisa diakses:

```bash
chmod -R 775 writable
```

---

## Catatan

Project ini menggunakan fitur bawaan **CodeIgniter 4 Migration** dan **Seeder** untuk menjaga konsistensi struktur database antar environment development.
