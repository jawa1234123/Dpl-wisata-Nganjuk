<?php
include 'config.php';
$q = $_GET['q'] ?? '';
$q_safe = mysqli_real_escape_string($conn, $q);

$results = [];

if($q != ''){
    // Pencarian di Wisata
    $q_wisata = mysqli_query($conn, "SELECT id, nama as judul, deskripsi, gambar, 'wisata' as jenis FROM wisata WHERE nama LIKE '%$q_safe%' OR deskripsi LIKE '%$q_safe%'");
    while($row = mysqli_fetch_assoc($q_wisata)) $results[] = $row;

    // Pencarian di Kuliner 
    $q_kuliner = mysqli_query($conn, "SELECT id, nama_kuliner as judul, deskripsi, gambar, 'kuliner' as jenis FROM kuliner WHERE nama_kuliner LIKE '%$q_safe%' OR deskripsi LIKE '%$q_safe%'");
    while($row = mysqli_fetch_assoc($q_kuliner)) $results[] = $row;

    // Pencarian di Event
    $q_event = mysqli_query($conn, "SELECT id, judul, deskripsi, gambar, 'event' as jenis FROM event WHERE judul LIKE '%$q_safe%' OR deskripsi LIKE '%$q_safe%'");
    while($row = mysqli_fetch_assoc($q_event)) $results[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian: <?= htmlspecialchars($q) ?> - Wonderful Nganjuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --accent-green: #15803d;  
        }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: var(--bg-light); color: var(--text-main); overflow-x: hidden; padding-top: 80px; }
        h1, h2, h3, h4, h5, .brand-text { font-family: 'Playfair Display', serif; }
        .navbar-custom { position: fixed; top: 0; left: 0; width: 100%; padding: 15px 5%; z-index: 1000; display: flex; justify-content: space-between; align-items: center; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .navbar-brand { font-size: 1.5rem; font-weight: 700; color: var(--text-main); text-decoration: none; display: flex; align-items: center; line-height: 1.2; }
        .navbar-brand span { color: var(--accent-green); font-size: 1rem; font-weight: 400; }
        .nav-links { display: flex; gap: 25px; }
        .nav-links a { text-decoration: none; color: #6b7280; font-weight: 500; font-size: 0.95rem; transition: color 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #ef4444; }
        
        .page-header { padding: 60px 5% 40px; background: white; text-align: center; border-bottom: 1px solid #e2e8f0; margin-bottom: 40px; }
        .page-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 15px; }
        
        .content-container { padding: 0 5% 60px; min-height: 50vh; }
        
        .card-item { border-radius: 10px; overflow: hidden; position: relative; transition: all 0.4s ease; text-decoration: none; background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; height: 100%; }
        .card-img-wrapper { width: 100%; height: 200px; overflow: hidden; position: relative; }
        .card-item:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-color: transparent; }
        .card-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 1s ease; }
        .card-item:hover img { transform: scale(1.05); }
        .card-badge { position: absolute; top: 15px; left: 15px; background: var(--accent-green); color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; z-index: 2; }
        
        .card-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        .card-item h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px; }
        .card-item p { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-footer { margin-top: auto; display: flex; align-items: center; font-size: 0.8rem; color: var(--accent-green); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        
        footer { background: var(--bg-white); padding: 40px 5%; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer-logo { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--text-main); margin-bottom: 15px; }
        .footer-logo span { color: var(--accent-green); }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <a href="index.php" class="navbar-brand">
        <img src="assets/img/imgbin-nganjuk-regency-logo-sedudo-waterfall-others-E7KLt8zCV21fNhya7677U5e77.jpg" alt="Logo Nganjuk" style="height: 50px; margin-right: 12px;">
        <div>
            Wonderful<br>
            <span>Nganjuk</span>
        </div>
    </a>
    <div class="nav-links d-none d-md-flex">
        <a href="index.php">Home</a>
        <a href="wisata.php">Wisata</a>
        <a href="kuliner.php">Kuliner</a>
        <a href="event.php">Event</a>
    </div>
    <div class="nav-actions">
        <form action="search.php" method="GET" class="d-flex align-items-center rounded-pill px-3 py-1" style="border: 1px solid #e2e8f0; background: #f8fafc;">
            <input type="text" name="q" placeholder="Cari wisata, kuliner..." value="<?= htmlspecialchars($q) ?>" class="form-control bg-transparent border-0 shadow-none p-0 me-2" style="width: 180px; font-size: 0.9rem;" required>
            <button type="submit" class="btn p-0 border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></button>
        </form>
    </div>
</nav>

<div class="page-header">
    <h1>Hasil Pencarian</h1>
    <p>Menampilkan hasil pencarian untuk: <strong>"<?= htmlspecialchars($q) ?>"</strong></p>
</div>

<div class="content-container">
    <?php if(count($results) > 0): ?>
        <div class="row g-4">
            <?php foreach($results as $d): 
                $link = "detail_".$d['jenis'].".php?id=".$d['id'];
                $badge = ucfirst($d['jenis']);
            ?>
            <div class="col-12 col-md-4 col-lg-3">
                <a href="<?= $link ?>" class="card-item">
                    <div class="card-img-wrapper">
                        <span class="card-badge"><?= $badge ?></span>
                        <img src="assets/img/<?= $d['gambar'] ?>" onerror="this.src='assets/img/default.jpg'" alt="Gambar">
                    </div>
                    <div class="card-content">
                        <h3><?= htmlspecialchars($d['judul']) ?></h3>
                        <p><?= htmlspecialchars(substr($d['deskripsi'] ?? '', 0, 100)) ?>...</p>
                        <div class="card-footer">
                            Lihat Detail <i class="fa-solid fa-arrow-right-long ms-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-box-open text-muted mb-3" style="font-size: 4rem;"></i>
            <h3 class="text-muted">Tidak ada hasil yang ditemukan</h3>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda.</p>
        </div>
    <?php endif; ?>
</div>

<footer>
    <div class="footer-logo">Wonderful <span>Nganjuk</span></div>
    <p class="text-muted mb-0" style="font-size: 0.9rem;">&copy; <?= date('Y') ?> Dinas Pariwisata Kabupaten Nganjuk. All rights reserved.</p>
</footer>

</body>
</html>
