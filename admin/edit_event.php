<?php
include '../config.php';
include 'auth.php';
use App\Repositories\EventRepository;

$id = $_GET['id'];
$eventRepo = new EventRepository($conn);
$d = $eventRepo->getById($id);

if(isset($_POST['update'])){

    $file = $_FILES['gambar']['name'];

    if($file != ""){
        $tmp = $_FILES['gambar']['tmp_name'];
        $nama_file = time().'_'.$file;
        move_uploaded_file($tmp,"../assets/img/".$nama_file);
    } else {
        $nama_file = $d['gambar'];
    }

    $eventRepo->update($id, [
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
        <h4 class="m-0" style="font-weight: 600;">Edit Event</h4>
    </div>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="judul" value="<?= $d['judul'] ?>" class="form-control mb-2">

<textarea name="deskripsi" class="form-control mb-2"><?= $d['deskripsi'] ?></textarea>

<input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" class="form-control mb-2">

<input type="text" name="lokasi" value="<?= $d['lokasi'] ?>" class="form-control mb-2">

<input type="file" name="gambar" class="form-control mb-2">

<button name="update" class="btn btn-warning text-white">Update</button>
<a href="event.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
<?php
$content = ob_get_clean();
$active_page = 'event.php';
include 'layout.php';
?>