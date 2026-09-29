<?php
include '../config.php';
include 'auth.php';
use App\Repositories\KulinerRepository;

$id = $_GET['id'];
$kulinerRepo = new KulinerRepository($conn);

$data = $kulinerRepo->getById($id);
if ($data && $data['gambar'] != '' && file_exists("../assets/img/" . $data['gambar'])) {
    unlink("../assets/img/" . $data['gambar']);
}

$kulinerRepo->delete($id);

header("Location: kuliner.php");