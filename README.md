# TeknoPedia

**TeknoPedia** adalah website **CMS (Content Management System) Ensiklopedia Teknologi** yang digunakan untuk mengelola dan menyajikan informasi seputar teknologi dalam bentuk artikel yang terstruktur.

Project ini dikembangkan menggunakan **Laravel 13** sebagai framework utama dengan sistem pengelolaan konten yang memungkinkan administrator untuk menambah, mengubah, menghapus, dan mengelola informasi ensiklopedia.

## 📌 Tentang Project

TeknoPedia dibuat sebagai project pembelajaran dan pengembangan aplikasi web berbasis Laravel. Website ini berfokus pada penyajian informasi teknologi yang mudah dicari dan dikelola melalui sebuah sistem CMS.

### Tujuan

* Membuat website ensiklopedia berbasis web.
* Menerapkan konsep CMS menggunakan Laravel.
* Memahami penerapan CRUD pada aplikasi web.
* Mengelola data artikel dan kategori secara terstruktur.
* Menerapkan database pada aplikasi Laravel.
* Membuat antarmuka yang sederhana dan mudah digunakan.

## ✨ Fitur

### Pengunjung

* Melihat daftar artikel teknologi.
* Melihat detail artikel.
* Melihat artikel berdasarkan kategori.
* Mencari artikel.

### Administrator

* Login administrator.
* Dashboard admin.
* Mengelola artikel.
* Menambah artikel.
* Mengedit artikel.
* Menghapus artikel.
* Mengelola kategori.
* Mengelola data ensiklopedia.

> Fitur dapat bertambah atau berubah selama proses pengembangan project.

## 🛠️ Teknologi yang Digunakan

| Teknologi    | Keterangan                    |
| ------------ | ----------------------------- |
| Laravel 13   | Framework utama               |
| PHP 8.3+     | Bahasa pemrograman            |
| MySQL        | Database                      |
| Blade        | Template engine               |
| Tailwind CSS | Styling antarmuka             |
| Laragon      | Local development environment |
| Git & GitHub | Version control               |

## 📂 Struktur Project

Struktur utama project Laravel:

```text
ensiklopedia/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
└── README.md
```

## ⚙️ Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/ensiklopedia.git
```

### 2. Masuk ke Folder Project

```bash
cd ensiklopedia
```

### 3. Install Dependency

```bash
composer install
```

### 4. Buat File Environment

Windows:

```bash
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buka file `.env`, kemudian sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ensiklopedia
DB_USERNAME=root
DB_PASSWORD=
```

Buat database dengan nama:

```text
ensiklopedia
```

Kemudian jalankan migration:

```bash
php artisan migrate
```

### 7. Jalankan Project

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

## 🔐 Environment

File `.env` **tidak disertakan dalam repository** karena berisi konfigurasi lokal dan informasi sensitif.

Gunakan `.env.example` sebagai template konfigurasi.

```text
.env          → tidak di-push ke GitHub
.env.example  → disimpan di GitHub
```

## 🚧 Status Project

Project ini masih dalam tahap **pengembangan**.

Beberapa fitur dan tampilan dapat mengalami perubahan selama proses pengerjaan.

## 👨‍💻 Developer

**Haidar Afif Distyawan**

Project ini dibuat sebagai project pembelajaran dan pengembangan aplikasi web menggunakan Laravel 13.

---

⭐ **TeknoPedia — Ensiklopedia Teknologi Berbasis Web**
