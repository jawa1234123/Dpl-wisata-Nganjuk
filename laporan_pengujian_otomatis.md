# TEST DESIGN SPECIFICATION FROM INSPECTION CHECKLIST

**Kelas PKPL** : *[Isi Kelas Anda]*
**Nomor Kelompok** : *[Isi Nomor Kelompok]*

| Nama Anggota Kelompok | NIM |
| :--- | :--- |
| *[Nama Anggota 1]* | *[NIM Anggota 1]* |
| *[Nama Anggota 2]* | *[NIM Anggota 2]* |
| *[Nama Anggota 3]* | *[NIM Anggota 3]* |

## Coverage Items for Security

| ID | Kriteria | Related Test Condition | Link GitHub pengerjaan testing | Tangkap Layar Total test case berbanding successful test |
| :--- | :--- | :--- | :--- | :--- |
| NFR-001 | Mencegah celah SQL Injection pada parameter yang dikirim melalui URL dan Form input. | Modul: `detail_wisata.php`, `detail_kuliner.php`. Parameter ID harus selalu di-cast menjadi tipe data *integer* dan input difilter menggunakan `mysqli_real_escape_string`. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil PHPStan/SonarQube]* |
| NFR-002 | Mengamankan *password* menggunakan fungsi enkripsi *hash* modern yang tahan terhadap serangan *rainbow tables*. | Modul: `login_user.php`, `forgot_password.php`. Mengganti fungsi MD5 dengan `password_hash()` dan `password_verify()`. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil PHPStan/SonarQube]* |
| NFR-007 | Mencegah kerentanan *Cross-Site Scripting* (XSS) pada saat menampilkan data dari *database* ke halaman HTML. | Modul: `detail_wisata.php`, `detail_kuliner.php`. Output variabel seperti judul, lokasi, dan deskripsi harus dibungkus dengan fungsi `htmlspecialchars()`. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil SonarQube]* |

## Coverage Items for Maintainability

| ID | Kriteria | Related Test Condition | Link GitHub pengerjaan testing | Tangkap Layar Test case / successful test |
| :--- | :--- | :--- | :--- | :--- |
| NFR-003 | Standarisasi penulisan kode sumber agar mudah dibaca dan dipelihara. Tidak ada penggunaan sintaks *deprecated*. | Modul: Semua *script* PHP. Menghindari pemakaian gaya penulisan tak baku serta memastikan identasi dan kurawal yang konsisten sesuai standar PSR-12. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil PHP_CodeSniffer]* |
| NFR-004 | Memastikan redundansi kode *(Code Duplication)* dan kompleksitas logika ditekan seminimal mungkin (Cyclomatic Complexity rendah). | Modul: `detail_wisata.php`, `detail_kuliner.php`. Proses cek ulasan ganda telah disatukan secara logis sehingga terhindar dari if-else yang terlalu dalam. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil SonarQube]* |
| NFR-008 | Menggunakan *Prepared Statements* (Parameterized Queries) sebagai standar eksekusi *query* ke *database* untuk keamanan dan pemeliharaan jangka panjang. | Modul: `detail_wisata.php`. Mengganti pola penggabungan *string* secara langsung dalam `mysqli_query` menjadi `mysqli_prepare` dan `bind_param`. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil PHPStan/SonarQube]* |

## Coverage Items for Reliability (Logic / Functional)

| ID | Kriteria | Related Test Condition | Link GitHub pengerjaan testing | Tangkap Layar Test case / successful test |
| :--- | :--- | :--- | :--- | :--- |
| NFR-005 | Setiap *user* hanya dapat memberikan 1 *rating* pada setiap fasilitas/wisata (batasan unik per item). | Modul: `detail_wisata.php`. Validasi di level aplikasi untuk memunculkan mode *edit* atau *hapus* ketika *user* sudah memiliki riwayat ulasan pada entitas terkait. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil Tes Logika]* |
| NFR-006 | Notifikasi tindakan secara *real-time* kepada *user* yang sukses, gagal, atau menghapus item. | Modul: `detail_wisata.php`, `detail_kuliner.php`. Penggunaan alert *JavaScript (SweetAlert)* agar *user experience* andal. | [Link Commit / PR GitHub] | *[Sisipkan Gambar Hasil Tes UI/Logic]* |

