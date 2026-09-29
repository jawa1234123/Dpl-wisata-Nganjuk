<?php
include '../config.php';
include 'auth.php';
use App\Repositories\EventRepository;

$id = $_GET['id'];
$eventRepo = new EventRepository($conn);

$data = $eventRepo->getById($id);
if ($data && $data['gambar'] != '' && file_exists("../assets/img/" . $data['gambar'])) {
    unlink("../assets/img/" . $data['gambar']);
}

$eventRepo->delete($id);

header("Location: event.php");