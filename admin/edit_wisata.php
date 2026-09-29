<?php
include '../config.php';
include 'auth.php';
use App\Repositories\WisataRepository;

$id = $_GET['id'];
$wisataRepo = new WisataRepository($conn);
$data = $wisataRepo->getById($id);

if(isset($_POST['submit'])){

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // kalau upload gambar baru
    if($gambar != ""){
        $gambar_baru = time()."_".$gambar;
        move_uploaded_file($tmp, "../assets/img/".$gambar_baru);
    }else{
        $gambar_baru = $data['gambar'];
    }

    $wisataRepo->update($id, [
        'nama' => $_POST['nama'],
        'deskripsi' => $_POST['deskripsi'],
        'lokasi' => $_POST['lokasi'],
        'kategori' => $_POST['kategori'],
        'gambar' => $gambar_baru,
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
        <h4 class="m-0" style="font-weight: 600;">Edit Wisata</h4>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= htmlspecialchars($data['lokasi']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control">
                <option value="alam" <?= ($data['kategori']=='alam')?'selected':'' ?>>Alam</option>
                <option value="buatan" <?= ($data['kategori']=='buatan')?'selected':'' ?>>Buatan</option>
                <option value="religi" <?= ($data['kategori']=='religi')?'selected':'' ?>>Religi</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar Lama</label><br>
            <img src="../assets/img/<?= $data['gambar'] ?>" width="100" class="rounded shadow-sm">
        </div>

        <div class="mb-3">
            <label>Ganti Gambar</label>
            <input type="file" name="gambar" class="form-control">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" value="<?= htmlspecialchars($data['latitude']) ?>" class="form-control" placeholder="-7.12345">
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" value="<?= htmlspecialchars($data['longitude']) ?>" class="form-control" placeholder="111.12345">
        </div>

        <button class="btn btn-warning text-white" name="submit">Update</button>
        <a href="wisata.php" class="btn btn-secondary">Kembali</a>

    </form>

</div>
<?php
$content = ob_get_clean();
$active_page = 'wisata.php';
include 'layout.php';
?>