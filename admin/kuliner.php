<?php
include '../config.php';
use App\Repositories\KulinerRepository;

$kulinerRepo = new KulinerRepository($conn);
$kulinerList = $kulinerRepo->getAll();

ob_start();
?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Data Kuliner Khas</h4>
        <a href="tambah_kuliner.php?tipe=kuliner" class="btn btn-success"><i class="fa-solid fa-plus me-2"></i> Tambah Kuliner</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kuliner</th>
                    <th>Lokasi</th>
                    <th>Jam Operasional</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($kulinerList as $d){ ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td class="fw-medium text-dark"><?= $d['nama_kuliner'] ?></td>
                    <td class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> <?= $d['lokasi'] ?></td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><i class="fa-solid fa-clock me-1"></i> <?= $d['jam_buka'] ?></span></td>
                    <td class="text-center">
                        <a href="edit_kuliner.php?id=<?= $d['id'] ?>&tipe=kuliner" class="btn btn-sm btn-warning me-1" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="hapus_kuliner.php?id=<?= $d['id'] ?>&tipe=kuliner" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data kuliner ini?');">
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
$active_page = 'kuliner.php';
include 'layout.php';
?>