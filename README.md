# Web Task

Web Task adalah sebuah aplikasi berbasis web yang digunakan untuk mengelola daftar tugas (To-Do List) dengan fitur CRUD (Create, Read, Update, Delete).

## 🚀 Fitur
- Menambahkan tugas baru
- Mengedit tugas yang sudah ada
- Menandai tugas sebagai selesai
- Menghapus tugas
- Tampilan responsif

## 🛠️ Teknologi yang Digunakan
- **Laravel** - Framework PHP untuk backend
- **MySQL** - Database untuk menyimpan data tugas
- **Bootstrap** - Framework CSS untuk tampilan
- **JavaScript (AJAX)** - Untuk meningkatkan interaktivitas

## 📌 Instalasi
1. Clone repository ini:
   ```sh
   git clone https://github.com/username/web-task.git
   cd web-task
   ```
2. Install dependensi menggunakan Composer:
   ```sh
   composer install
   ```
3. Buat file `.env` dan atur konfigurasi database:
   ```sh
   cp .env.example .env
   ```
4. Generate key aplikasi:
   ```sh
   php artisan key:generate
   ```
5. Migrasi database:
   ```sh
   php artisan migrate
   ```
6. Jalankan server Laravel:
   ```sh
   php artisan serve
   ```

## 📸 Screenshot
![Tampilan Aplikasi](https://raw.githubusercontent.com/username/web-task/main/screenshots/screenshot1.png)
![Tampilan Dashboard](https://raw.githubusercontent.com/username/web-task/main/screenshots/screenshot2.png)

## 🤝 Kontribusi
Jika ingin berkontribusi, silakan fork repository ini dan ajukan pull request.

## 📜 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---
Made with ❤️ by Muhammad Hafiz
