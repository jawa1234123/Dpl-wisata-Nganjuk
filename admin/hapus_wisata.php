<?php
include '../config.php';
include 'auth.php';
use App\Repositories\WisataRepository;

$id = $_GET['id'];
$wisataRepo = new WisataRepository($conn);

// Hapus gambar lama jika ada
$data = $wisataRepo->getById($id);
if ($data && $data['gambar'] != '' && file_exists("../assets/img/" . $data['gambar'])) {
    unlink("../assets/img/" . $data['gambar']);
}

$wisataRepo->delete($id);

header("Location: wisata.php");