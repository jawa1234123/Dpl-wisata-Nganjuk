<?php
include '../config.php';
include 'auth.php';
use App\Repositories\KulinerRepository;

if(isset($_POST['submit'])){
    $file = $_FILES['gambar']['name'];
    $tmp  = $_FILES['gambar']['tmp_name'];
    $nama_file = "";

    if($file != ""){
        $nama_file = time() . '_' . $file;
        move_uploaded_file($tmp, "../assets/img/" . $nama_file);
    }

    $kulinerRepo = new KulinerRepository($conn);
    $kulinerRepo->create([
        'nama_kuliner' => $_POST['nama'],
        'lokasi' => $_POST['lokasi'],
        'deskripsi' => $_POST['deskripsi'],
        'jam_buka' => $_POST['jam_buka'],
        'gambar' => $nama_file
    ]);

    header("Location: kuliner.php");
    exit;
}
?>

<?php ob_start(); ?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Tambah Kuliner</h4>
    </div>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="nama" placeholder="Nama Kuliner" class="form-control mb-2" required>

    <input type="text" name="lokasi" placeholder="Lokasi" class="form-control mb-2" required>

    <!-- DESKRIPSI -->
    <textarea name="deskripsi" placeholder="Deskripsi kuliner" class="form-control mb-2" required></textarea>

    <!-- JAM BUKA -->
    <input type="text" name="jam_buka" placeholder="Jam buka (contoh: 08.00 - 21.00)" class="form-control mb-2" required>

    <input type="file" name="gambar" class="form-control mb-2" required>

    <button name="submit" class="btn btn-success">Simpan</button>
    <a href="kuliner.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
<?php
$content = ob_get_clean();
$active_page = 'kuliner.php';
include 'layout.php';
?>