# Spesifikasi Kebutuhan: Use Case Diagram & Deskripsi

Dokumen ini berisi spesifikasi sistem informasi **Wisata Nganjuk** yang secara khusus memuat Use Case Diagram secara utuh beserta Use Case Description untuk **setiap** fiturnya.

---

## 1. Use Case Diagram

Diagram berikut memetakan seluruh interaksi antara aktor (User dan Admin) dengan sistem.

```mermaid
usecaseDiagram
    actor "User (Pengunjung)" as User
    actor Admin

    rectangle "Sistem Informasi Wisata Nganjuk" {
        %% Fitur User
        usecase "Registrasi Akun" as UC1
        usecase "Login User" as UC2
        usecase "Mencari Informasi" as UC3
        usecase "Melihat Daftar & Detail Wisata" as UC4
        usecase "Melihat Daftar & Detail Kuliner" as UC5
        usecase "Melihat Daftar & Detail Event" as UC6
        usecase "Logout User" as UC7
        
        %% Fitur Admin
        usecase "Login Admin" as UC8
        usecase "Melihat Dashboard" as UC9
        usecase "Mengelola Data Wisata" as UC10
        usecase "Mengelola Data Kuliner" as UC11
        usecase "Mengelola Data Event" as UC12
        usecase "Logout Admin" as UC13
    }

    %% Relasi User
    User --> UC1
    User --> UC2
    User --> UC3
    User --> UC4
    User --> UC5
    User --> UC6
    User --> UC7
    
    %% Relasi Admin
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13

    %% Dependencies (Include)
    UC9 ..> UC8 : <<include>>
    UC10 ..> UC8 : <<include>>
    UC11 ..> UC8 : <<include>>
    UC12 ..> UC8 : <<include>>
```

*(Keterangan: Panah `<<include>>` menunjukkan bahwa Admin wajib melakukan Login Admin terlebih dahulu sebelum dapat mengakses Dashboard atau mengelola data-data dalam sistem).*

---

## 2. Use Case Description

Berikut adalah skenario rinci dari **seluruh** Use Case yang terdapat pada diagram di atas.

### **Fitur User (Pengunjung)**

#### UC1: Registrasi Akun
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna baru mendaftar untuk memiliki akun di aplikasi.
*   **Pre-condition:** Pengguna belum memiliki akun dan berada di halaman `register.php`.
*   **Post-condition:** Data akun pengguna baru tersimpan di database.
*   **Skenario Utama:**
    1. Pengguna mengisi nama, email, dan password pada form registrasi.
    2. Pengguna menekan tombol "Daftar".
    3. Sistem memvalidasi kelengkapan dan format data (misal: email belum terdaftar).
    4. Sistem menyimpan data ke database.
    5. Sistem menampilkan notifikasi sukses dan mengarahkan pengguna ke halaman login.

#### UC2: Login User
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Proses otentikasi agar pengguna bisa masuk ke sistem.
*   **Pre-condition:** Pengguna sudah memiliki akun yang terdaftar.
*   **Post-condition:** Pengguna mendapatkan akses session ke dalam sistem.
*   **Skenario Utama:**
    1. Pengguna memasukkan email dan password di halaman `login_user.php`.
    2. Pengguna menekan tombol "Login".
    3. Sistem memvalidasi kesesuaian kredensial dengan data di database.
    4. Sistem membuat session login untuk pengguna.
    5. Sistem mengarahkan pengguna ke halaman utama (`index.php`).

#### UC3: Mencari Informasi
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna mencari wisata, kuliner, atau event berdasarkan kata kunci.
*   **Pre-condition:** Pengguna berada di halaman yang menyediakan kolom pencarian.
*   **Post-condition:** Sistem menampilkan halaman hasil pencarian.
*   **Skenario Utama:**
    1. Pengguna mengetikkan kata kunci pencarian.
    2. Pengguna menekan enter atau tombol cari.
    3. Sistem melakukan query ke tabel wisata, kuliner, dan event di database.
    4. Sistem merender halaman `search.php` yang berisi daftar item yang relevan.

#### UC4: Melihat Daftar & Detail Wisata
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna melihat katalog tempat wisata dan detail informasinya.
*   **Pre-condition:** -
*   **Post-condition:** Pengguna melihat informasi wisata.
*   **Skenario Utama:**
    1. Pengguna membuka halaman `wisata.php`.
    2. Sistem menampilkan daftar wisata.
    3. Pengguna menekan tombol detail pada salah satu wisata.
    4. Sistem mengarahkan ke `detail_wisata.php` dan menampilkan deskripsi, gambar, dan info lengkap wisata tersebut.

#### UC5: Melihat Daftar & Detail Kuliner
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna melihat rekomendasi tempat kuliner dan detailnya.
*   **Pre-condition:** -
*   **Post-condition:** Pengguna melihat informasi kuliner.
*   **Skenario Utama:**
    1. Pengguna membuka halaman `kuliner.php`.
    2. Sistem menampilkan daftar kuliner.
    3. Pengguna menekan salah satu daftar.
    4. Sistem mengarahkan ke `detail_kuliner.php` dan menampilkan menu, alamat, dan deskripsi kuliner.

