<?php
include '../config.php';
use App\Repositories\WisataRepository;

$wisataRepo = new WisataRepository($conn);
$wisataList = $wisataRepo->getAll();

ob_start();
?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Data Destinasi Wisata</h4>
        <a href="tambah_wisata.php" class="btn btn-success"><i class="fa-solid fa-plus me-2"></i> Tambah Wisata</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Wisata</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($wisataList as $d){ ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="../assets/img/<?= $d['gambar'] ?>" width="80" class="rounded shadow-sm" onerror="this.src='../assets/img/default.jpg'">
                    </td>
                    <td class="fw-medium text-dark"><?= $d['nama'] ?></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><?= $d['kategori'] ?></span></td>
                    <td class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> <?= $d['lokasi'] ?></td>
                    <td class="text-center">
                        <a href="edit_wisata.php?id=<?= $d['id'] ?>&tipe=wisata" class="btn btn-sm btn-warning me-1" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="hapus_wisata.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data wisata ini?');">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
$active_page = 'wisata.php';
include 'layout.php';
?>