# UMKM Sepatu - Sistem Manajemen UMKM dan Toko Sepatu

Sistem manajemen berbasis web untuk pendataan dan promosi UMKM beserta toko sepatu, dibangun dengan Laravel 12.

## 🎯 Fitur Utama

### Manajemen Data UMKM
- CRUD lengkap data UMKM (nama, alamat, kontak, deskripsi, logo)
- Upload logo UMKM dengan validasi

### Manajemen Data Produk
- CRUD produk sepatu dengan relasi ke UMKM
- Multi-image upload (hingga 5 foto per produk)
- Validasi tipe file (JPG, PNG, WEBP) dan ukuran (max 2MB)

### Kategori Produk
- Pengelolaan kategori produk
- Relasi many-to-many antara produk dan kategori

### Pencarian Produk
- Pencarian berdasarkan nama produk
- Filter berdasarkan kategori
- Filter berdasarkan UMKM
- Filter berdasarkan rentang harga

### Dashboard Admin
- Statistik jumlah UMKM, produk, dan kategori
- Chart pendaftaran UMKM per bulan
- Chart distribusi produk per kategori
- Daftar UMKM dan produk terbaru

### Autentikasi & Otorisasi
- Login untuk Admin (akses penuh ke semua fitur)
- Login untuk Pemilik UMKM (hanya dapat mengelola data milik sendiri)
- Role-based access control

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd toko-sepatu
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies JavaScript
```bash
npm install
```

### 4. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umkm_sepatu
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Migrasi Database
```bash
php artisan migrate
```

### 7. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 8. Buat Storage Link
```bash
php artisan storage:link
```

### 9. Build Assets
```bash
npm run build
```
atau untuk development:
```bash
npm run dev
```

### 10. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 Akun Demo

Setelah menjalankan seeder, tersedia akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| UMKM Owner | budi@example.com | password |
| UMKM Owner | siti@example.com | password |

## 📁 Struktur Database

```
users
├── id
├── name
├── email
├── password
├── role (admin/umkm_owner)
└── timestamps

umkms
├── id
├── user_id (FK)
├── nama
├── alamat
├── kontak
├── deskripsi
├── logo
└── timestamps

categories
├── id
├── nama
├── deskripsi
└── timestamps

products
├── id
├── umkm_id (FK)
├── nama
├── deskripsi
├── harga
├── stok
├── ukuran
├── warna
└── timestamps

product_images
├── id
├── product_id (FK)
├── image_path
├── is_primary
└── timestamps

category_product (pivot)
├── id
├── category_id (FK)
├── product_id (FK)
└── timestamps
```

## 🛠️ Teknologi

- **Backend**: Laravel 12
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel UI
- **Charts**: Chart.js
- **Build Tool**: Vite

## 📝 Penggunaan

### Sebagai Admin
1. Login dengan akun admin
2. Akses Dashboard untuk melihat statistik
3. Kelola semua UMKM, produk, dan kategori
4. Tambah/edit/hapus kategori produk

### Sebagai Pemilik UMKM
1. Register atau login dengan akun UMKM owner
2. Buat profil UMKM (jika belum ada)
3. Tambah produk ke UMKM Anda
4. Upload foto produk (multi-image)
5. Kelola produk Anda sendiri

### Pencarian Produk (Public)
1. Akses halaman pencarian dari navbar
2. Masukkan kata kunci atau gunakan filter
3. Lihat detail produk yang ditemukan

## 📄 Lisensi

MIT License

## 👨‍💻 Kontributor

Dibuat sebagai tugas kuliah Semester 5.
