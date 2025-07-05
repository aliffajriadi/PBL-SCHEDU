# Schedu

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
2. Daftar akun baru atau login dengan akun yang sudah ada
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
- Komunikasi dalam grup

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

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Project ini dilisensikan under MIT License. Lihat file `LICENSE` untuk detail lebih lanjut.

## 👥 Tim Pengembang

- **Alif Fajriadi** - *Lead Developer* - [@aliffajriadi](https://github.com/aliffajriadi)

## 📞 Support

Jika Anda mengalami masalah atau memiliki pertanyaan:

1. Buka issue di GitHub repository
2. Hubungi tim pengembang melalui email
3. Lihat dokumentasi di wiki repository

## 🔄 Changelog

### v1.0.0
- Initial release
- Fitur manajemen tugas personal
- Sistem kolaborasi grup
- Dashboard interaktif
- Sistem reminder

---

**Schedu** - Kelola jadwal tugas Anda dengan lebih efektif! 📅✨
```

