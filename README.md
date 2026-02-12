# Technical Test Backend - Login, Register & Reset Password

Proyek ini adalah aplikasi mobile berbasis Flutter yang terintegrasi dengan REST API menggunakan CodeIgniter 4.

## Fitur Utama
- **Registrasi**: Input nama, email, dan password (dengan enkripsi BCRYPT).
- **Login**: Autentikasi user dengan pengecekan database.
- **Lupa Password**: Sistem generate token unik untuk melakukan reset password.

## Tech Stack
- **Frontend**: Flutter (Mobile)
- **Backend**: CodeIgniter 4 (PHP)
- **Database**: MySQL
- **Testing Device**: Infinix X6885 (Android 15)

## Persiapan Instalasi

### Backend (CodeIgniter 4)
1. Clone folder `backend_api`.
2. Pastikan server lokal (Laragon/XAMPP) sudah berjalan.
3. Import file `db_coralis.sql` ke MySQL kamu.
4. Jalankan perintah: `php spark serve --host 0.0.0.0` (agar bisa diakses oleh perangkat mobile).

### Frontend (Flutter)
1. Clone folder `mobile_app`.
2. Jalankan `flutter pub get`.
3. **PENTING**: Buka `lib/main.dart` dan ganti `baseUrl` dengan IP Laptop kamu (cek via `ipconfig`).
   Contoh: `const String baseUrl = "http://192.168.1.15:8080/api";`
4. Jalankan aplikasi menggunakan perintah `flutter run`.

## Catatan Pengujian
Karena sistem belum terintegrasi dengan SMTP Mailer asli, Token Reset Password akan muncul di **AlertDialog** pada aplikasi mobile setelah input email di menu Lupa Password untuk keperluan pengujian.