#### UC6: Melihat Daftar & Detail Event
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna melihat daftar acara (event) wisata yang ada di Nganjuk.
*   **Pre-condition:** -
*   **Post-condition:** Pengguna melihat informasi event.
*   **Skenario Utama:**
    1. Pengguna membuka halaman `event.php` di sisi user.
    2. Sistem menampilkan daftar event.
    3. Pengguna memilih event untuk melihat detailnya.
    4. Sistem membuka `detail_event.php` berisi jadwal, lokasi, dan deskripsi event.

#### UC7: Logout User
*   **Aktor:** User (Pengunjung)
*   **Deskripsi:** Memungkinkan pengguna keluar dari sesi akunnya demi keamanan.
*   **Pre-condition:** Pengguna sedang dalam keadaan login.
*   **Post-condition:** Sesi login pengguna dihapus oleh sistem.
*   **Skenario Utama:**
    1. Pengguna menekan tombol "Logout".
    2. Sistem (`logout.php`) menghapus session pengguna.
    3. Sistem mengarahkan pengguna kembali ke halaman utama atau halaman login.

---

### **Fitur Admin**

#### UC8: Login Admin
*   **Aktor:** Admin
*   **Deskripsi:** Otentikasi khusus untuk administrator masuk ke panel kontrol.
*   **Pre-condition:** Admin berada di halaman `admin/login.php`.
*   **Post-condition:** Admin mendapatkan hak akses penuh ke panel admin.
*   **Skenario Utama:**
    1. Admin memasukkan username dan password khusus admin.
    2. Admin menekan tombol "Login".
    3. Sistem memvalidasi kredensial.
    4. Sistem membuat session admin dan mengarahkan ke halaman `admin/dashboard.php`.

#### UC9: Melihat Dashboard
*   **Aktor:** Admin
*   **Deskripsi:** Menampilkan ringkasan statistik dan menu pintasan utama.
*   **Pre-condition:** Admin sudah login.
*   **Post-condition:** Admin melihat halaman dashboard.
*   **Skenario Utama:**
    1. Admin mengakses halaman dashboard.
    2. Sistem melakukan kalkulasi data dasar (contoh: jumlah total wisata, kuliner, dan event).
    3. Sistem menampilkan data tersebut dalam bentuk ringkasan informasi.

#### UC10: Mengelola Data Wisata
*   **Aktor:** Admin
*   **Deskripsi:** Memungkinkan admin menambah, mengubah, atau menghapus tempat wisata.
*   **Pre-condition:** Admin sudah login.
*   **Post-condition:** Data wisata di database berhasil diperbarui.
*   **Skenario Utama:**
    1. Admin membuka halaman `admin/wisata.php`.
    2. Sistem menampilkan tabel daftar wisata beserta tombol aksi (Tambah, Edit, Hapus).
    3. **Jika Tambah:** Admin mengisi form tambah wisata, upload foto, lalu simpan. Sistem menyimpan ke database.
    4. **Jika Edit:** Admin mengubah isi form data lama, lalu simpan. Sistem memperbarui database.
    5. **Jika Hapus:** Admin mengkonfirmasi penghapusan. Sistem menghapus data dari database.

#### UC11: Mengelola Data Kuliner
*   **Aktor:** Admin
*   **Deskripsi:** Memungkinkan admin melakukan operasi CRUD (Create, Read, Update, Delete) pada data kuliner.
*   **Pre-condition:** Admin sudah login.
*   **Post-condition:** Data kuliner di database berhasil diperbarui.
*   **Skenario Utama:**
    1. Admin membuka halaman `admin/kuliner.php`.
    2. Sistem menampilkan tabel data kuliner.
    3. Admin melakukan aksi Tambah, Edit, atau Hapus data kuliner (menggunakan form di `tambah_kuliner.php` atau `edit_kuliner.php`).
    4. Sistem memproses permintaan, memperbarui database, dan menampilkan pesan sukses.

#### UC12: Mengelola Data Event
*   **Aktor:** Admin
*   **Deskripsi:** Memungkinkan admin menambah event baru, mengedit info event, atau menghapus event usang.
*   **Pre-condition:** Admin sudah login.
*   **Post-condition:** Data event di database berhasil diperbarui.
*   **Skenario Utama:**
    1. Admin membuka halaman `admin/event.php`.
    2. Sistem menampilkan list event yang ada.
    3. Admin dapat menambah event baru (`tambah_event.php`), mengedit (`edit_event.php`), atau menghapus event (`hapus_event.php`).
    4. Sistem menyimpan perubahan gambar dan teks deskripsi event ke dalam database.

#### UC13: Logout Admin
*   **Aktor:** Admin
*   **Deskripsi:** Mengakhiri sesi administrasi.
*   **Pre-condition:** Admin sedang dalam keadaan login.
*   **Post-condition:** Sesi login admin dihancurkan, dan akses ke halaman panel dicabut.
*   **Skenario Utama:**
    1. Admin menekan opsi "Logout" di panel admin.
    2. Sistem menghapus seluruh session admin.
    3. Sistem mengarahkan admin kembali ke halaman login admin.
