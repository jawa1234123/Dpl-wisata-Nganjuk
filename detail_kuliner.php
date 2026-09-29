<?php
include 'config.php';
use App\Repositories\KulinerRepository;

// VALIDASI ID
if(!isset($_GET['id']) || $_GET['id'] == ''){
    echo "<h2 style='text-align:center;margin-top:50px;font-family:sans-serif;'>ID tidak ditemukan</h2>";
    exit;
}

$id = (int)$_GET['id'];

// AMBIL DATA
$kulinerRepo = new KulinerRepository($conn);
$data = $kulinerRepo->getById($id);

// CEK DATA
if(!$data){
    echo "<h2 style='text-align:center;margin-top:50px;font-family:sans-serif;'>Data tidak ditemukan</h2>";
    exit;
}

// FUNCTION SAFE
// FUNCTION SAFE
function safe($data, $key, $default='-'){
    return isset($data[$key]) && $data[$key] != '' ? $data[$key] : $default;
}

// Proses tambah ulasan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $rating = (int)$_POST['rating'];
        $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
        mysqli_query($conn, "INSERT INTO reviews (tipe, item_id, user_id, rating, komentar) VALUES ('kuliner', $id, $user_id, $rating, '$komentar')");
        header("Location: detail_kuliner.php?id=$id&review_success=1");
        exit;
    } else {
        $error_msg = "Anda harus login untuk memberikan ulasan.";
    }
}

// Ambil data ulasan
$q_reviews = mysqli_query($conn, "SELECT r.*, u.nama as nama_user FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.tipe='kuliner' AND r.item_id=$id ORDER BY r.id DESC");
$reviews = [];
while($row = mysqli_fetch_assoc($q_reviews)) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= safe($data,'nama_kuliner') ?> - Wonderful Nganjuk</title>
    
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
            --accent-gold: #ca8a04; /* Kuning Emas Nganjuk */
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
            background: var(--accent-gold);
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
            color: var(--accent-gold);
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
            border-left: 5px solid var(--accent-gold);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-icon {
            font-size: 1.5rem;
            color: var(--accent-gold);
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
            color: var(--accent-gold);
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
    <img src="assets/img/<?= safe($data,'gambar','default.jpg') ?>" onerror="this.src='assets/img/default.jpg'" alt="<?= safe($data,'nama_kuliner') ?>">
    <div class="hero-overlay"></div>
    
    <div class="hero-text">
        <span class="badge-kategori">Kuliner Khas</span>
        <h1><?= safe($data,'nama_kuliner') ?></h1>
        <div class="location"><i class="fa-solid fa-location-dot text-danger me-2"></i> <?= safe($data,'lokasi') ?></div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="content-wrapper">
    <div class="article-content">
        
        <p><?= nl2br(safe($data,'deskripsi','Kuliner khas Nganjuk yang sangat direkomendasikan dan wajib Anda coba saat berkunjung ke Kota Angin ini. Rasanya yang autentik pasti akan membuat Anda ketagihan.')) ?></p>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="info-text">
                    <h4>Alamat Lokasi</h4>
                    <p><?= safe($data,'lokasi') ?></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="info-text">
                    <h4>Jam Operasional</h4>
                    <p><?= safe($data,'jam_buka','Tersedia setiap hari') ?></p>
                </div>
            </div>
        </div>

        <div class="map-section" style="margin-top: 50px;">
            <h2 style="font-size: 2rem; margin-bottom: 30px; text-align: center;">Peta Lokasi</h2>
            <div class="map-container" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <iframe src="https://maps.google.com/maps?q=<?= urlencode(safe($data,'lokasi') . ', Nganjuk') ?>&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>

        <!-- REVIEWS SECTION -->
        <div class="reviews-section" style="margin-top: 50px;">
            <h2 style="font-size: 2rem; margin-bottom: 30px; text-align: center;">Ulasan Pengunjung</h2>
            
            <?php if(isset($error_msg)): ?>
                <div class="alert alert-danger"><?= $error_msg ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="card mb-4" style="border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Tulis Ulasan Anda</h5>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" required style="width: 150px;">
                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                <option value="3">⭐⭐⭐ (3/5)</option>
                                <option value="2">⭐⭐ (2/5)</option>
                                <option value="1">⭐ (1/5)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea name="komentar" class="form-control" rows="3" required placeholder="Bagaimana pengalaman Anda?"></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-warning text-white" style="background: var(--accent-gold); border: none; padding: 10px 25px; border-radius: 30px;">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center" style="border-radius: 10px;">
                Silakan <a href="login_user.php" class="alert-link">Login</a> untuk memberikan ulasan.
            </div>
            <?php endif; ?>

            <div class="review-list">
                <?php if(count($reviews) > 0): ?>
                    <?php foreach($reviews as $rev): ?>
                    <div class="card mb-3" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border-radius: 10px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0" style="font-weight: 700; color: var(--text-main);"><i class="fa-solid fa-circle-user text-muted me-2"></i><?= htmlspecialchars($rev['nama_user']) ?></h6>
                                <div class="text-warning" style="font-size: 0.9rem;">
                                    <?= str_repeat('⭐', $rev['rating']) ?>
                                </div>
                            </div>
                            <small class="text-muted d-block mb-2"><?= date('d M Y, H:i', strtotime($rev['created_at'])) ?></small>
                            <p class="mb-0" style="color: #475569;"><?= nl2br(htmlspecialchars($rev['komentar'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada ulasan untuk kuliner ini. Jadilah yang pertama!</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- END REVIEWS -->

        <div class="share-section" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0; text-align: center;">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 600; margin-bottom: 15px;">Bagikan ke Teman:</h4>
            <a href="https://wa.me/?text=Cobain Kuliner <?= urlencode(safe($data,'nama_kuliner')) ?> di Nganjuk: <?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" target="_blank" class="btn btn-success rounded-circle me-2" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" target="_blank" class="btn btn-primary rounded-circle me-2" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>&text=Cobain Kuliner <?= urlencode(safe($data,'nama_kuliner')) ?> di Nganjuk!" target="_blank" class="btn btn-info text-white rounded-circle" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-twitter"></i></a>
        </div>

    </div>
</div>

<footer>
    <div class="footer-logo">Wonderful <span>Nganjuk</span></div>
    &copy; <?= date('Y') ?> Wisata Nganjuk
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('review_success')) {
        Swal.fire({
            icon: 'success',
            title: 'Terima Kasih!',
            text: 'Ulasan Anda berhasil dikirimkan.',
            timer: 3000,
            showConfirmButton: false
        });
        urlParams.delete('review_success');
        let newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState({}, document.title, newUrl);
    }
</script>
</body>
</html>
