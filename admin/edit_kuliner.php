<?php
include '../config.php';
include 'auth.php';
use App\Repositories\KulinerRepository;

$id = $_GET['id'];
$kulinerRepo = new KulinerRepository($conn);
$data = $kulinerRepo->getById($id);

if(isset($_POST['submit'])){

    // upload gambar
    if($_FILES['gambar']['name']){
        $file = $_FILES['gambar']['name'];
        $tmp  = $_FILES['gambar']['tmp_name'];

        $nama_file = time() . '_' . $file;

        move_uploaded_file($tmp,"../assets/img/".$nama_file);

        $gambar = $nama_file;
    }else{
        $gambar = $data['gambar'];
    }

    $kulinerRepo->update($id, [
        'nama_kuliner' => $_POST['nama'],
        'lokasi' => $_POST['lokasi'],
        'deskripsi' => $_POST['deskripsi'],
        'jam_buka' => $_POST['jam_buka'],
        'gambar' => $gambar
    ]);

    header("Location: kuliner.php");
    exit;
}
?>

<?php ob_start(); ?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Edit Kuliner</h4>
    </div>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="nama" 
        value="<?= $data['nama_kuliner'] ?>" 
        class="form-control mb-2">

    <input type="text" name="lokasi" 
        value="<?= $data['lokasi'] ?>" 
        class="form-control mb-2">

    <!-- DESKRIPSI -->
    <textarea name="deskripsi" class="form-control mb-2"><?= $data['deskripsi'] ?></textarea>

    <!-- JAM BUKA -->
    <input type="text" name="jam_buka" 
        value="<?= $data['jam_buka'] ?>" 
        class="form-control mb-2">

    <!-- GAMBAR LAMA -->
    <img src="../assets/img/<?= $data['gambar'] ?>" width="120" style="border-radius:10px"><br><br>

    <!-- GANTI GAMBAR -->
    <input type="file" name="gambar" class="form-control mb-2">

    <button name="submit" class="btn btn-warning text-white">Update</button>
    <a href="kuliner.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
<?php
$content = ob_get_clean();
$active_page = 'kuliner.php';
include 'layout.php';
?>