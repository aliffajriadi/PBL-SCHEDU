# Schedu
**PBLIF-2D-01**

Schedu adalah aplikasi reminder jadwal tugas personal dan kolaboratif grup edukatif yang membantu pengguna mengelola tugas-tugas mereka secara efektif baik secara individu maupun dalam tim.

## 🚀 Fitur Utama

- **Manajemen Tugas Personal**: Kelola jadwal dan tugas pribadi dengan mudah
- **Kolaborasi Grup**: Bekerja sama dalam tim untuk menyelesaikan tugas bersama
- **Reminder Otomatis**: Notifikasi pengingat untuk tugas yang akan datang
- **Interface Edukatif**: Dirancang khusus untuk lingkungan pendidikan
- **Dashboard Interaktif**: Visualisasi jadwal dan progress tugas

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8.2 dengan Laravel Framework
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Package Manager**: Composer (PHP), NPM (Node.js)
- **Build Tools**: Vite/Laravel Mix

## 📋 Persyaratan Sistem

Pastikan sistem Anda memiliki:

- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.3
- Composer
- Node.js >= 16.x
- NPM >= 8.x
- Git

## 🔧 Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi Schedu:

### 1. Clone Repository

```bash
git clone https://github.com/aliffajriadi/PBL-SCHEDU.git
cd PBL-SCHEDU
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies Node.js

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schedu_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 7. Seed Database (Opsional)

```bash
php artisan db:seed DatabaseSeeder
```

### 8. Build Assets

```bash
npm run build
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## 🚀 Penggunaan

### Akses Aplikasi

1. Buka browser dan kunjungi `http://127.0.0.1:8000`
2. Masukkan username dan password dengan 
    - Guru 
    email : a@gmail.com
    password : 123
    - Murid
    email : b@gmail.com
    password : 123
    - Staff
    email : sma2@gmail.com
    password : password
    - Admin
    Login di halaman http://127.0.0.1:8000/admin/login
    username : onlydev1
    password : password
3. Mulai membuat jadwal dan tugas personal
4. Bergabung atau buat grup untuk kolaborasi

### Fitur Utama

#### Tugas Personal
- Buat tugas baru dengan deadline
- Set reminder untuk tugas penting
- Tandai tugas sebagai selesai
- Lihat riwayat tugas

#### Kolaborasi Grup
- Buat grup baru atau bergabung dengan grup existing
- Assign tugas ke anggota grup
- Monitor progress tugas grup
- Penugasan dan penilaian

## 📁 Struktur Project

```
PBL-SCHEDU/
├── app/                    # Application logic
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Database migrations and seeders
├── public/                 # Public assets
├── resources/              # Views, CSS, JS
├── routes/                 # Route definitions
├── storage/                # Storage files
├── tests/                  # Test files
├── vendor/                 # Composer dependencies
├── node_modules/           # NPM dependencies
├── .env.example            # Environment example
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
└── README.md              # This file
```

## 🔧 Development

### Menjalankan dalam Mode Development

```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Asset Watcher (jika diperlukan)
npm run dev
```

## 👥 Tim Pengembang

- **Metta Santiputri, S.T., M.Sc, Ph.D.** - *Project Manager* 
*=============================================================================* 
- **Alif Fajriadi** - *Lead Team* - 3312401103 - [@aliffajriadi](https://github.com/aliffajriadi)
- **Bastian Herinko** - *Member Team* - 3312401092 -  (https://github.com/bastian1603)
- **Dwiky Putra Dachi** - *Member Team* - 3312401086 -  (https://github.com/kutu-guling)
- **Rafif Ihsan Syahwaly** - *Member Team* - 3312401095 -  (https://github.com/Seicy)


## 📞 Informasi Kontak

- **Alif Fajriadi** - *Lead Team* - email : aliffajriadi@gmail.com


---

**Schedu** - Kelola jadwal tugas Anda dengan lebih efektif! 📅✨
```

