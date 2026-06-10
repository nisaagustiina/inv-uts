# Aplikasi Inventory Management System

Aplikasi web sederhana untuk mengelola data barang, kategori, dan pengguna dengan sistem login dan role based access (Admin & User). Dibangun menggunakan PHP Native dan Bootstrap 5 untuk tampilan responsif.

## Fitur Utama

- **Autentikasi** (Login, Register, Logout) dengan password hashing
- **Manajemen Barang (Goods)**: Tambah, lihat, edit, hapus (khusus Admin)
- **Manajemen Kategori (Categories)**: Tambah, lihat, edit, hapus (khusus Admin)
- **Manajemen Pengguna (Users)**: CRUD pengguna, atur role (Admin/User) – hanya untuk Admin
- **Laporan (Report)**: Tampilkan statistik total barang, total nilai inventaris, jumlah per kategori, dan daftar detail barang
- **Sidebar Menu** navigasi yang jelas tanpa navbar dropdown
- **Role-based Access**:
    - **Admin**: Semua akses (CRUD barang, kategori, pengguna, laporan)
    - **User**: Hanya baca (view) barang, kategori, dan laporan

## Teknologi yang Digunakan

- **Backend**: PHP 7.4+ (PDO MySQL)
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5, CSS native, Bootstrap Icons
- **Keamanan**: Prepared statements (PDO) untuk mencegah SQL injection, password_hash() untuk enkripsi password

## Persyaratan Sistem

- Web server (Apache / XAMPP / WAMP / Laragon)
- PHP 7.4 atau lebih tinggi (dengan ekstensi PDO MySQL)
- MySQL 5.7 atau lebih tinggi
- Browser modern (Chrome, Firefox, Edge)

## Instalasi

### 1. Clone atau Download Project

Tempatkan semua file dalam folder web server, misalnya `C:\xampp\htdocs\inventory` atau `/var/www/html/inventory`.

### 2. Import Database

**import** file SQL yang bernama inventory_db ke phpmyadmin atau dbm yang lainnya
Cara import:

- Buka phpMyAdmin, buat database baru `inventory_db`, lalu klik tab **Import** dan pilih file SQL (atau copy-paste query di atas).
- Atau via command line: `mysql -u root -p inventory_db < database.sql`

### 3. Konfigurasi Database

Edit file `config/db.php` dan sesuaikan kredensial database:

```php
$host = 'localhost';
$dbname = 'inventory_db';
$username = 'root';      // sesuaikan
$password = '';          // sesuaikan
```

### 4. Jalankan Aplikasi

Akses melalui browser:  
`http://localhost/inventory/` (atau sesuai folder)

## Cara Penggunaan

### Login

- **Admin default**:  
  Username: `admin`  
  Password: `admin123`
- **User biasa**: Daftar melalui halaman register (di nonaktifkan sementara), atau buat user dari panel admin.

### Navigasi Sidebar

- **Dashboard**: Ringkasan dan akses cepat ke modul.
- **Goods**: Kelola barang (Admin: tambah/edit/hapus; User: lihat saja).
- **Categories**: Kelola kategori (Admin: tambah/edit/hapus; User: lihat saja).
- **Report**: Lihat statistik dan laporan inventaris.
- **Users**: (Hanya Admin) Kelola akun pengguna.

### Fitur Khusus Admin

- Menambah/mengubah/menghapus barang dan kategori.
- Menambah/mengubah/menghapus user, termasuk mengubah role (Admin/User).
- Tidak bisa menghapus kategori yang masih memiliki barang.
- Tidak bisa menghapus akun sendiri.

## Struktur File

```
inventory/
├── config/
│   └── db.php               # Koneksi database & session start
├── includes/
│   ├── header.php           # Sidebar + layout awal
│   └── footer.php           # Penutup layout & script
├── assets/                  # (Opsional) CSS/JS tambahan + template bootstrap
├── index.php                # Redirect ke login/dashboard
├── login.php                # Form login
├── register.php             # Form registrasi user baru
├── logout.php               # Proses logout
├── dashboard.php            # Halaman utama setelah login
├── goods.php                # Daftar barang
├── add_good.php             # Tambah barang (admin)
├── edit_good.php            # Edit barang (admin)
├── delete_good.php          # Hapus barang (admin)
├── categories.php           # Daftar kategori
├── add_category.php         # Tambah kategori (admin)
├── edit_category.php        # Edit kategori (admin)
├── delete_category.php      # Hapus kategori (admin)
├── report.php               # Laporan inventaris
├── users.php                # Daftar user (admin)
├── add_user.php             # Tambah user (admin)
├── edit_user.php            # Edit user (admin)
├── delete_user.php          # Hapus user (admin)
└── README.md
```

## Keamanan

- **PDO Prepared Statements**: Semua query menggunakan parameter binding untuk mencegah SQL injection.
- **Password Hashing**: Menggunakan `password_hash()` dengan algoritma default BCRYPT.
- **Session Management**: Session dimulai dengan aman, logout menghapus session.
- **Role Checking**: Setiap halaman protected memeriksa role user sebelum menampilkan aksi sensitif.

## Troubleshooting

- **Koneksi gagal**: Periksa kembali kredensial database di `config/db.php` dan pastikan MySQL berjalan.
- **Error 404**: Pastikan file `.php` ada dan URL sesuai.
- **Session tidak tersimpan**: Cek pengaturan `session.save_path` di php.ini.
- **Halaman tidak bisa diakses setelah login**: Pastikan `session_start()` dipanggil di `config/db.php` dan di-require di semua halaman.

## Pengembangan Lebih Lanjut

Beberapa ide untuk menambah fitur:

- Upload gambar barang
- Pencarian dan filter data
- Ekspor laporan ke PDF/Excel
- Log aktivitas user

## Lisensi

Proyek ini dibuat untuk keperluan belajar dan dapat digunakan secara bebas.

## Kontribusi

Silakan fork dan pull request untuk perbaikan atau penambahan fitur.
