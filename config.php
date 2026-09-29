<?php
session_start();

// Autoloader buatan sendiri, agar tidak butuh folder vendor sama sekali!
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});

$conn = mysqli_connect("localhost", "root", "", "wisata-nganjuk");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>