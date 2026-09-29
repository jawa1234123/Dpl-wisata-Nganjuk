<?php
include 'config.php';
use App\Repositories\EventRepository;

// VALIDASI ID
if(!isset($_GET['id']) || $_GET['id'] == ''){
    echo "<h2 style='text-align:center;margin-top:50px;font-family:sans-serif;'>ID tidak ditemukan</h2>";
    exit;
}

$id = (int)$_GET['id'];

// AMBIL DATA
$eventRepo = new EventRepository($conn);
$data = $eventRepo->getById($id);

if(!$data){
    echo "<h2 style='text-align:center;margin-top:50px;font-family:sans-serif;'>Data tidak ditemukan</h2>";
    exit;
}

// SAFE FUNCTION
function safe($data, $key, $default='-'){
    return isset($data[$key]) && $data[$key] != '' ? $data[$key] : $default;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= safe($data,'judul') ?> - Wonderful Nganjuk</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --accent-red: #0369a1; /* Biru Nganjuk */
        }

        body {
            margin: 0;
            background: var(--bg-light);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .brand-text {
            font-family: 'Playfair Display', serif;
        }

        /* NAVBAR */
        .navbar-custom {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 5%;
            z-index: 100;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            background: rgba(0,0,0,0.4);
            padding: 10px 20px;
            border-radius: 30px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            font-weight: 500;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-back:hover {
            background: white;
            color: var(--text-main);
        }

        /* HERO HEADER */
        .hero-header {
            position: relative;
            height: 70vh;
            width: 100%;
        }

        .hero-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.7) 100%);
        }

        .hero-text {
            position: absolute;
            bottom: 50px;
            left: 5%;
            color: white;
            z-index: 10;
        }

        .badge-kategori {
            background: var(--accent-red);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.5);
            font-style: italic;
        }

        .hero-text .location {
            font-size: 1.2rem;
            font-weight: 400;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }

        /* MAIN CONTENT */
        .content-wrapper {
            background: var(--bg-white);
            padding: 60px 5%;
            margin-top: -20px;
            position: relative;
            z-index: 20;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }

        .article-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .article-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 25px;
            text-align: justify;
        }

        .article-content p:first-of-type::first-letter {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            float: left;
            line-height: 0.8;
            margin-right: 15px;
            margin-top: 5px;
            color: var(--accent-red);
            font-weight: 700;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 50px 0;
            background: var(--bg-light);
            padding: 40px;
            border-radius: 16px;
            border-left: 5px solid var(--accent-red);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-icon {
            font-size: 1.5rem;
            color: var(--accent-red);
            background: white;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .info-text h4 {
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .info-text p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin: 0;
            text-align: left;
        }
        
        .info-text p::first-letter {
            font-size: 0.95rem;
            font-family: 'Montserrat', sans-serif;
            float: none;
            color: var(--text-muted);
        }

        footer {
            background: #1e293b;
            color: white;
            text-align: center;
            padding: 40px 0;
        }
        
        .footer-logo {
            font-family: 'Playfair Display', serif; 
            font-size: 1.5rem; 
            margin-bottom: 10px;
        }
        .footer-logo span {
            color: var(--accent-red);
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar-custom">
    <a href="index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<!-- HERO HEADER -->
<div class="hero-header">
    <img src="assets/img/<?= safe($data,'gambar','default.jpg') ?>" onerror="this.src='assets/img/default.jpg'" alt="<?= safe($data,'judul') ?>">
    <div class="hero-overlay"></div>
    
    <div class="hero-text">
        <span class="badge-kategori">Event Budaya</span>
        <h1><?= safe($data,'judul') ?></h1>
        <div class="location"><i class="fa-solid fa-location-dot text-danger me-2"></i> <?= safe($data,'lokasi') ?></div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="content-wrapper">
    <div class="article-content">
        
        <p><?= nl2br(safe($data,'deskripsi','Belum ada deskripsi mendetail mengenai event ini. Nantikan keseruannya hanya di Kabupaten Nganjuk!')) ?></p>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="info-text">
                    <h4>Lokasi Pelaksanaan</h4>
                    <p><?= safe($data,'lokasi') ?></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-calendar-day"></i></div>
                <div class="info-text">
                    <h4>Tanggal Event</h4>
                    <p><?= safe($data,'tanggal') ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

<footer>
    <div class="footer-logo">Wonderful <span>Nganjuk</span></div>
    &copy; <?= date('Y') ?> Wisata Nganjuk
</footer>

</body>
</html>