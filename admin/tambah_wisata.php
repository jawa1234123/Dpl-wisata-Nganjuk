<?php
include '../config.php';
include 'auth.php';
use App\Repositories\WisataRepository;

if(isset($_POST['submit'])){
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar != "") {
        $gambar = time() . "_" . $gambar;
        move_uploaded_file($tmp, "../assets/img/".$gambar);
    }

    $wisataRepo = new WisataRepository($conn);
    $wisataRepo->create([
        'nama' => $_POST['nama'],
        'deskripsi' => $_POST['deskripsi'],
        'lokasi' => $_POST['lokasi'],
        'kategori' => $_POST['kategori'],
        'gambar' => $gambar,
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude']
    ]);

    header("Location: wisata.php");
    exit;
}
?>

<?php ob_start(); ?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Tambah Wisata</h4>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control">
                <option value="alam">Alam</option>
                <option value="buatan">Buatan</option>
                <option value="religi">Religi</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" placeholder="-7.12345">
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" placeholder="111.12345">
        </div>

        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <a href="wisata.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php
$content = ob_get_clean();
$active_page = 'wisata.php';
include 'layout.php';
?>