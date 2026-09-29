<?php
include '../config.php';
include 'auth.php';
use App\Repositories\EventRepository;

if(isset($_POST['submit'])){

    $file   = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $nama_file = "";

    if($file != ""){
        $nama_file = time().'_'.$file;
        move_uploaded_file($tmp, "../assets/img/".$nama_file);
    }

    $eventRepo = new EventRepository($conn);
    $eventRepo->create([
        'judul' => $_POST['judul'],
        'deskripsi' => $_POST['deskripsi'],
        'tanggal' => $_POST['tanggal'],
        'lokasi' => $_POST['lokasi'],
        'gambar' => $nama_file
    ]);

    header("Location: event.php");
    exit;
}
?>

<?php ob_start(); ?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Tambah Event</h4>
    </div>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="judul" placeholder="Judul Event" class="form-control mb-2" required>

<textarea name="deskripsi" placeholder="Deskripsi" class="form-control mb-2" required></textarea>

<input type="date" name="tanggal" class="form-control mb-2" required>

<input type="text" name="lokasi" placeholder="Lokasi" class="form-control mb-2" required>

<input type="file" name="gambar" class="form-control mb-2" required>

<button name="submit" class="btn btn-success">Simpan</button>
<a href="event.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
<?php
$content = ob_get_clean();
$active_page = 'event.php';
include 'layout.php';
?>