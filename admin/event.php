<?php
include '../config.php';
use App\Repositories\EventRepository;

$eventRepo = new EventRepository($conn);
$eventList = $eventRepo->getAll();

ob_start();
?>
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0" style="font-weight: 600;">Data Event Budaya</h4>
        <a href="tambah_event.php" class="btn btn-success"><i class="fa-solid fa-plus me-2"></i> Tambah Event</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul Event</th>
                    <th>Lokasi</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($eventList as $d){ ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="../assets/img/<?= $d['gambar'] ?>" width="80" class="rounded shadow-sm" onerror="this.src='../assets/img/default.jpg'">
                    </td>
                    <td class="fw-medium text-dark"><?= $d['judul'] ?></td>
                    <td class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> <?= $d['lokasi'] ?></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill"><i class="fa-solid fa-calendar-day me-1"></i> <?= $d['tanggal'] ?></span></td>
                    <td class="text-center">
                        <a href="edit_event.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="hapus_event.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data event ini?');">
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
$active_page = 'event.php';
include 'layout.php';
?>